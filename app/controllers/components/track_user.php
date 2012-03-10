<?php
class TrackUserComponent extends Object
{
	var $someVar = null;
	var $controller = true;
	var $uses = array('UserRoles');
	
	var $components = array('Session','Auth');
	
	function initialize(&$controller) {
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}		
	}

	function startup(&$controller)
	{
		// This method takes a reference to the controller which is loading it.
		// Perform controller initialization here.
	}
	
	function getCurrentUserId(){
		$userId = $this->Session->read('Auth.User.id');		
		return $userId;
	}
	
	function isHRUserLoggedIn(){
		if($this->Session->read('Auth.User.id')>2){
			return true;
		}
		else{
			return false;		
		}
	}
	
	
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
