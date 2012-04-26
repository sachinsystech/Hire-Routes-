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
		$this->setUser();		
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
			$this->Session->write('API.UserId',$this->Session->read('Auth.User.id'));
		}
	}
	
	function getUserId(){
		return $this->Session->read('API.UserId');
	}

	function setUserRole(){
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$this->getUserId())));		
		$this->Session->write('API.UserRole',$userRole['UserRoles']['role_id']);
	}
	
	function getUserRole(){
		return $this->Session->read('API.UserRole');
	}

	function setWelcomeName($name=null){
		if(isset($name) || $name){
			$this->Session->write('API.welcomeName',$name);
			return;
		}
		if(isset($this->getUser()->info)){
			$user = $this->getUser()->info;
			$name = isset($user['contact_name'])?$user['contact_name']:null;
			$this->Session->write('API.welcomeName',$name);
		}	
	}			

	function getWelcomeName(){
		return $this->Session->read('API.API.welcomeName');
	}			

	function setUser(){
		$userData = $this->UserList->find('first',array('conditions'=>array('UserList.id'=>$this->getUserId())));
		if($userData['UserList']){
			$userData['User'] = $userData['UserList'];
			$userData['User']['role'] = isset($userData['UserRoles']['role_id'])?$userData['UserRoles']['role_id']:null;
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
			$this->Session->write('API.User',$userData);
		}
	}
	
	function getUser(){
		return $this->Session->read('API.API.User');
	}
	
	function setBeforeAuthUrl($url){
		$this->Session->write('API.beforeAuthUrl',$url);
	}
	
	function getBeforeAuthUrl(){
		return $this->Session->read('API.beforeAuthUrl');	
	}
	
	function logout(){
		$this->Session->Write('API',null);
	}
}
?>
