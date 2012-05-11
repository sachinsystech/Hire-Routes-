<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array(	'Networkers',
						'NetworkerContact', 
						'NetworkerCsvcontact', 
						'NetworkerSettings',
						'PaymentHistory',
						'JobseekerApply',
						'University',
						'SharedJob',
						'User',
						'Job',
					);
	var $components = array('Email','Session','TrackUser','Utility');	
	var $helpers = array('Time','Form');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/users/login");
		}
		if($this->userRole!=NETWORKER){
			$this->redirect("/users/loginSuccess");
		}
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
		$userId = $this->_getSession()->getUserId();		
        if($userId){
        	/* User Info*/			
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId),
													'joins'=>array(
																array(
																	'table'=>'networkers',
																	'type'=>'LEFT',
																	'conditions'=>array("networkers.user_id"=>$userId) 
																),
																array(
																'table'=>'universities',
																'type'=>'LEFT',
													'conditions'=>array('universities.id=networkers.university'),
																)),
													'fields'=>array('User.*, networkers.*,universities.*'),
													)
								);
			$networkers = $user['networkers'];
			$networkers['university']=$user['universities']['name'];
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
		$userId = $this->_getSession()->getUserId();
		if($this->Networkers->updateAll($this->data['Networkers'],array('user_id'=>$userId))){
			$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		}
		$this->redirect('/networkers/setting');		
	}
	
	/* 	Setting and Subscriptoin page*/
	function setting() {
		$userId = $this->_getSession()->getUserId();
		if(isset($this->data['NetworkerSettings'])){
			$this->data['NetworkerSettings']['user_id'] = $userId;
			$this->NetworkerSettings->set($this->data['NetworkerSettings']);
			if($this->NetworkerSettings->validates()){
				if($this->NetworkerSettings->save($this->data['NetworkerSettings'])){
					$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');
				}else{
					$this->Session->setFlash('Internal Error! try again.', 'error');
				}
			}
		}
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
		
		if(isset($networker) && $networker['Networkers']){
			$this->set('networker',$networker['Networkers']);
		}
	}
   
	/* 	Edit Networker's Account-Profile*/   
	function editProfile() {
		$session = $this->_getSession();
		$userId = $session->getUserId();
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			if($this->User->save($this->data['User'])){
				if($this->Networkers->save($this->data['Networkers'])){
					$session->start();
					$this->Session->setFlash('Profile has been updated successfuly.', 'success');
					$this->redirect('/networkers');
				}	
			}
		}
		$universities =$this->University->find('list');
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('universities',$universities);

        if(isset($user['Networkers'][0])){
        	$this->set('networker',$user['Networkers'][0]);
        }
	}
	
	/*	Add contact by single entry	*/
	function addContacts() {
		if(isset($this->data['Contact'])){
			$userId = $this->_getSession()->getUserId();
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
			$userId = $this->_getSession()->getUserId();
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
		$userId = $this->_getSession()->getUserId();
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
		$userId = $this->_getSession()->getUserId();
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
		$userId = $this->_getSession()->getUserId();
		$networkerData = $this->getRecursiveData($userId);
		$this->set('networkerData',$networkerData);
		$this->paginate=array(
			'fields'=>'User.id, Networker.contact_name, count(UserCount.id) as count',
			'conditions'=>array('User.parent_user_id'=>$userId),
			'recursive'=>-1,
			'joins'=>array(
				array(
					'table'=>'networkers',
					'alias'=>'Networker',
					'type'=>'left',
					'fields'=>'Networker.contact_name, Networker.user_id',
					'conditions'=>'Networker.user_id = User.id',
				),
				array(
					'table'=>'users',
					'alias'=>'UserCount',
					'type'=>'left',
					'fields'=>'count(parent_user_id)',
					'conditions'=>'UserCount.parent_user_id= Networker.user_id'
				)
				
			),
			'limit'=>10,
			'group'=>'User.id'
		);
		$firstDegreeNetworkers=$this->paginate('User');
		$this->set('firstDegreeNetworkers',$firstDegreeNetworkers);
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
		$userId = $this->_getSession()->getUserId();
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
		$userId = $this->_getSession()->getUserId();		
		    
    	$networker_settings = $this->getNetworkerSettings($userId);
		
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
		
			$shortByItem = array('Job.created'=> 'desc');
		    
		    if(isset($this->params['named']['display'])){
			    $displayPageNo = $this->params['named']['display'];
			    $this->set('displayPageNo',$displayPageNo);
			}
			if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
	        				$shortByItem = array('Job.created'=> 'desc'); 
	        				break;	
			    	case 'company-name':
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
			    				break;
			    	case 'industry':
			    				$shortByItem = array('ind.name'=> 'asc');  
			    				break;
			    	case 'salary':
			    				$shortByItem = array('Job.salary_from'=> 'asc'); 
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
		                            'order' => $shortByItem,
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');
		    $this->set('jobs',$jobs);
		}
		$jobCounts=$this->jobCounts();
		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		$this->set('ArchiveJobs',$jobCounts['archivejobs']);
		$this->set('NewJobs',$jobCounts['newJobs']);
	}

	function newJob(){
		$userId = $this->_getSession()->getUserId();	
		        
    	$networker_settings = $this->getNetworkerSettings($userId);
    	
    	$shared_job = $this->SharedJob->find('all',array('conditions'=>array('user_id'=>$userId),
															   'fields'=>'SharedJob.job_id',
															   'group'=>array('SharedJob.job_id')
															   )
															);
		$jobIds = array();
		for($a=0;$a<count($shared_job);$a++){
			$jobIds[$a] = $shared_job[$a]['SharedJob']['job_id'];
		}
		
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

		    if(isset($this->params['named']['display'])){
			    $displayPageNo = $this->params['named']['display'];
			    $this->set('displayPageNo',$displayPageNo);
			}
			
			$shortByItem = array('Job.created'=> 'desc');
			if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
	        				$shortByItem = array('Job.created'=> 'desc'); 
	        				break;	
			    	case 'company-name':
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
			    				break;
			    	case 'industry':
			    				$shortByItem = array('ind.name'=> 'asc');  
			    				break;
			    	case 'salary':
			    				$shortByItem = array('Job.salary_from'=> 'asc'); 
			    				break;
			    	default:
			    				$this->redirect('/networkers/newJob');        		        	
			    }
			}
			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 1),'NOT'=>array(array('Job.id'=> $jobIds))),
						 ); 

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
		                            'order' => $shortByItem,
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');
		    
