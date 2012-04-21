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
	var $uses = array('UserRoles','User');
	
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
	
	function isUserLoggedIn(){
		if($this->Session->read('Auth.User.id')>0 && $this->Session->read('Auth.User.id')!=2){
			return true;
		}
		else{
			return false;		
		}
	}

	
/**
 * Get authenticated user's role info 
 *
 * @return array Associative array with: {roleid,rolename}
 * @access public
 */	
	function getCurrentUserRole(){
		$userId = $this->getCurrentUserId();	
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));		
		$roleName  = null;
		switch($userRole['UserRoles']['role_id']){
			case COMPANY:
					$roleName = 'Company';
					break;
			case JOBSEEKER:
					$roleName = 'Jobseeker';	
					break;			
			case NETWORKER:
					$roleName = 'Networker';		
					break;			
			case ADMIN:
					$roleName = 'Admin';		
					break;			
		}
		$currentUserRole = array('id'=>$userRole['UserRoles']['role_id'],'name'=>$roleName);
		return $currentUserRole;
	}
	
	function setWelcomeUserName(){
		$userId = $this->getCurrentUserId();
		$userData=$this->User->find('first',array('conditions'=>array('id'=>$userId)));
		$welcomeUserName = 'User';	
		$role = $this->getCurrentUserRole();
		switch($role['id']){			
			case COMPANY:
					if(isset($userData['Companies'][0]['contact_name']))
						$welcomeUserName = $userData['Companies'][0]['contact_name'];
						break;
			case JOBSEEKER:
					if(isset($userData['Jobseekers'][0]['contact_name']))
						$welcomeUserName = $userData['Jobseekers'][0]['contact_name'];
					break;
			case NETWORKER:
					if(isset($userData['Networkers'][0]['contact_name']))
						$welcomeUserName = $userData['Networkers'][0]['contact_name'];
					break;
			case ADMIN:
						$welcomeUserName = 'Admin';
					break;
			default:
						$welcomeUserName = null;
		}
		$this->Session->write('welcomeUserName',$welcomeUserName);
	}
	
	function setUserRole(){
		$userRole=$this->getCurrentUserRole();
		$this->Session->write('userRole',$userRole);
	}			
}
?>
