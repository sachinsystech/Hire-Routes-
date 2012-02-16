<?php
class TrackUserComponent extends Object
{
	var $someVar = null;
	var $controller = true;
	
	var $components = array('Session','Auth');
	
	function startup(&$controller)
	{
		// This method takes a reference to the controller which is loading it.
		// Perform controller initialization here.
	}
	
	function getCurrentUserId(){
		$userId = $this->Session->read('Auth.User.id');		
		return $userId;
	}
	
	function getCurrentUserRole($userRole){
		$userId = $this->Session->read('Auth.User.id');			
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
