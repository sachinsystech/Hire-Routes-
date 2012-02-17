<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';

	var $uses = array('JobseekerSettings','Jobseeker','User','UserRoles','Industry','State','Specification','FacebookUsers');
	var $components = array('Email','Session','TrackUser');	

	function add() {
		$this->data['Jobseekers']['user_id'] = $this->Session->read('Auth.User.id');
		//echo "<pre>"; print_r(implode(',',$this->data['Jobseekers']['industry_specification_1']));exit;
		$this->data['Jobseekers']['specification_1'] = implode(',',$this->data['Jobseekers']['industry_specification_1']);
		$this->data['Jobseekers']['specification_2'] = implode(',',$this->data['Jobseekers']['industry_specification_2']);
		$this->JobseekerSettings->save($this->data['Jobseekers']);
		$this->Session->setFlash('Your Setting has been saved successfuly.', 'success');				
		$this->redirect('/jobseekers/setting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		//$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
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
			$jobseekers = $this->Jobseeker->find('all',array('conditions'=>array('user_id'=>$userId)));
			$jobseekers_array = array();
			foreach($jobseekers as $jobseeker){
				$jobseekers_array[$jobseeker['Jobseeker']['id']] =  $jobseeker['Jobseeker'];
			}
			$this->set('jobseekers',$jobseekers_array);
    		$users = $this->User->find('all',array('conditions'=>array('id'=>$userId)));
			$users_array = array();
			foreach($users as $user){
				$users_array[$user['User']['id']] =  $user['User'];
			}
			$this->set('users',$users_array);
		    if($user['User']){
            	$this->set('user',$user['User']);
          	}

	        if($jobseeker['Jobseeker']){
				$jobseekers_array = array();
				foreach($jobseekers as $jobseeker){
					$jobseekers_array[$jobseeker['Jobseeker']['id']] =  $jobseeker['Jobseeker'];
				}
				$this->set('jobseekers',$jobseekers_array);
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
		 		if(isset($jobseeker) && $jobseeker['Jobseeker']){
					$this->set('jobseeker',$jobseeker['Jobseeker']);
				}		
			}
		}
	}	

	function setting() {
		$userId = $this->Session->read('Auth.User.id');
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
		//print_r($roleInfo); exit;
		if($roleInfo['role_id']!=2){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('JobseekerSettings.user_id'=>$userId)));
			$this->set('jobseekerData',$jobseekerData['JobseekerSettings']);
			
			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
			/*$cities = $this->City->find('all');
			$city_array = array();
			foreach($cities as $city){
				$city_array[$city['City']['city']] =  $city['City']['city'];
			}
			$this->set('cities',$city_array);
			*/
			$states = $this->State->find('all');
			$state_array = array();
			foreach($states as $state){
				$state_array[$state['State']['state']] =  $state['State']['state'];
			}
			$this->set('states',$state_array);

			$specifications = $this->Specification->find('all');
			$specification_array = array();
			foreach($specifications as $specification){
				$specification_array[$specification['Specification']['id']] =  $specification['Specification']['name'];
			}
			$this->set('specifications',$specification_array);

		}	
	}

     function editProfile() {
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			$this->Jobseeker->save($this->data['Jobseeker']);		
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/jobseekers');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);

        if(isset($user['Jobseekers'][0])){
        $this->set('jobseeker',$user['Jobseekers'][0]);
        }

        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
		$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
        }

	}

}
?>
