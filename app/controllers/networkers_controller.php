<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('Networkers','NetworkerSettings','User');
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


        if($networker['Networkers']){
				$this->set('networker',$networker['Networkers']);
			}
		}
	}
}
?>
