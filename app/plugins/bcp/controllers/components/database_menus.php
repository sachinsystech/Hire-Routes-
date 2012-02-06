<?php
/* SVN FILE: $Id$ */
/**
 * Database driven menus component.
 *
 * Uses database table 'menus' to generate Menus.
 *
 * PHP version 5
 * 
 * (C) Copyright 2009, Valerij Bancer (http://bancer.sourceforge.net)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author        Valerij Bancer
 * @link          http://www.bancer.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class DatabaseMenusComponent extends Object{

	/**
	 * Components used by Menu
	 * @var array
	 */
	public $components = array('Bcp.AclCached', 'Auth');

	/**
	 * Set to false to disable the auto menu generation in startup()
	 * Useful if you want your menus generated other than for the user in the current session.
	 * @var boolean
	 */
	public $autoLoad = true;

	/**
	 * Controller reference
	 * @var object
	 */
	public $Controller = null;

	/**
	 * Key for the caching
	 * @var string
	 */
	public $cacheKey = 'db_menu';

	/**
	 * Time to cache menus for.
	 * @var string  String compatible with strtotime.
	 */
	public $cacheTime = '+1 day';

	/**
	 * Cache config key
	 * @var string
	 */
	public $cacheConfig = 'menu_component';

	/**
	 * The completed main menu for the current user.
	 * @var array
	 */
	public $mainMenu = array();

	/**
	 * The completed extra menu for the current user for the current page.
	 * @var array
	 */
	public $extraMenu = array();

	/**
	 * The completed actions menu for the current user for the current page.
	 * @var array
	 */
	public $actionsMenu = array();

	/**
	 * Raw menus before formatting, either loaded from the database or loading Cache
	 * @var array
	 */
	public $rawMenus = array();

	public $breadcrumbs = array();

	/**
	 * Internal Flag to check if new menus have been added to a cached menu set.
	 * Indicates that new menu items have been added and that menus need to be rebuilt.
	 * @var boolean
	 */
	protected $_rebuildMenus = false;

	public function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}

	/**
	 * Startup Method
	 *
	 * Automatically makes menus for all a the controllers based on the current user.
	 * @param Object $Controller
	 */
	public function startup(&$controller){

		Cache::config($this->cacheConfig, array(
			'engine' => 'File',
			'duration' => $this->cacheTime,
			'prefix' => $this->cacheKey.'_'
		));

		// No active session, no menu can be generated
		if(!$this->Auth->user()){
			return;
		}
		if($this->autoLoad){
			$this->_loadCache();
			$this->_constructMenu('main');
			$this->_constructMenu('extra');
			$this->_constructMenu('actions');
			$this->_getBreadcrumbs();
			$this->_writeCache();
		}
	}

	/**
	 * BeforeRender Callback.
	 */
	public function beforeRender(&$Controller){
		$this->controller->set('mainMenu', $this->mainMenu);
		$this->controller->set('extraMenu', $this->extraMenu);
		$this->controller->set('actionsMenu', $this->actionsMenu);
		$this->controller->set('breadcrumbs', $this->breadcrumbs);
	}

	/**
	 * Method to generate any menu for any controller from anywhere
	 * 
	 * @param string $type - Menu type
	 * @param string $controller - Controller name
	 * @return array
	 */
	public function getMenu($type, $controller){
		return $this->_constructMenu($type, $controller);
	}

	/**
	 * Clears the raw Menu Cache, this will in turn force
	 * a menu rebuild for each ARO that needs a menu.
	 *
	 * @return boolean
	 **/
	public function clearCache(){
		return Cache::delete($this->cacheKey, $this->cacheConfig);
	}

	/**
	 * Write the current Block Access data to a file.
	 *
	 * @return boolean on success of writing a file.
	 */
	private function _writeCache(){
		if(Cache::write($this->cacheKey, $this->rawMenus, $this->cacheConfig)){
			return true;
		}
		$this->log('Database menu component could not write menu cache.');
		return false;
	}

	/**
	 * Load the cached menus and restore them
	 * 
	 * @return boolean true if cache was loaded.
	 */
	private function _loadCache(){
		if($data = Cache::read($this->cacheKey, $this->cacheConfig)){
			$this->rawMenus = $data;
			return true;
		}
		$this->_rebuildMenus = true;
		return false;
	}

	/**
	 * 
	 * @param string $type
	 * @param string $controller
	 * @return unknown_type
	 */
	private function _constructMenu($type, $controller = null){
		$cacheKey = $this->_makeCacheKey($type, $controller);
		$completeMenu = Cache::read($cacheKey, $this->cacheConfig);
		if(!$completeMenu || $this->_rebuildMenus == true){
			$this->_generateRawMenus();
			$menu = $this->_filterRawMenus($type, $controller);
			if($type == 'main'){
				$completeMenu = $this->_formatMenu($menu);
			}else{
				$completeMenu = $menu;
			}
			Cache::write($cacheKey, $completeMenu, $this->cacheConfig);
		}
		if(is_null($controller)){
			$this->{$type.'Menu'} = $completeMenu;
		}else{
			return $completeMenu;
		}
	}

	/**
	 * 
	 * @param string $menuType
	 * @param string $controller
	 * @return unknown_type
	 */
	private function _makeCacheKey($menuType, $controller = null){
		$aro = $this->Auth->user();
		$aroKey = $aro;
		if(is_array($aro)){
			$aroKey = key($aro).$aro[key($aro)]['id'];
		}
		$cacheKey = $aroKey.'_'.$menuType;
		if($menuType == 'extra' OR $menuType == 'actions'){
			if(is_null($controller)){
				$cacheKey .= '_'.strtolower($this->controller->name).'_'.$this->controller->action;
			}else{
				$cacheKey .= '_'.strtolower($controller).'_index';
			}
		}
		return $cacheKey;
	}

	/**
	 * 
	 * @param string $menuType
	 * @param string $controller
	 * @return unknown_type
	 */
	private function _filterRawMenus($menuType, $controller = null){
		$menu = array();
		$action = '';
		if(is_null($controller)){
			$controller = $this->controller->name;
			$action = $this->controller->action;
		}
		foreach($this->rawMenus as $item){
			if(
				($item['Menu']['type'] == 'extra' OR $item['Menu']['type'] == 'actions') AND
				$item['Menu']['controller'] != $controller OR
				$item['Menu']['method'] == $action
			){
				continue;
			}elseif($action == 'logout'){
				// Do not build any menu for logout action.
				break;
			}elseif($item['Menu']['type'] == $menuType){
				$aro = $this->Auth->user();
				$aco = array(
					'model' => $item['Aco']['model'],
					'foreign_key' => $item['Aco']['foreign_key']
				);
				if($this->AclCached->check($aro, $aco)){
					$menu[] = $item;
				}
			}
		}
		return $menu;
	}

	/**
	 * Generate Raw Menus from the database
	 * 
	 * @return void sets $this->rawMenus
	 */
	private function _generateRawMenus(){
		$menus = ClassRegistry::init('Menu');
		if(empty($this->rawMenus)){
			/* We need lft field for correct menus sorting. */
			$this->rawMenus = $menus->find('all', array(
				'recursive' => -1,
				'fields' => array(
					'Menu.id', 'Menu.type', 'Menu.name', 'Menu.parent_id', 'Menu.plugin', 'Menu.controller', 'Menu.method', 'Menu.published', 'Menu.created', 'Menu.modified',
					'Aco.id', 'Aco.parent_id', 'Aco.model', 'Aco.foreign_key', 'Aco.alias', 'Aco.lft', 'Aco.rght'
				),
				'conditions' => array(
					'Menu.published' => 1,
					"Aco.model = 'Menu'"
				),
				'order' => array('Aco.lft ASC'),
				'joins' => array(
					array(
						'table' => 'acos',
						'alias' => 'Aco',
						'type' => 'INNER',
						'conditions' => array('Aco.foreign_key = Menu.id')
					)
				)
			));
		}
	}

	/**
	 * Recursive function to construct Menu
	 * 
	 * @param array $menu
	 */
	private function _formatMenu($menu){
		$nodes = array();
		$tree = array();
		foreach($menu as &$node){
			$node['Children'] = array();
			$id = $node['Menu']['id'];
			$parent_id = $node['Menu']['parent_id'];
			$nodes[$id] =& $node;
			if(array_key_exists($parent_id, $nodes)){
				$nodes[$parent_id]['Children'][] =& $node;
			}else{
				$tree[] =& $node;
			}
		}
		return $tree;
	}

	/**
	 *  Method to generate array of breadcrumbs
	 *  
	 * @return $this->breadcrumbs
	 */
	private function _getBreadcrumbs(){
		$this->_generateRawMenus();
		foreach($this->rawMenus as $k => $item){
			// Find menu item corresponding to the current page (/plugin/controller/action)
			if(
				Inflector::underscore($item['Menu']['plugin']) == $this->controller->params['plugin'] AND
				Inflector::underscore($item['Menu']['controller']) == $this->controller->params['controller'] AND
				strtolower($item['Menu']['method']) == $this->controller->params['action']
			){
				// Find parents of the current page
				$this->_getAcoParent($this->rawMenus, $item['Aco']['parent_id']);
				// Add the current page to the breadcrumbs property
				$this->breadcrumbs[] = $item;
				foreach($this->breadcrumbs as $k => $crumb){
					if(empty($crumb['Menu']['controller']) AND !empty($crumb['Menu']['plugin'])){
						$this->breadcrumbs[$k]['Menu']['controller'] = $crumb['Menu']['plugin'];
					}
					if($crumb['Menu']['method'] == 'index' OR $crumb['Menu']['method'] == 'display'){
						unset($this->breadcrumbs[$k]);
					}
					if(empty($crumb['Menu']['method'])){
						$this->breadcrumbs[$k]['Menu']['method'] = 'index';
					}
				}
				break;
			}
		}
		
	}

	/**
	 * Recursive method to get parents of an ACO
	 * 
	 * @param $array - array with ACOs data
	 * @param $parentId - parent id of the ACO
	 */
	private function _getAcoParent($array, $parentId){
		foreach($array as $item){
			if($item['Aco']['id'] == $parentId){
				$this->_getAcoParent($array, $item['Aco']['parent_id']);
				if($item['Aco']['alias'] != 'controllers'){
					$this->breadcrumbs[] = $item;
				}
			}
		}
	}
}
?>