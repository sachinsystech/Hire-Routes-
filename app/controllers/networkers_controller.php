<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('Networkers','NetworkerSettings','User','UserRoles','Industry','State','City','Specification');
	var $components = array('Email','Session','TrackUser', 'Utility');	
	
	public function beforeFilter(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
		if($roleInfo['role_id']!=3){
			$this->redirect("/users/firstTime");
		}
	}
	
	function add() {
		$this->data['Networkers']['user_id'] = $this->Session->read('Auth.User.id');
		$this->NetworkerSettings->save($this->data['Networkers']);
		$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->redirect('/networkers/setting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
	}

	function index(){
		$userId = $this->TrackUser->getCurrentUserId();		
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
	
	function setting() {
		$userId = $this->TrackUser->getCurrentUserId();		

		$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$userId)));
		$this->set('NetworkerData',$networkerData);
		
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
}
?>
