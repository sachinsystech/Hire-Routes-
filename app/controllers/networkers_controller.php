<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';

	var $uses = array('Networkers','NetworkerContact','NetworkerCsvcontact','NetworkerSettings',
						'User','UserRoles','Industry','State','City','Specification',
						'FacebookUsers','Companies','Job','PaymentHistory','JobseekerApply');
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
		if($this->NetworkerSettings->save($this->data['Networkers'])){
			$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		}
		$this->redirect('/networkers/setting');
	}
	
	/* Delete Subscription */
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->Session->setFlash('Your Subscription has been deleted successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
	
	
	
	/* 	Networker's Account-Profile page*/
	function index(){
		$userId = $this->TrackUser->getCurrentUserId();		
        if($userId){
        	/* User Info*/			
			$user = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
			$networkers = $user['Networkers'][0];
			if(!isset($networkers['contact_name']) || empty($networkers['contact_name'])){
				$this->redirect("/Networkers/editProfile");						
			}
			$this->set('user',$user['User']);
			$this->set('networker',$networkers);
		}
		else{		
			$this->Session->setFlash('Internal error has been occured...', 'error');	
			$this->redirect('/');								
		}

	}

	/* save email notifications setting*/
	
	function sendNotifyEmail(){
		$userId = $this->TrackUser->getCurrentUserId();
			
		if($this->Networkers->save($this->data['Networkers'])){
			$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		}
		$this->redirect('/networkers/setting');		
	}
	
	/* 	Setting and Subscriptoin page*/
	function setting() {
		$userId = $this->TrackUser->getCurrentUserId();		
		
		$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$userId),
												  'joins'=>array(array('table' => 'industry',
										                               'alias' => 'ind',
										             				   'type' => 'LEFT',
										             				   'conditions' => array('NetworkerSettings.industry = ind.id',)),
											   			         array('table' => 'specification',
										             				   'alias' => 'spec',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.specification = spec.id',)),
										                         array('table' => 'states',
										             				   'alias' => 'state',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.state = state.id',)),       
																 array('table' => 'cities',
										             				   'alias' => 'city',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.city = city.id',))
																 ),
															 'fields'=>array(
															 			'NetworkerSettings.id,
															 			NetworkerSettings.user_id,
															 			ind.name as name,
															 			spec.name as name,
															 			state.state as name,
															 			city.city as name'
															 		),
															 'order'=>array('NetworkerSettings.industry'=>'asc')		
														 		)
												 			);

		$SubscriptionData = $this->Networkers->find('first',array('conditions'=>array('Networkers.user_id'=>$userId)));	
		$this->set('NetworkerData',$networkerData);
		$this->set('SubscriptionData',$SubscriptionData['Networkers']);
		
		$this->set('industries',$this->Utility->getIndustry());
		$this->set('specifications',$this->Utility->getSpecification());
		$this->set('states',$this->Utility->getState());
		
		/* FB-User Info*/       		        
        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
			$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
        }
        if(isset($networker) && $networker['Networkers']){
			$this->set('networker',$networker['Networkers']);
		}
	}
   
	/* 	Edit Networker's Account-Profile*/   
	function editProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			if($this->User->save($this->data['User'])){
				if($this->Networkers->save($this->data['Networkers'])){
					$this->Session->write('welcomeUserName',$this->data['Networkers']['contact_name']);
					$this->Session->setFlash('Profile has been updated successfuly.', 'success');
					$this->redirect('/networkers');
				}	
			}
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
				
				$matchEmail = $this->NetworkerContact->find('first',array('conditions'=>array(
																				'NetworkerContact.user_id'=>$userId,
																				'NetworkerContact.contact_email'=>$this->data['Contact']['contact_email']
																				)
													));
				if(isset($matchEmail['NetworkerContact'])){
					$this->NetworkerContact->validationErrors['contact_email'] = "You have already added contact for this email.";
					$this->set('validationErrors',$this->NetworkerContact->validationErrors);
					$this->set('NetworkerContact',$this->NetworkerContact->data['NetworkerContact']);
					return;
				}									
		        if($this->NetworkerContact->save($this->data['Contact'])){
					$this->Session->setFlash('Contact has been added successfully.', 'success');	
				}	
			}
			$this->set('validationErrors',$this->NetworkerContact->validationErrors);
			$this->set('NetworkerContact',$this->NetworkerContact->data['NetworkerContact']);
		}
	}

	/*	Edit single contact	*/
	function EditContact() {
		if(isset($this->data['editContact'])){
			$userId = $this->TrackUser->getCurrentUserId();
			$contactId = $this->data['editContact']['id'];
			$contactEmail = $this->NetworkerContact->find('list', array(
																	 'fields' => array('NetworkerContact.id', 'NetworkerContact.contact_email'),
																	 'conditions' => array('NetworkerContact.id' => $contactId)
																	 ));
			
			$matchEmail = $this->NetworkerContact->find('first',array('conditions'=>
																  array(
																	"NOT"=>array('NetworkerContact.contact_email'=>$contactEmail),
																	"AND"=>array(
																					'NetworkerContact.user_id'=>$userId,
																					'NetworkerContact.contact_email'=>$this->data['editContact']['contact_email'],
																				)									
																	))
													);
			if(isset($matchEmail['NetworkerContact'])){
				$this->Session->setFlash("You have already added contact for the email(<i>".$this->data['editContact']['contact_email']."</i>)",'error');
				$this->redirect('/networkers/editPersonalContact/'.$contactId);
				return;
			}									
		    if($this->NetworkerContact->save($this->data['editContact'])){
				$this->Session->setFlash('Contact has been updated successfully.', 'success');	
			}
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
        	$contacts_count = $this->NetworkerContact->find('count',array('conditions'=>array('NetworkerContact.user_id'=>$userId,
        																					  'NetworkerContact.contact_email LIKE' => "$alphabet%"
        																					  )
        																  )
        													);
            $alphabets[$alphabet] = $contacts_count; 
        }
		
        $this->set('alphabets',$alphabets);
        $this->set('contacts',$contacts);
        $this->set('contact',null);
        $this->set('startWith',$startWith);
	}
	
	/*	show personal contact to Edit..	*/
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

	/* to show network statistics*/
	function networkerData(){
		$parent_id = null;
		$userId = $this->TrackUser->getCurrentUserId();	
		$networkerData = $this->getRecursiveData($userId);
		$this->set('networkerData',$networkerData);
	}

	function getRecursiveData($userId){	
		$Users   = $this->User->find('list',array('fields'=>'id','conditions'=>array('User.parent_user_id'=>$userId)));
		
		if(count($Users)== 0 ){
			return null;
			
		}
  	    return array_merge(array(count($Users)),(array)$this->getRecursiveData($Users));
	}



	
	/*	Adding contacts by Importing CSV	*/
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
						$contacts[$key]['contact_name'] = ucfirst($val[0]).ucfirst($val[1]).ucfirst($val[2]);
						$contacts[$key]['contact_email'] = $val[3];
					}	
				}	
				unset($contacts[0]);
				$duplicate_emails = array();
				$added_count = 0;
				$duplicate_count = 0;
				//echo "<pre>"; print_r($contacts); exit;
				foreach($contacts as $contact){
					if ($this->NetworkerCsvcontact->create($contact)) {
						$matchEmail = $this->NetworkerCsvcontact->find('first',array('conditions'=>array(
																				'NetworkerCsvcontact.user_id'=>$userId,
																				'NetworkerCsvcontact.contact_email'=>$contact['contact_email']
																				)
													));
						if(isset($matchEmail['NetworkerCsvcontact'])){
							$duplicate_emails[] = $this->NetworkerCsvcontact->data['NetworkerCsvcontact']['contact_email'];	
							++$duplicate_count;
							continue;
						}
						if(!$this->NetworkerCsvcontact->save($contact)){
							$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
							$this->redirect('/networkers/addContacts');
							return;
						}
						++$added_count;
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
	
	/*	delete multiple contacts.....*/
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
		if($this->NetworkerContact->delete($ids)){
			$this->Session->setFlash('contact has been deleted successfuly.', 'success');				
		}	
		$this->redirect('/networkers/personal');
	}
		  
	function archiveJob(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        
    	$networker_settings = $this->NetworkerSettings->find('all',array('conditions'=>array('user_id'=>$userId)));
		
        if(count($networker_settings)>0){
			for($n=0;$n<count($networker_settings);$n++){
				$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
				$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
				$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
				$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

				$tempCond = array();
				if($industry[$n]>1){
					$tempCond[] = array('Job.industry' => $industry[$n]);
				
				}
				if($specification[$n])
						$tempCond[] = array('Job.specification' => $specification[$n]);
				if($city[$n])
					$tempCond[] = array('Job.city ' => $city[$n]);
		        if($state[$n])
		        	$tempCond[] = array('Job.state' => $state[$n]);
				  
			
				if(!$tempCond){
					$tempCond = array(1);
				}
				$job_cond[$n] =  array('AND' =>$tempCond);
			
			}
		
				   
			$shortByItem = 'created';
			$order		 = 'desc';
		    
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
								$order		 = 'desc';
			    				break;	
			    	case 'company-name':
			    				$shortByItem = 'company_name';
								$order		 = 'asc'; 
			    				break;
			    	case 'industry':
			    				$shortByItem = 'industry';
								$order		 = 'asc'; 
			    				break;
			    	case 'salary':
			    				$shortByItem = 'salary_from';
								$order		 = 'asc'; 
			    				break;
			    	default:
			    			$this->redirect("/jobs");	        		        	
			    }
			}

			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 0))); 

			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:5,
									'joins'=>array(array('table' => 'industry',
												         'alias' => 'ind',
												         'type' => 'LEFT',
												         'conditions' => array('Job.industry = ind.id',)
											        ),
												   array('table' => 'specification',
												         'alias' => 'spec',
												         'type' => 'LEFT',
												         'conditions' => array('Job.specification = spec.id',)
											        ),
												   array('table' => 'cities',
												         'alias' => 'city',
												         'type' => 'LEFT',
												         'conditions' => array('Job.city = city.id',)
											        ),
                                                    array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('Job.company_id = comp.id',)),
												   array('table' => 'states',
												         'alias' => 'state',
												         'type' => 'LEFT',
												         'conditions' => array('Job.state = state.id',)
											        )),
		                            'order' => array("Job.$shortByItem" => $order,),
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');	

			$archivejobs = $this->Job->find('count',array('conditions'=>$cond));	
			$newjobs     = $this->Job->find('count',array('conditions'=>array('OR' => $job_cond,
						   											'AND' => array('is_active' => 1)) ));
		}else{
			$this->Session->setFlash('Please fill you settings in order to get jobs matching your profile.', 'error');				
			$this->redirect('/networkers/setting');
		}
		$this->set('ArchiveJobs',$archivejobs);
		$this->set('NewJobs',$newjobs);
		$this->set('jobs',$jobs);
	}

	function newJob(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        
    	$networker_settings = $this->NetworkerSettings->find('all',array('conditions'=>array('user_id'=>$userId)));
		
        if(count($networker_settings)>0){
			for($n=0;$n<count($networker_settings);$n++){
				$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
				$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
				$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
				$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

				$tempCond = array();
				if($industry[$n]>1){
					$tempCond[] = array('Job.industry' => $industry[$n]);
				
				}
				if($specification[$n])
						$tempCond[] = array('Job.specification' => $specification[$n]);
				if($city[$n])
					$tempCond[] = array('Job.city ' => $city[$n]);
		        if($state[$n])
		        	$tempCond[] = array('Job.state' => $state[$n]);
				  
			
				if(!$tempCond){
					$tempCond = array(1);
				}
				$job_cond[$n] =  array('AND' =>$tempCond);
			
			}
		
				   
			$shortByItem = 'created';
			$order		 = 'desc';
		    
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
								$order		 = 'desc';
			    				break;	
			    	case 'company-name':
			    				$shortByItem = 'company_name';
								$order		 = 'asc'; 
			    				break;
			    	case 'industry':
			    				$shortByItem = 'industry';
								$order		 = 'asc'; 
			    				break;
			    	case 'salary':
			    				$shortByItem = 'salary_from';
								$order		 = 'asc'; 
			    				break;
			    	default:
			    			$this->redirect("/jobs");	        		        	
			    }
			}
			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 1))); 

			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:5,
									'joins'=>array(array('table' => 'industry',
												         'alias' => 'ind',
												         'type' => 'LEFT',
												         'conditions' => array('Job.industry = ind.id',)
											        ),
												   array('table' => 'specification',
												         'alias' => 'spec',
												         'type' => 'LEFT',
												         'conditions' => array('Job.specification = spec.id',)
											        ),
												   array('table' => 'cities',
												         'alias' => 'city',
												         'type' => 'LEFT',
												         'conditions' => array('Job.city = city.id',)
											        ),
                                                    array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('Job.company_id = comp.id',)),
												   array('table' => 'states',
												         'alias' => 'state',
												         'type' => 'LEFT',
												         'conditions' => array('Job.state = state.id',)
											        )),
		                            'order' => array("Job.$shortByItem" => $order,),
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');	

			$newjobs = $this->Job->find('count',array('conditions'=>$cond));
			$archivejobs = $this->Job->find('count',array('conditions'=>array('OR' => $job_cond,
						   									'AND' => array('is_active' => 0))));
			$this->set('ArchiveJobs',$archivejobs);
			$this->set('NewJobs',$newjobs);
			$this->set('jobs',$jobs);	
		}else{
			$this->Session->setFlash('Please fill you settings in order to get jobs matching your profile.', 'error');				
			$this->redirect('/networkers/setting');
		}
		
	}

	function jobData(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        
    	$networker_settings = $this->NetworkerSettings->find('all',array('conditions'=>array('user_id'=>$userId)));
		
        if(count($networker_settings)>0){
			for($n=0;$n<count($networker_settings);$n++){
				$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
				$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
				$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
				$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

				$tempCond = array();
				if($industry[$n]>1){
					$tempCond[] = array('Job.industry' => $industry[$n]);
				
				}
				if($specification[$n])
						$tempCond[] = array('Job.specification' => $specification[$n]);
				if($city[$n])
					$tempCond[] = array('Job.city ' => $city[$n]);
		        if($state[$n])
		        	$tempCond[] = array('Job.state' => $state[$n]);
				  
			
				if(!$tempCond){
					$tempCond = array(1);
				}
				$job_cond[$n] =  array('AND' =>$tempCond);
			
			}			
			
			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 1))); 			

			$newjobs = $this->Job->find('count',array('conditions'=>$cond));
			$archivejobs = $this->Job->find('count',array('conditions'=>array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 0)))));
				
		}else{
			$newjobs = 0;
			$archivejobs = 0;
		}

		$payment = $this->PaymentHistory->find('all',array('conditions'=>array('PaymentHistory.payment_status'=>1,
																			   'jobseeker_apply.intermediate_users LIKE' => "%$userId%"),
														   'joins'=>array(
																		array('table' => 'jobseeker_apply',
												  							  'alias' => 'jobseeker_apply',
												  							  'type' => 'LEFT',
												  							  'conditions' => array('PaymentHistory.applied_job_id = jobseeker_apply.id ')
											     							),
																		array('table' => 'jobs',
												 							  'alias' => 'jobs',
												                              'type' => 'LEFT',
												                              'conditions' => array('PaymentHistory.job_id = jobs.id ')
											     							)
		
																		),
															'fields'=>array('SUM((jobs.reward)*0.75) as networker_reward'),
							
							
														  )
											 );
		if($payment[0][0]['networker_reward']!=""){
			$total_reward = $payment[0][0]['networker_reward'];
		}else{
			$total_reward = 0;
		}
		$this->set('TotalReward',$total_reward);
		$this->set('NewJobs',$newjobs);
		$this->set('ArchiveJobs',$archivejobs);
	}
 
}
?>
