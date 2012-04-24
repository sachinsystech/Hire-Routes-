<?php
/**
 * TrackUeser component
 *
 * Manages Authenticated user info like role, id, info, welcome Name.
 *
 * PHP versions 4 and 5
 *
 * use Session and Auth component.
 *
 * Binds access control with user authentication and session management.
 *
 **/

class ApiSessionComponent extends Object
{
	var $userId;
	var $userRole;
	var $welcomeName;
	var $controller = true;
	var $uses = array('UserRoles','User','UserList','UserRoles');
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
		$this->setUserId();
		$this->setUserRole();	
		$this->setWelcomeName();	
		// This method takes a reference to the controller which is loading it.
		// Perform controller initialization here.
	}
	
	function isLoggedIn(){
		if($this->Session->read('Auth.User.id')>2 || $this->Session->read('Auth.User.id')==1){
			return true;
		}else{
			return false;
		}
	}

	function setUserId(){
		if($this->Session->read('Auth.User.id')!=2){
			$this->userId = $this->Session->read('Auth.User.id');
			$this->Session->write('UserId',$this->userId);
		}
	}
	
	function getUserId(){
		return $this->Session->read('UserId');
	}

	function setUserRole(){
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$this->userId)));		
		$this->UserRole = $userRole['UserRoles']['role_id'];
		$this->Session->write('UserRole',$this->UserRole);
	}
	
	function getUserRole(){
		return $this->Session->read('UserRole');
	}

	function setWelcomeName($name=null){
		if(isset($name) || $name){
			$this->welcomeName = $name;
			$this->Session->write('welcomeName',$name);
			return;
		}
		$user = $this->getUser();
		$name = $user->info['contact_name'];
		$this->welcomeName = $name;
		$this->Session->write('welcomeName',$name);
	}			

	function getWelcomeName(){
		return $this->Session->read('welcomeName');
	}			

	function getUser(){
		$userData = $this->UserList->find('first',array('conditions'=>array('UserList.id'=>$this->getUserId())));
		$userData['User'] = $userData['UserList'];
		$userData['User']['role'] = $userData['UserRoles']['role_id'];
		switch($userData['User']['role']){
			case COMPANY:
				$userData['User']['info'] = $userData['Companies'];					
				break;	
			case JOBSEEKER:
				$userData['User']['info'] = $userData['Jobseekers'];
				break;					
			case NETWORKER:
				$userData['User']['info'] = $userData['Networkers'];					
				break;
		}
		unset($userData['Companies']);
		unset($userData['Jobseekers']);
		unset($userData['Networkers']);
		unset($userData['UserList']);
		unset($userData['UserRoles']);				
		$userData = (object) $userData['User'];
		return $userData;	
	}
	
	function setBeforeAuthUrl($url){
		$this->Session->Write('beforeAuthUrl',$url);
	}
	
	function getBeforeAuthUrl(){
		return $this->Session->read('beforeAuthUrl');	
	}
}
?>
