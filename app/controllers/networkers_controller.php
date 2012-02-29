<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';

	var $uses = array('Networkers','NetworkerContact','NetworkerCsvcontact','NetworkerSettings','User','UserRoles','Industry','State','City','Specification',
'FacebookUsers','Companies','Job');
	var $components = array('Email','Session','TrackUser','Utility');	
	var $helpers = array('Time','Form');
	
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
		$userId = $this->TrackUser->getCurrentUserId();	
		$this->data['Networkers']['user_id'] = $userId;
		$this->NetworkerSettings->save($this->data['Networkers']);
		$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
	
	/* Delete Subscription */
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
		
		$this->set('specifications',$this->Utility->getSpecification());
		$this->set('industries',$this->Utility->getIndustry());		
		$this->set('cities',$this->Utility->getCity());
		$this->set('states',$this->Utility->getState());
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
	
	/*	Add contact by single entry	*/
	function addContacts() {
		if(isset($this->data['Contact'])){
			$userId = $this->TrackUser->getCurrentUserId();
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			$this->data['Contact']['user_id'] = $userId;
			$this->data['Contact']['networker_id'] = $user['Networkers'][0]['id'];
			
			if($this->data['Contact']['contact_name']=='Enter Name'){
				$this->data['Contact']['contact_name'] = "";			
			}
			if($this->data['Contact']['contact_email']=='Enter E-mail'){
				$this->data['Contact']['contact_email'] = "";			
			}
			if ($this->NetworkerContact->create($this->data['Contact']) && $this->NetworkerContact->validates()) {
		        $this->NetworkerContact->save($this->data['Contact']);
				$this->Session->setFlash('Contact has been added successfully.', 'success');	
			}
			$this->set('validationErrors',$this->NetworkerContact->validationErrors);
			$this->set('NetworkerContact',$this->NetworkerContact->data['NetworkerContact']);
		}
	}

	/*	Edit single contact	*/
	function EditContact() {
		if(isset($this->data['editContact'])){
			$userId = $this->TrackUser->getCurrentUserId();
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			$this->NetworkerContact->save($this->data['editContact']);
			$this->Session->setFlash('Contact has been updated successfully.', 'success');	
			$this->redirect('/networkers/personal');
		}
	}

	/*	displaying all personal contacts	*/
	function personal() {
		$userId = $this->TrackUser->getCurrentUserId();
		$startWith = isset($this->params['named']['alpha'])?$this->params['named']['alpha']:"";
		
		$paginateCondition = array(
									'AND' => array(
												array('NetworkerContact.user_id'=>$userId),
												array('NetworkerContact.contact_email LIKE' => "$startWith%")
											)
								);
		
		$this->paginate = array('conditions'=>$paginateCondition,
                                'limit' => 10,
                                'order' => array("NetworkerContact.id" => 'asc',));             
        $contacts = $this->paginate('NetworkerContact');
        $alphabets = array();
        foreach(range('A','Z') AS $alphabet){
        	$contacts_count = $this->NetworkerContact->find('count',array('conditions'=>array('NetworkerContact.contact_email LIKE' => "$alphabet%")));
            $alphabets[$alphabet] = $contacts_count; 
        }

        $this->set('alphabets',$alphabets);
        $this->set('contacts',$contacts);
        $this->set('contact',null);
        $this->set('startWith',$startWith);
	}
	
	/*	Edit single personal contact	*/
	function editPersonalContact(){
		$userId = $this->TrackUser->getCurrentUserId();
		if(isset($this->params['id'])){
			$contactId =$this->params['id'];
			$contact = $this->NetworkerContact->find('first',array('conditions'=>array('NetworkerContact.id'=>$contactId,
																			'NetworkerContact.user_id'=>$userId,
																			)
													)
										);
			if(!isset($contact['NetworkerContact'])){
				$this->Session->setFlash('You clicked on old link or entered manually.', 'error');	
				$this->redirect('/networkers/personal');
			}							
			$this->set('editContact',$contact['NetworkerContact']);
		}       
	}
	
	/*	Add contact by Importing CSV	*/
	function importCsv() {
		$userId = $this->TrackUser->getCurrentUserId();
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$file = fopen($this->data['networkers']['CSVFILE']['tmp_name'],'r');
		$values = array();
		$contacts = array();
		try{
			while(! feof($file))
		  	{
				$csvArray = fgetcsv($file);
				$values[] = $csvArray;
		  	}
			if(isset($values[1][3])){
				
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $values[1][3])){
					$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
					$this->redirect('/networkers/addContacts');
				}
			
				foreach($values as $key=>$val){
					if(isset($val[3])){
						$contacts[$key]['user_id'] = $userId;
						$contacts[$key]['networker_id'] = $user['Networkers'][0]['id'];
						$contacts[$key]['contact_name'] = $val[0]." ".$val[1]." ".$val[2];
						$contacts[$key]['contact_email'] = $val[3];
					}	
				}	
				unset($contacts[0]);
				$duplicate_emails = array();
				$added_count = 0;
				$duplicate_count = 0;
				foreach($contacts as $contact){
					if ($this->NetworkerCsvcontact->create($contact) && $this->NetworkerCsvcontact->validates()) {
						$this->NetworkerCsvcontact->save($contact);
						++$added_count;
					}
					else{
						$duplicate_emails[] = $this->NetworkerCsvcontact->data['NetworkerCsvcontact']['contact_email'];	
						++$duplicate_count;
					}
				}
			}
			else{
				$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
				$this->redirect('/networkers/addContacts');
			}
		}catch(Exception $e){
			$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
			$this->redirect('/networkers/addContacts');
		}
		$added_count_msg = "";
		$duplicate_count_msg = "";
		if(count($added_count)>0){
			$added_count_msg = "You CSV have been imported successfully, $added_count contacts added.";	
		}
		if(count($duplicate_count)>0){
			$duplicate_count_msg = "$duplicate_count duplicate contacts found.";
		}
		$this->Session->setFlash($added_count_msg." ".$duplicate_count_msg, 'success');	
		$this->redirect('/networkers/addContacts');
	}
	
	function deleteContacts() {
		$ids = array();
		if(isset($this->params['id'])){
			$ids[] = $this->params['id'];
		}
		foreach($this->data['deleteContacts'] as $key=>$value){
			if($value){
				$ids[] = $value;
			}	
		}
		$this->NetworkerContact->delete($ids);
		$this->Session->setFlash('contact has been deleted successfuly.', 'success');				
		$this->redirect('/networkers/personal');
	}
		  
	function newJob(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        
    	$networker_settings = $this->NetworkerSettings->find('first',array('conditions'=>array('user_id'=>$userId)));
        
        $industry		= $networker_settings['NetworkerSettings']['industry'];
		$specification  = explode(",",$networker_settings['NetworkerSettings']['specification']);
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
		
		$this->set('industries',$this->Utility->getIndustry());	

		$this->set('cities',$this->Utility->getCity());
		
		$this->set('states',$this->Utility->getState());

		$this->set('specifications',$this->Utility->getSpecification());

        $this->set('urls',$this->Utility->getCompany('url'));
		
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