//			$jobCounts=$this->jobCounts();
	//		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		//	$this->set('ArchiveJobs',$jobCounts['archivejobs']);
			//$this->set('NewJobs',$jobCounts['newJobs']);
			$this->set('jobs',$jobs);	
		}
		$jobCounts=$this->jobCounts();
		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		$this->set('ArchiveJobs',$jobCounts['archivejobs']);
		$this->set('NewJobs',$jobCounts['newJobs']);
		
	}

	function jobData(){
		$userId = $this->_getSession()->getUserId();		
		
		$payment = $this->PaymentHistory->find('all',array(
												'conditions'=>array(
													//'PaymentHistory.payment_status'=>1,
													'FIND_IN_SET('.$userId.',jobseeker_apply.intermediate_users)>0'),
														   'joins'=>array(
																		array('table' => 'jobseeker_apply',
												  							  'alias' => 'jobseeker_apply',
												  							  'type' => 'LEFT',
												  							  'conditions' => array('PaymentHistory.applied_job_id = jobseeker_apply.id ')
											     							),
																		/*array('table' => 'jobs',
												 							  'alias' => 'jobs',
												                              'type' => 'LEFT',
												                              'conditions' => array('PaymentHistory.job_id = jobs.id ')
											     							),*/
											     						array('table' => 'rewards_status',
												 							  'alias' => 'RewardsStatus',
												                              'type' => 'INNER',
												                              'conditions' => array('RewardsStatus.user_id ='.$userId.' AND RewardsStatus.status=1')
											     							),
		
																		),
															'fields'=>array('SUM(((PaymentHistory.amount)*(PaymentHistory.networker_reward_percent))/(substrCount(jobseeker_apply.intermediate_users,",")*100)) as networker_reward'),
							
							
														  )
											 );
		if($payment[0][0]['networker_reward']!=""){
			$total_reward = $payment[0][0]['networker_reward'];
		}else{
			$total_reward = 0;
		}
		$this->set('TotalReward',$total_reward);
		$jobCounts=$this->jobCounts();
		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		$this->set('ArchiveJobs',$jobCounts['archivejobs']);
		$this->set('NewJobs',$jobCounts['newJobs']);
	}
	
	/**
	 *	shared Job
	 */
	 function sharedJob(){
		$userId = $this->_getSession()->getUserId();	
		        	
		    if(isset($this->params['named']['display'])){
			    $displayPageNo = $this->params['named']['display'];
			    $this->set('displayPageNo',$displayPageNo);
			}
			
			$shortByItem = array('Job.created'=> 'desc');
			if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
	        				$shortByItem = array('Job.created'=> 'desc'); 
	        				break;	
			    	case 'company-name':
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
			    				break;
			    	case 'industry':
			    				$shortByItem = array('ind.name'=> 'asc');  
			    				break;
			    	case 'salary':
			    				$shortByItem = array('Job.salary_from'=> 'asc'); 
			    				break;
			    	default:
			    				$this->redirect('/networkers/sharedJob');        		        	
			    }
			}
			
			$cond = array('SharedJob.user_id'=>$userId); 
			$jobCounts=$this->jobCounts();
			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:5,
									'joins'=>array(array('table' => 'jobs',
												         'alias' => 'Job',
												         'type' => 'LEFT',
												         'conditions' => array('Job.id = SharedJob.job_id')
											        ),
											        array('table' => 'industry',
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
		                            'order' => $shortByItem,
		                            'group'=>array('SharedJob.job_id'),
		                            'myCount'=>$jobCounts['sharedJobs'],
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('SharedJob');	
			$this->set('SharedJobs',$jobCounts['sharedJobs']);
			$this->set('ArchiveJobs',$jobCounts['archivejobs']);
			$this->set('NewJobs',$jobCounts['newJobs']);
			$this->set('jobs',$jobs);			
	}

	/*
	 * To find job counts
	 *
	 */
	private function jobCounts(){
		$userId = $this->_getSession()->getUserId();		
		        
    	$networker_settings = $this->getNetworkerSettings($userId);
    	if(!(count($networker_settings)>0))
    		$this->Session->setFlash('Please fill you settings in order to get jobs matching your profile.', 'warning');
    	
    	$shared_job = $this->SharedJob->find('all',array('conditions'=>array('user_id'=>$userId),
															   'fields'=>'SharedJob.job_id',
															   'group'=>'SharedJob.job_id'
															   )
															);
		$jobIds = array();
		for($a=0;$a<count($shared_job);$a++){
			$jobIds[$a] = $shared_job[$a]['SharedJob']['job_id'];
		}
		
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
			
			$jobCounts['newJobs']= $this->Job->find('count',array(
												'conditions'=>array(
													'OR' => $job_cond,
						   							'AND' => array(
						   								array('is_active' => 1),
						   								'NOT'=>array(array('Job.id'=> $jobIds))
						   								)
						   							)
						   						)
						   					);
			$jobCounts['archivejobs']= $this->Job->find('count',array('conditions'=>array('OR' => $job_cond,
						   									'AND' => array('is_active' => 0))));
		}else{
			$jobCounts['newJobs']=0;
			$jobCounts['archivejobs']=0;
		}
		$jobCounts['sharedJobs']= $this->SharedJob->find('count',array('joins'=>array(
													array(
														'table'=>'jobs',
														'alias'=>'Job',
														'type'=>'left',
														'fields'=>'Job.is_active',
														'conditions'=>'Job.id=SharedJob.job_id AND Job.is_active = 1'
													),
												),
												'fields'=>'distinct SharedJob.job_id',
												'conditions'=>array(
													'SharedJob.user_id'=>$userId
												)
											)
										);
		return $jobCounts;
	}
	/**
	 * To get Networker Settings
	 */
	 private function getNetworkerSettings($userId){
	 	return $this->NetworkerSettings->find('all',array('conditions'=>array('user_id'=>$userId)));
	 }
}
?>
