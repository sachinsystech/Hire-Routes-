<?php
/* SVN FILE: $Id$ */
/**
 * Display group view.
 *
 * Display group view for Bancer Control Panel Plugin.
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

class DatabaseMenusHelper extends Helper{

	public $helpers = array('Html', 'Session');
	private $__type = null;
	private $__id = null;
	private $__name = null;

	/**
	 * 
	 * @param array $array - Array with menus data
	 * @param string $type - Menu type (css class) for styling purposes only
	 * @param int $id - Id of the item for which action menu should be created, f.ex. Model/view/38
	 * @param string $name - Row name to be displayed in the prompt window after delete button was clicked
	 */
	public function makeMenu($array, $type = 'down', $id = null, $name = null){
		$this->__type = $type;
		$this->__id = $id;
		$this->__name = $name;
		if($type == 'down' OR $type == 'right' OR $type == 'left' OR $type == 'up'){
			$class = 'css_menu cm_'.$type;
		}elseif($type == 'actions' OR $type == 'extra'){
			$class = 'bcp_'.$type;
		}else{
			$class = $type;
		}
		$html = $this->__renderMenu($array, $class);
		// Use the helper's output function to hand formatted data back to the view:
		if($type == 'right' OR $type == 'left'){
		return "";
		}
		return $this->output($html);
	}

	private function __renderMenu($data = array(), $class){
		$out = '';
		if($data == array()){
			return;
		}
		if(is_array($data)){
			$out .= "<ul class=\"$class\">\n";
			foreach($data as $item){
				if(!empty($item['Children'])){
					$out .= '<li class="parent">';
					$out .= $this->__makeLink($item);
					$out .= $this->__renderMenu($item['Children'], 'menu_children');
					$out .= "</li>\n";
				}else{
					$out .= '<li>'.$this->__makeLink($item).'</li>';
				}
			}
			$out .= "</ul>\n";
		}
		return $out;
	}

	private function __makeLink($item){
		$title = $item['Menu']['name'];
		// Strtolower the first letter of the controller name
		//$item['Menu']['controller'] = strtolower(substr($item['Menu']['controller'],0,1)).substr($item['Menu']['controller'],1);
		$item['Menu']['controller'] = Inflector::underscore($item['Menu']['controller']);
		$url = array(
			'plugin' => strtolower($item['Menu']['plugin']),
			'controller' => $item['Menu']['controller'],
			'action' => $item['Menu']['method'],
			$this->__id
		);
		$htmlAttributes = array();
		$confirmMessage = false;
		$escapeTitle = true;
		//$img = $this->webroot.'bcp/img/'.$item['Menu']['method'];
		/*if(file_exists(WWW_ROOT.'img/'.$item['Menu']['method'].'.png') OR file_exists(WWW_ROOT.'img/'.$item['Menu']['method'].'32.png')){
			$img = $this->webroot.'img/'.$item['Menu']['method'];
		}else{*/
			/* Form image path:
			 * 1) delete ending slash from $this->webroot,
			 * 2) get image path depending if .htaccess files are used,
			 * 3) what kind of image is it (view, edit, delete etc.)? */
		/*	$img = substr($this->webroot, 0, -1).$this->image_path().$item['Menu']['method'];
		}*/
		if($this->__type == 'actions'){
			$htmlAttributes = array(
				//'style' => 'background:url('.$img.'.png) no-repeat scroll center;',
				'class' => $item['Menu']['method'],
				'title' => $title,
			);
		}elseif($this->__type == 'extra'){
			$htmlAttributes = array(
				'class' => $item['Menu']['method'].'_extra',
				'title' => $title
			);
		}
		// If method is 'delete' create a confirmation message
		if($item['Menu']['method'] == 'delete'){
			$this->__name = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $this->__name);
			$confirmMessage = sprintf(__('Are you sure you want to delete %s?', true), $this->__name);
		}
		// If method in empty create link to the index page.
		elseif($item['Menu']['method'] == ''){
			$url['action'] = 'index';
			// Create class for current controller in the main menu
			if(strtolower($item['Menu']['controller']) == $this->params['controller']){
				$htmlAttributes = array('class' => 'current');
			}
		}
		return $this->Html->link($title, $url, $htmlAttributes, $confirmMessage, $escapeTitle);
	}

	public function auth_links($action = 'login'){
		
		$out = '';
		// If is logged in and not anonymous
		if($this->Session->read('Auth.User.account_email') != 'anonymous' AND $this->Session->read('Auth.User.account_email') != ''){
			$out .= $this->Session->read('Auth.User.account_email').'&nbsp;';
			//$out .= $this->change_password_link().'&nbsp;';
			$out .= $this->logout_link();
		}else{
			$out .= $this->login_link($action);
		}
		return $out;
	}

	public function login_link($action = 'login'){
		return $this->Html->image($this->image_path()."login.png", array(
			"alt" => __("Login", true),
			"title" => __("Login", true),
			'url' => array(
				'plugin' => 'bcp',
				'controller' => 'users',
				'action' => $action,
				'?' => array('requestedByUser' => 1)
			)
		));
	}

	public function logout_link(){
		return "| ".$this->Html->link(__('Logout',true),array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'logout'));

	}

	public function change_password_link(){
		return $this->Html->image($this->image_path()."lock.png", array(
			"alt" => __("Change password", true),
			"title" => __("Change password", true),
			'url' => array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'changePassword')
		));
	}

	public function image_path(){
		if(is_file(APP.'.htaccess')){
			return '/bcp/img/';
		}else{
			return '../../plugins/bcp/vendors/img/';
		}
	}

	/**
	 * Create breadcrumbs method to generate links from array
	 * 
	 * @param $array - array with breadcrumb items
	 * @param $separator - separator between links
	 */
	public function breadcrumbs($array, $separator = ' &#187; '){
		$crumbsQuantity = count($array);
		if($crumbsQuantity < 2){
			return null;
		}
		$out = '<div id="breadcrumbs"><ul>';
		foreach($array as $k => $item){
			$out .= '<li>';
			// Insert separator in the resuld only if that is not the very first link
			if($k != 0){
				$out .= $separator;
			}
			// Create empty link for the last item (current page)
			if($k + 1 == $crumbsQuantity){
				$out .= '<span class="disabled">'.$item['Menu']['name'].'</span>';
			}else{
				$out .= $this->Html->link($item['Menu']['name'], array(
					'plugin' => strtolower($item['Menu']['plugin']),
					'controller' => Inflector::underscore($item['Menu']['controller']),
					'action' => strtolower($item['Menu']['method'])
				));
			}
			$out .= '</li>';
		}
		$out .= '</ul></div>';
		return $out;
	}
}
?>
