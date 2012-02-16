<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('Networkers','NetworkerSettings','User','UserRoles','FacebookUsers');
	var $components = array('Email','Session');	
	function add() {
		$this->data['Networkers']['user_id'] = $this->Session->read('Auth.User.id');
		$this->NetworkerSettings->save($this->data['Networkers']);
		$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
	}
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->redirect('/users/networkerSetting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
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

	function index(){
          $userId = $this->Session->read('Auth.User.id');
          if($userId){
			
	    $networkers = $this->Networkers->find('all',array('conditions'=>array('user_id'=>$userId)));
				
		$networkers_array = array();
		foreach($networkers as $networker){
			$networkers_array[$networker['Networkers']['id']] =  $networker['Networkers'];
		}
		$this->set('networkers',$networkers_array);

        $users = $this->User->find('all',array('conditions'=>array('id'=>$userId)));
		$users_array = array();
		foreach($users as $user){
			$users_array[$user['User']['id']] =  $user['User'];
		}
		
        $this->set('users',$users_array);
        
        if($user['User']){
             $this->set('user',$user['User']);
          }

        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
		$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
         }


        if($networker['Networkers']){
				$this->set('networker',$networker['Networkers']);
			}
		}
	}
   
  function editProfile() {
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			$this->Networkers->save($this->data['Networkers']);		
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/networkers');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);

         if(isset($user['Networkers'][0])){
        $this->set('networker',$user['Networkers'][0]);}

        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        
        if(isset($fbinfos[0])){
           $this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
         }
	}
}
?>
