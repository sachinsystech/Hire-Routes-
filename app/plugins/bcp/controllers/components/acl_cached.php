<?php 
/**
 * Access Control List cache class.
 *
 * Implements caching for Access Control List.
 * 
 * To use this component replace $components = array('Acl') to
 * $components = array('AclCached') in your app_controller.php,
 * create /app/tmp/cache/acl folder and assign it 777 permission
 * 
 * You can pass one parameter to the component if you
 * want to change the cache duration:
 * $components = array('AclCached' => array('cacheTime' => '+1 day'))
 * 
 * Don't forget to clear cache in afterSave() and afterDelete() methods
 * of your models that change aros, acos or acos_aros tables (f.ex. Users,
 * Groups models):
 * App::import('Component', 'AclCached');
 * $aclCache = new AclCachedComponent();
 * $aclCache->clearCache();
 *
 *
 * (C) Copyright 2010, Valerij Bancer (http://bancer.sourceforge.net)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author        Valerij Bancer
 * @link          http://www.bancer.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Component', 'Acl');
class AclCachedComponent extends AclComponent {
/**
* Time to cache permissions.
*
* @var string String compatible with strtotime.
*/
	public $cacheTime = '+1 week';

/**
 * Initialize method to assure ACL methods remain working.
 * Cache configuration.
 *
 * @param object $controller The current controller.
 * @param array Cache configuration settings
 * @access public
 */
	public function initialize(&$controller, $settings = array()){
		$controller->Acl =& $this;
		if(!empty($settings)){
			$this->_set($settings);
		}
		Cache::config('acl_cached', array(
			'engine' => 'File',  
			'duration'=> $this->cacheTime,  
			'path' => CACHE.'acl'.DS,  
			'prefix' => ''
		));
	}

/**
 * Pass-thru function for ACL check instance. Check methods
 * are used to check whether or not an ARO can access an ACO.
 * The check result is cached.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function check($aro, $aco, $action = "*") {
		$path = md5(serialize($aro).serialize($aco).serialize($action));
		$permission = Cache::read($path, 'acl_cached');
		if($permission === false){
			$permission = parent::check($aro, $aco, $action);
			Cache::write($path, (int) $permission, 'acl_cached');
		}
		return (bool) $permission;
	}

/**
 * Pass-thru function for ACL allow instance. Allow methods
 * are used to grant an ARO access to an ACO. Cache is
 * deleted after allow.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function allow($aro, $aco, $action = "*") {
		$result = parent::allow($aro, $aco, $action);
		$this->clearCache();
		return $result;
	}

/**
 * Pass-thru function for ACL deny instance. Deny methods
 * are used to remove permission from an ARO to access an ACO.
 * Cache is deleted after deny.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function deny($aro, $aco, $action = "*") {
		$result = parent::deny($aro, $aco, $action);
		$this->clearCache();
		return $result;
	}

/**
 * Pass-thru function for ACL inherit instance. Inherit methods
 * modify the permission for an ARO to be that of its parent object.
 * Cache is deleted after inherit.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function inherit($aro, $aco, $action = "*") {
		$result = parent::inherit($aro, $aco, $action);
		$this->clearCache();
		return $result;
	}

/**
 * Pass-thru function for ACL grant instance.
 * An alias for AclComponent::allow()
 * Cache is deleted after grant.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function grant($aro, $aco, $action = "*") {
		$result = parent::grant($aro, $aco, $action);
		$this->clearCache();
		return $result;
	}

/**
 * Pass-thru function for ACL grant instance.
 * An alias for AclComponent::deny()
 * Cache is deleted after revoke.
 *
 * @param string $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @access public
 */
	public function revoke($aro, $aco, $action = "*") {
		$result = parent::revoke($aro, $aco, $action);
		$this->clearCache();
		return $result;
	}

	/**
	 * Method to delete all permissions cache files of the cache
	 * configuration used to write them.
	 */
	public function clearCache(){
		Cache::clear(false, 'acl_cached');
	}
}
?>