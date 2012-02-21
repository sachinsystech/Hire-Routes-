<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('Networkers','NetworkerSettings','User','UserRoles','Industry','State','City','Specification','FacebookUsers');
	var $components = array('Email','Session','TrackUser', 'Utility');	
	
	public function beforeFilter(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
		if($roleInfo['role_id']!=3){
			$this->redirect("/users/firstTime");
		}
	}
	
	/* Save New Networking-Setting */
	function add() {
		$this->data['Networkers']['user_id'] = $this->Session->read('Auth.User.id');
		$this->NetworkerSettings->save($this->data['Networkers']);
		$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
	
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->Session->setFlash('Your Subscription has been deleted successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
	}
	
	/* 	Networker's Account-Profile page*/
	function index(){
		$userId = $this->TrackUser->getCurrentUserId();		
        if($userId){

			/* User Info*/						
		    $user = $this->User->find('all',array('conditions'=>array('id'=>$userId)));
			$this->set('user',$user[0]['User']);

			/* Networker Info*/
			$networkers = $this->Networkers->find('all',array('conditions'=>array('user_id'=>$userId)));
			$this->set('networker',$networkers[0]['Networkers']);
		
			/* FB-User Info*/
			$fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
       	 	if(isset($fbinfos[0])){
				$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
         	}
		}
	}
	
	/* 	Setting and Subscriptoin page*/
	function setting() {
		$userId = $this->TrackUser->getCurrentUserId();		
		
		/* Networker-Setting Info*/
		$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$userId)));
		$this->set('NetworkerData',$networkerData);
		
		/* FB-User Info*/       		        
        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
			$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
        }
        if(isset($networker) && $networker['Networkers']){
			$this->set('networker',$networker['Networkers']);
		}
		
		$industries = $this->Industry->find('all');
		$industry = $this->Utility->objectToKeyValueArray($industries, 'id', 'name', 'Industry');
		$this->set('industries',$industry);
		
		$cities = $this->City->find('all',array('conditions'=>array('City.state_code'=>'PA')));
		$city = $this->Utility->objectToKeyValueArray($cities, 'city', 'city', 'City');
		$this->set('cities',$city);
		
		$states = $this->State->find('all');
		$state = $this->Utility->objectToKeyValueArray($states, 'state', 'state', 'State');
		$this->set('states',$state);

		$specifications = $this->Specification->find('all');			
		$specification = $this->Utility->objectToKeyValueArray($specifications, 'id', 'name', 'Specification');
		$this->set('specifications',$specification);
	}
   
	/* 	Edit Networker's Account-Profile*/   
	function editProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		
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
        	$this->set('networker',$user['Networkers'][0]);
        }

        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
        	$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
        }
	}
}
?>
