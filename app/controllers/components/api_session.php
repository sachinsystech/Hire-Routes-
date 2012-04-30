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
	var $uses = array('UserList','UserRoles');
	var $components = array('Session','Auth','TrackUser');

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
	
	function start(){
		$this->setUserId();
		$this->setUser();
		$this->setUserRole();	
		$this->setWelcomeName();	
		$this->TrackUser->setUserRole();			
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
			$this->Session->write('UserId',$this->Session->read('Auth.User.id'));
		}
	}
	
	function getUserId(){
		return $this->Session->read('UserId');
	}

	function setUserRole(){
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$this->getUserId())));		
		$this->Session->write('UserRole',$userRole['UserRoles']['role_id']);
	}
	
	function getUserRole(){
		return $this->Session->read('UserRole');
	}

	function setWelcomeName($name=null){
		if(isset($name) || $name){
			$this->Session->write('welcomeName',$name);
			return;
		}
		if(isset($this->getUser()->info)){
			$user = $this->getUser()->info;
			$name = isset($user['contact_name'])?$user['contact_name']:null;
			$this->Session->write('welcomeName',$name);
		}	
	}			

	function getWelcomeName(){
		return $this->Session->read('welcomeName');
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
			$this->Session->write('User',$userData);
		}
	}
	
	function getUser(){
		return $this->Session->read('User');
	}
	
	function setBeforeAuthUrl($url){
		$match = '/^\/jobs\/jobDetail\/[0-9]+\/?[.*]?/';
		if($this->isValidUrl($match,$url)){
			$this->Session->write('beforeAuthUrl',$url);
		}else{
			$this->Session->delete('beforeAuthUrl');
		}
	}
	
	function getBeforeAuthUrl(){
		return $this->Session->read('beforeAuthUrl');	
	}
	
	function setBeforeApplyUrl($url){
		$match = '/^\/jobs\/applyJob\/[0-9]+\/?[.*]?/';
		if($this->isValidUrl($match,$url)){
			$this->Session->write('beforeApplyUrl',$url);
		}else{
			$this->Session->delete('beforeApplyUrl');
		}
	}
	
	function getBeforeApplyUrl(){
		return $this->Session->read('beforeApplyUrl');	
	}
	
	function isValidUrl($match,$referer){
		if(preg_match($match,$referer)){
			return true;
		}	
	}
	
	function logout(){
		$this->Session->delete('User');
		$this->Session->delete('UserId');		
		$this->Session->delete('UserRole');
		$this->Session->delete('welcomeName');
		$this->Session->delete('beforeAuthUrl');
	}
}
?>
