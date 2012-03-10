<?php
/**
 * TrackUeser component
 *
 * Manages Authenticated user info like roles.
 *
 * PHP versions 4 and 5
 *
 * use Session and Auth component.
 *
 * Binds access control with user authentication and session management.
 *
 **/

class TrackUserComponent extends Object
{
	var $someVar = null;
	var $controller = true;
	var $uses = array('UserRoles');
	
	var $components = array('Session','Auth');

/**
 * Initializes TrackUserComponent for use in the controller
 *
 * @param object $controller A reference to the instantiating controller object
 * @return void
 * @access public
 */	
	function initialize(&$controller) {
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}		
	}

/**
 * @param object $controller A reference to the instantiating controller object
 * @return boolean
 * @access public
 */
	function startup(&$controller)
	{
		// This method takes a reference to the controller which is loading it.
		// Perform controller initialization here.
	}
	
/**
 * Get authenticated user's id
 *
 * @return Int : type, numeric
 * @access public
 */	
	function getCurrentUserId(){
		$userId = $this->Session->read('Auth.User.id');		
		return $userId;
	}
	
/**
 * Get authenticated user's id
 *
 * @return boolean True if HR-User(Company/Jobseeker/Networker) is  login, false otherwise
 * @access public
 */	
	function isHRUserLoggedIn(){
		if($this->Session->read('Auth.User.id')>2){
			return true;
		}
		else{
			return false;		
		}
	}
	
/**
 * Get authenticated user's role info 
 *
 * @return array Associative array with: "roleid"=>"rolename"
 * @access public
 */	
	function getCurrentUserRole(){
		$userId = $this->Session->read('Auth.User.id');	
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));		
		$roleName  = null;
		switch($userRole['UserRoles']['role_id']){
			case 1:
					$roleName = 'company';
					break;
			case 2:
					$roleName = 'jobseeker';	
					break;			
			case 3:
					$roleName = 'networker';		
					break;			
		}
		$currentUserRole = array('role_id'=>$userRole['UserRoles']['role_id'],'role'=>$roleName);
		return $currentUserRole;
	}
}
?>
