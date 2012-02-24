<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('Networkers','NetworkerSettings','User','UserRoles','Industry','State','City','Specification',
'FacebookUsers','Companies','Job');
	var $components = array('Email','Session','TrackUser', 'Utility');	
	var $helpers = array('Time');
	
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
   
	function newJob(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        

        $networker_settings = $this->NetworkerSettings->find('first',array('conditions'=>array('user_id'=>$userId)));
        
        $industry		= $networker_settings['NetworkerSettings']['industry'];
		$specification = explode(",",$networker_settings['NetworkerSettings']['specification']);
	    $city 			= $networker_settings['NetworkerSettings']['city'];
		$state 			= $networker_settings['NetworkerSettings']['state'];
		
        
       
		$shortByItem = 'id';
        
        if(isset($this->params['named']['display'])){
	        $displayPageNo = $this->params['named']['display'];
	        $this->set('displayPageNo',$displayPageNo);
		}
		if(isset($this->params['named']['shortby'])){
	        $shortBy = $this->params['named']['shortby'];
	        $this->set('shortBy',$shortBy);
	        switch($shortBy){
	        	case 'date-added':
	        				$shortByItem = 'created'; 
	        				break;	
	        	case 'company-name':
	        				$shortByItem = 'company_name'; 
	        				break;
	        	case 'industry':
	        				$shortByItem = 'industry'; 
	        				break;
	        	case 'salary':
	        				$shortByItem = 'salary_from'; 
	        				break;
	        	default:
	        			$this->redirect("/jobs");	        		        	
	        }
		}

		$cond = array('OR' => array(array('industry' => $industry),
                                    array('specification' => $specification),
                                    array('city ' => $city),
                                    array('state' => $state),));		

		$this->paginate = array('conditions'=>$cond,
                                'limit' => isset($displayPageNo)?$displayPageNo:5,
                                'order' => array("Job.$shortByItem" => 'asc',));
        
        $jobs = $this->paginate('Job');
		
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		$industries = $this->Industry->find('all');
		$industries_array = array();
		foreach($industries as $industry){
			$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
		}
		$this->set('industries',$industries_array);

		$cities = $this->City->find('all',array('conditions'=>array('City.state_code'=>'AK')));
		$cities_array = array();
		foreach($cities as $city){
			$cities_array[$city['City']['city']] =  $city['City']['city'];
		}
		$this->set('cities',$cities_array);
		
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

                $urls = $this->Companies->find('all');
		$url_array = array();
		foreach($urls as $url){
			$url_array[$url['Companies']['id']] =  $url['Companies']['company_url'];
		}
                
		$this->set('urls',$url_array);
		
		$companies = $this->Companies->find('all');
		$companies_array = array();
		foreach($companies as $company){
			$companies_array[$company['Companies']['user_id']] =  $company['Companies']['company_name'];
		}
		$this->set('companies',$companies_array);
		
		if(isset($this->params['id'])){
			$id = $this->params['id'];
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			if($job['Job']){
				$this->set('job',$job['Job']);
			}
			else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/');
			}	
		}
	}
}
?>
