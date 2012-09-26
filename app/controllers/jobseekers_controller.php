<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';
	var $uses = array('JobseekerSettings', 'Jobseekers', 'User', 'Job', 'JobseekerApply', 'JobseekerProfile', 'University','ReceivedJob','Invitation');
	var $components = array('Email','Session','TrackUser','Utility');
	var $helpers = array('Time','Html','Javascript');	

	function beforeFilter(){
		parent::beforeFilter();
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
		if($this->userRole!=JOBSEEKER){
			$this->redirect("/users/loginSuccess");
		}
		
	}

	function beforeRender(){
		$jobCounts=$this->jobCounts();
		$this->set('AppliedJobs',$jobCounts['appliedJob']);
		$this->set('NewJobs',$jobCounts['newJob']);
		$this->set('Archivedjobs',$jobCounts['archiveJob']);
	}
	
	function sendNotifyEmail(){
		if (!defined('CRON_DISPATCHER')){ 
			//$this->redirect('/'); 
			//exit(); 
		}
    	
		$this->layout = null; // turn off the layout    
    	$userId = $this->TrackUser->getCurrentUserId();
		$jobseekerData = $this->JobseekerSettings->find('all',array('conditions'=>array('notification'=>1)));
	}

	/* 	Jobseeker's Account-Profile page*/
	function index(){
		$this->layout= "home";
		$userId = $this->_getSession()->getUserId();		
        if($userId){
			$user = $this->UserList->find('first', array('conditions'=>array('UserList.id'=>$userId),
														'recursive'=>"-1",
														'joins'=>array(
														array(
															'table'=>'jobseekers',
															'alias'=>'Jobseeker',
															'type'=>'left',
															'conditions'=>'UserList.id = Jobseeker.user_id',
														),
														array(
															'table'=>'universities',
															'type'=>'left',
															'alias'=>'Universities',
															'conditions'=>'Universities.id=Jobseeker.university_id',
														),
														array(
															'table'=>'graduate_degrees',
															'type'=>'left',
															'alias'=>'GraduateDegrees',
															'conditions'=>'GraduateDegrees.id=Jobseeker.graduate_degree_id',
														),
														array(
															'table'=>'graduate_university_breakdown',
															'type'=>'left',
															'alias'=>'GUB',
															'conditions'=>array(
																		'GUB.id=Jobseeker.graduate_university_id',
																		'GUB.degree_type=Jobseeker.graduate_degree_id')
),
														
														),'fields'=>array('Jobseeker.*,GUB.id,GUB.graduate_college,Universities.id,Universities.name,UserList.*,GraduateDegrees.*'),
														));
			$jobseeker = $user['Jobseeker'];
			if(!isset($jobseeker['contact_name']) || empty($jobseeker['contact_name'])){
				$this->redirect("/jobseekers/editProfile");						
			}
			$this->set('user',$user);
			$this->set('jobseeker',$jobseeker);
		}
		else{		
			$this->Session->setFlash('Internal error has been occured...', 'error');	
			$this->redirect('/');								
		}
	}	

	/* 	Setting and Subscriptoin page*/
	function setting(){
		$this->layout="home";
		$session = $this->_getSession();
		$userId = $session->getUserId();		
		$jobseeker = $this->Jobseekers->find('first',array('conditions'=>array('user_id'=>$userId)));
		$jobseekerId =$jobseeker['Jobseekers']['id'];
		if(isset($this->data['JobseekerSettings']))
		{
			$this->data['JobseekerSettings']['jobseeker_id'] = $jobseekerId;
			$this->data['JobseekerSettings']['user_id'] = $userId;
			$this->data['JobseekerSettings']['specification_1'] = implode(',',!empty($this->data['JobseekerSettings']['industry_specification_1'])?$this->data['JobseekerSettings']['industry_specification_1']:array());
			$this->data['JobseekerSettings']['specification_2'] = implode(',',!empty($this->data['JobseekerSettings']['industry_specification_2'])?$this->data['JobseekerSettings']['industry_specification_2']:array());
			$this->JobseekerSettings->set($this->data['JobseekerSettings']);
			if( $this->JobseekerSettings->validates()  && $this->JobseekerSettings->save()){
				$this->Jobseekers->id =$jobseekerId;
				if(isset($this->data['Jobseekers']['contact_name']) && $this->Jobseekers->saveField('contact_name', $this->data['Jobseekers']['contact_name'],true)){
					$session->start();
					$this->Session->setFlash('Your Setting has been saved successfully.', 'success');
				}
			}
		
		}
		$jobseekerData = $this->Jobseekers->find('first',array('conditions'=>
																	array('Jobseekers.user_id'=>$userId),
																	 'joins'=>array(array(
																	 	'table'=>'jobseeker_settings',
																	 	'type'=>'left',
																		'conditions'=>array(
																				'jobseeker_settings.user_id=Jobseekers.user_id',
																			))
																 	 ),
															 		'fields'=>'jobseeker_settings.*,Jobseekers.*',
														));
		$jobseekerData['jobseeker_settings']['contact_name'] =$jobseekerData['Jobseekers']['contact_name'];
		$this->set('jobseekerData',$jobseekerData['jobseeker_settings']);	
		$this->set('industries',$this->Utility->getIndustry());
		$this->set('states',$this->Utility->getState());
	}

	/* 	Edit Jobseeker's Account-Profile*/   
    function editProfile() {
    	$this->layout = "home";
		$session = $this->_getSession();
		$userId = $session->getUserId();
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			if($this->Jobseekers->save($this->data['Jobseekers'])){
				$session->start();
				$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
				if($this->_getSession()->getBeforeApplyUrl()){
					$refrer = $this->_getSession()->getBeforeApplyUrl();
					$this->_getSession()->setBeforeApplyUrl('');
					$this->redirect($refrer);
				}else{
					$this->redirect('/jobseekers');	
				}
			}else{
				$this->Session->setFlash('May be you click on old link or manually enter URL.', 'error'); 
			}
		}

		$graduateDegrees =$this->Utility->getGraduateDegrees();
		
		$user = $this->UserList->find('first', array('conditions'=>array('UserList.id'=>$userId),
														'recursive'=>"-1",
														'joins'=>array(
														array(
															'table'=>'jobseekers',
															'alias'=>'Jobseeker',
															'type'=>'left',
															'conditions'=>'UserList.id = Jobseeker.user_id',
														),
														array(
															'table'=>'universities',
															'type'=>'left',
															'alias'=>'Universities',
															'conditions'=>'Universities.id=Jobseeker.university_id',
														),
														array(
															'table'=>'graduate_university_breakdown',
															'type'=>'left',
															'alias'=>'GUB',
															'conditions'=>array(
																		'GUB.id=Jobseeker.graduate_university_id',
																		'GUB.degree_type=Jobseeker.graduate_degree_id')
),
														
														),'fields'=>array('Jobseeker.*,GUB.id,GUB.graduate_college,Universities.id,Universities.name,UserList.*'),
														));
       	$this->set('user',$user);
       	$this->set('graduateDegrees',$graduateDegrees);
        if(isset($user['Jobseeker'])){
        	$this->set('jobseeker',$user['Jobseeker']);
        }
	}

      function appliedJob() {
		$this->layout ="home";
        $userId = $this->_getSession()->getUserId();	
        $shortByItem = 'JobseekerApply.created';
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
	        				$shortByItem = 'JobseekerApply.created'; 
							$order       = 'desc';       				
	       					break;	
	        	case 'company-name':
	        				$shortByItem = 'comp.company_name'; 
							$order       = 'asc';
	        				break;
	        	case 'industry':
	        				$shortByItem = 'job.industry'; 
							$order       = 'asc';
	        				break;
	        	case 'salary':
	        				$shortByItem = 'job.salary_from'; 
							$order       = 'asc';
	        				break;
	        	default:
	        			$this->redirect("/jobs");	        		        	
	        }
		}
		
		$this->paginate = array(
            'conditions'=>array('JobseekerApply.user_id'=>$userId,'job.is_active'=>1),
            'limit' => isset($displayPageNo)?$displayPageNo:6,
								'joins'=>array(
												array('table' => 'jobs',
										             'alias' => 'job',
										             'type' => 'LEFT',
										             'conditions' => array('job.id = JobseekerApply.job_id')
									            ),

												array('table' => 'industry',
										             'alias' => 'ind',
										             'type' => 'LEFT',
										             'conditions' => array('job.industry = ind.id',)
									            ),
											   array('table' => 'specification',
										             'alias' => 'spec',
										             'type' => 'LEFT',
										             'conditions' => array('job.specification = spec.id',)
									            ),
												
											   array('table' => 'cities',
										             'alias' => 'city',
										             'type' => 'LEFT',
										             'conditions' => array('job.city = city.id',)
									            ),
                                               array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('job.company_id = comp.id',)),
											   array('table' => 'states',
										             'alias' => 'state',
										             'type' => 'LEFT',
										             'conditions' => array('job.state = state.id',)
									            )),
                                'order' => array("$shortByItem" => $order,),
								'fields'=>array('job.id ,job.user_id,job.title,comp.company_name,city.city,state.state,job.job_type,job.short_description, job.reward, job.created, JobseekerApply.is_active, ind.name as industry_name, spec.name as specification_name'),);

		$jobs = $this->paginate('JobseekerApply');	      
		$this->set('jobs',$jobs);
     }

	function newJob(){
		$this->layout= "home";
		$userId = $this->_getSession()->getUserId();	
	
		$receivedJobs=$this->ReceivedJob->find('list',array('conditions'=>array('user_id'=>$userId),'fields'=>'job_id'));
		
		$jobseeker_settings = $this->getJobseekerSettings($userId);

		$applied_job = $this->JobseekerApply->find('all',array('conditions'=>array('user_id'=>$userId),
															   'fields'=>array('job_id'),));
		$jobIds = array();
		for($a=0;$a<count($applied_job);$a++){
			$jobIds[$a] = $applied_job[$a]['JobseekerApply']['job_id'];
		}
		
        
        $industry1 		= $jobseeker_settings['JobseekerSettings']['industry_1'];
		$industry2 		= $jobseeker_settings['JobseekerSettings']['industry_2'];
		
		$specification1 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_1']);
	    $specification2 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_2']);
		
	    $city 			= $jobseeker_settings['JobseekerSettings']['city'];
		$state 			= $jobseeker_settings['JobseekerSettings']['state'];
		$salary_range   = $jobseeker_settings['JobseekerSettings']['salary_range'];
        
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
							$this->redirect('/jobseekers/newJob');        		        	
			}
		}

		if($industry1>1){
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.industry' =>$industry1,'Job.specification' =>$specification1);
			}else{
				$industry1_cond=array('Job.industry' =>$industry1);
			}
		}else{
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.specification' =>$specification1);
			}else{
				$industry1_cond=true;
			}
		}
		
		if($industry2>1){
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.industry' =>$industry2,'Job.specification' =>$specification2);
			}else{
				$industry2_cond=array('Job.industry' =>$industry2);
			}
		}else{
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.specification' =>$specification2);
			}else{
				$industry2_cond=true;
			}
		}

		 $cond = array('OR'=>array('AND'=>array('OR'=>array($industry1_cond,$industry2_cond),
                       'Job.salary_from >=' => $salary_range),'Job.id'=>$receivedJobs),
					  'Job.is_active'  => 1,
					 'AND' => array('NOT'=>array(array('Job.id'=> $jobIds)))
					);
		if($city)
			$cond['Job.city']  = $city;
                      
        if($state)
            $cond['Job.state'] = $state;


		$this->paginate = array('conditions'=>$cond,
            'limit' => isset($displayPageNo)?$displayPageNo:6,
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
								'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, Job.is_active, ind.name as industry_name, spec.name as specification_name'),);		
           

		$jobs = $this->paginate('Job');
		$this->set('jobs',$jobs);
	}

	function archivedJob(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();	
	
		$jobseeker_settings = $this->getJobseekerSettings($userId);

		$applied_job = $this->JobseekerApply->find('all',array('conditions'=>array('JobseekerApply.user_id'=>$userId,'Job.is_active' =>1),
															   'fields'=>array('job_id'),
															   'joins'=>array(
															   		array(
																   		'table'=>'jobs',
																   		'alias'=>'Job',
																   		'type'=>'LEFT',
																   		'conditions'=> array('JobseekerApply.job_id = Job.id')
																   	)
															   	),
															)
														);
		$jobIds = array();
		for($a=0;$a<count($applied_job);$a++){
			$jobIds[$a] = $applied_job[$a]['JobseekerApply']['job_id'];
		}

		 if(empty($jobIds)){
			$jobIds = null;
		}
        
        $industry1 		= $jobseeker_settings['JobseekerSettings']['industry_1'];
		$industry2 		= $jobseeker_settings['JobseekerSettings']['industry_2'];

		$specification1 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_1']);
	    $specification2 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_2']);

	    $city 			= $jobseeker_settings['JobseekerSettings']['city'];
		$state 			= $jobseeker_settings['JobseekerSettings']['state'];
		$salary_range   = $jobseeker_settings['JobseekerSettings']['salary_range'];
        
       
		$shortByItem = 'created';
		$order		 = 'desc';
        
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
							$this->redirect('/jobseekers/archivedJob');        		        	
			}
		}

		if($industry1>1){
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.industry' =>$industry1,'Job.specification' =>$specification1);
			}else{
				$industry1_cond=array('Job.industry' =>$industry1);
			}
		}else{
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.specification' =>$specification1);
			}else{
				$industry1_cond=true;
			}
		}
		
		if($industry2>1){
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.industry' =>$industry2,'Job.specification' =>$specification2);
			}else{
				$industry2_cond=array('Job.industry' =>$industry2);
			}
		}else{
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.specification' =>$specification2);
			}else{
				$industry2_cond=true;
			}
		}

		 $cond = array('OR'=>array($industry1_cond,$industry2_cond),
                       'Job.salary_from >=' => $salary_range,
					  'Job.is_active'  => 0,
					 'AND' => array('NOT'=>array(array('Job.id'=> $jobIds)))
					);

		if($city)
			$cond['Job.city']  = $city;
                      
        if($state)
            $cond['Job.state'] = $state;


		$this->paginate = array('conditions'=>$cond,
            'limit' => isset($displayPageNo)?$displayPageNo:6,
								'joins'=>array(array(
													'table' => 'industry',
										            'alias' => 'ind',
										            'type' => 'LEFT',
										            'conditions' => array('Job.industry = ind.id',)
												),
												array(
													'table' => 'specification',
													'alias' => 'spec',
										            'type' => 'LEFT',
										            'conditions' => array('Job.specification = spec.id',)
												),
												array(
													'table' => 'cities',
										            'alias' => 'city',
										            'type' => 'LEFT',
										            'conditions' => array('Job.city = city.id',)
												),
												array(
													'table' => 'companies',
						             				'alias' => 'comp',
						                            'type' => 'LEFT',
    				                               	'conditions' => array('Job.company_id = comp.id',)
												),
												array(
													'table' => 'states',
										            'alias' => 'state',
										            'type' => 'LEFT',
										            'conditions' => array('Job.state = state.id',)
												),
												array(
													'table'=>'jobseeker_apply',
													'alias'=>'JobseekerApply',
													'type'=>'LEFT',
													'fields'=>'JobseekerApply.is_active',
													'conditions'=> array('JobseekerApply.job_id=Job.id','JobseekerApply.user_id='.$userId)
												),
											),
                                'order' => $shortByItem,
								'fields'=>array('Job.id, Job.user_id, Job.title, comp.company_name, city.city, state.state,Job.job_type,Job.short_description, Job.reward, Job.created, Job.is_active, ind.name as industry_name, spec.name as specification_name,JobseekerApply.is_active'),);
 
		$newjobs = $this->Job->find('count',array('conditions'=>$cond));     
           
		$jobs = $this->paginate('Job');
		$this->set('jobs',$jobs);

	}

    
   function delete(){
        
        $deleteID = is_numeric($this->params['id'])?$this->params['id']:null;
        $userId = $this->_getSession()->getUserId();
		if($deleteID){
            $jobseekerapply = $this->JobseekerApply->find('all',array('conditions' => array('job_id' =>$deleteID,'user_id'=>$userId))); 
        	if(isset($jobseekerapply) && $jobseekerapply != null){
				foreach($jobseekerapply as $deljob)
				{
				 $oldresume = $deljob['JobseekerApply']['resume'];
				 $oldcoverletter = $deljob['JobseekerApply']['cover_letter'];
				 $this->JobseekerApply->delete($deljob['JobseekerApply']['id']);
				 @unlink(APP."webroot/files/resume/".$oldresume);
				 @unlink(APP."webroot/files/cover_letter/".$oldcoverletter);
				}
			    $this->Session->setFlash('Job successfully deleted.', 'success'); 
			}else
                $this->Session->setFlash('May be you click on old link or manually enter URL.', 'error'); 
			
        }else{
        	$this->Session->setFlash('May be you click on old link or manually enter URL.', 'error'); 
        }	
        $this->redirect('/jobseekers/appliedJob');	  
   }

	function jobProfile(){
		$this->layout = "home";
		$userId = $this->_getSession()->getUserId();
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId),
																  'joins'=>array(
																  			array(
																  			'table'=>'universities',
																  		 	'type'=>'inner',
																  		 	'alias'=>'uns',
																	  	'conditions'=>'uns.id=JobseekerProfile.answer6'
																  )),
																'fields'=>'JobseekerProfile.*,uns.*',
												));
		$universities=$this->University->find('list',array('fields'=>'id,name'));

		$this->set('universities',$universities);
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);
		$this->set('is_resume', $jobprofile['JobseekerProfile']['resume']);
		$this->set('is_cover_letter', $jobprofile['JobseekerProfile']['cover_letter']);

		if(isset($this->data['JobseekerProfile'])){
		
			if(is_uploaded_file($this->data['JobseekerProfile']['resume']['tmp_name'])){
				$resume = $this->data['JobseekerProfile']['resume'];                 
            	if($resume['error']!=0 ){
                	$this->Session->setFlash('Uploaded File is corrupted.', 'error');    
                    $this->data['JobseekerProfile']['resume'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerProfile']);  
					$this->render("job_profile"); 
					return;         
                }
               $type_arr = explode(".",$resume['name']);
				
                $type = $type_arr[1];
                if($type!= 'pdf' && $type!= 'txt' && $type!= 'doc' && $type!='docx' && $type!='odt' || $resume['size'] >307251 ){
                	$this->Session->setFlash('Please ensure that you are uploading a supported file format of max size 300 Kb', 'error'); 
                    $this->data['JobseekerProfile']['resume'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerProfile']);  
					$this->render("job_profile"); 
					return;
                }
                $randomNumber = rand(1,100000000000);            
                $uploadedFileName=$randomNumber.$resume['name'];
                if(move_uploaded_file($resume['tmp_name'],APP."webroot/files/resume/".$uploadedFileName)){
                	$this->data['JobseekerProfile']['resume'] = $uploadedFileName;
                }
			}else{
				$this->data['JobseekerProfile']['resume'] = $jobprofile['JobseekerProfile']['resume'];
			}

			if(is_uploaded_file($this->data['JobseekerProfile']['cover_letter']['tmp_name'])){
				$cover_letter = $this->data['JobseekerProfile']['cover_letter'];                 
            	if($cover_letter['error']!=0 ){
                	$this->Session->setFlash('Uploaded File is corrupted.', 'error');    
                    $this->data['JobseekerProfile']['cover_letter'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerProfile']);  
					$this->render("job_profile"); 
					return;        
                }
                $type_arr1 = explode(".",$cover_letter['name']);				
                $type1 = $type_arr1[1];
				
                if($type1!= 'pdf' && $type1!= 'txt' && $type1!= 'doc' && $type1!='docx' && $type1!='odt' || $cover_letter['size'] >307251){
                $this->Session->setFlash('Please ensure that you are uploading a supported file format of max size 300 Kb', 'error'); 
					$this->data['JobseekerProfile']['cover_letter'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerProfile']);  
					$this->render("job_profile"); 
					return;
                }
                $randomNumber2 = rand(1,100000000000);            
                $uploadedFileName2=$randomNumber2.$cover_letter['name'];

                if(move_uploaded_file($cover_letter['tmp_name'],APP."webroot/files/cover_letter/".$uploadedFileName2)){
                	$this->data['JobseekerProfile']['cover_letter'] = $uploadedFileName2;
                }
			}else{
				$this->data['JobseekerProfile']['cover_letter']=$jobprofile['JobseekerProfile']['cover_letter'];
			}            
			
			if($this->JobseekerProfile->save($this->data['JobseekerProfile'])){
				$this->Session->setFlash('Profile Infomation has been updated successfuly.', 'success');	
				$this->redirect('jobProfile');	
			}			
		}
	}

	function viewResume(){
		$userId = $this->_getSession()->getUserId();
        		
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);

		
		if(isset($this->params['id'])){
			$id = $this->params['id'];
			$file_type = $this->params['filetype'];
			$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('id'=>$id)));
			if($jobprofile['JobseekerProfile']){

				if($file_type=='resume'){
					$file = $jobprofile['JobseekerProfile']['resume'];
					$fl = APP."webroot/files/resume/".$file;
				}
				if($file_type=='cover_letter'){
					$file = $jobprofile['JobseekerProfile']['cover_letter'];
					$fl = APP."webroot/files/cover_letter/".$file;
				}				
				
				if (file_exists($fl)){
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename='.basename($fl));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($fl));
					ob_clean();
					flush();
					readfile($fl);
					exit;
				}else{
					$this->Session->setFlash('File does not exist.', 'error');				
					$this->redirect('/jobs/jobProfile');
				}				
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/jobProfile');
			}
		}		
	}

	public function jobCounts(){
		$userId = $this->_getSession()->getUserId();
		
		$receivedJobs=$this->ReceivedJob->find('list',array('conditions'=>array('user_id'=>$userId),'fields'=>'job_id'));
		
		$jobseeker_settings = $this->getJobseekerSettings($userId);
		$applied_job = $this->JobseekerApply->find('all',array('conditions'=>array('JobseekerApply.user_id'=>$userId,'Job.is_active' =>1),
															   'fields'=>array('job_id'),
															   'joins'=>array(
															   		array(
																   		'table'=>'jobs',
																   		'alias'=>'Job',
																   		'type'=>'LEFT',
																   		'fields'=>'Job.is_active',
																   		'conditions'=> array('JobseekerApply.job_id = Job.id')
																   	)
															   	),
															)
														);
		for($a=0;$a<count($applied_job);$a++){
			$jobIds[$a] = $applied_job[$a]['JobseekerApply']['job_id'];
		}
		if(empty($jobIds)){
			$jobIds = null;
		}
        $industry1 		= $jobseeker_settings['JobseekerSettings']['industry_1'];
		$industry2 		= $jobseeker_settings['JobseekerSettings']['industry_2'];
		
		$specification1 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_1']);
	    $specification2 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_2']);
	    
		$city 			= $jobseeker_settings['JobseekerSettings']['city'];
		$state 			= $jobseeker_settings['JobseekerSettings']['state'];
		$salary_range   = $jobseeker_settings['JobseekerSettings']['salary_range'];
		
		if($industry1>1){
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.industry' =>$industry1,'Job.specification' =>$specification1);
			}else{
				$industry1_cond=array('Job.industry' =>$industry1);
			}
		}else{
			if(!empty($specification1[0])){
				$industry1_cond=array('Job.specification' =>$specification1);
			}else{
				$industry1_cond=true;
			}
		}

		if($industry2>1){
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.industry' =>$industry2,'Job.specification' =>$specification2);
			}else{
				$industry2_cond=array('Job.industry' =>$industry2);
			}
		}else{
			if(!empty($specification2[0])){
				$industry2_cond=array('Job.specification' =>$specification2);
			}else{
				$industry2_cond=true;
			}
		}
		
		$jobCounts['appliedJob']=count($applied_job);//Applied job count
		
		$cond_for_new_job = array('OR'=>array('AND'=>array('OR'=>array($industry1_cond,$industry2_cond),
                       'Job.salary_from >=' => $salary_range),'Job.id'=>$receivedJobs),
					  'Job.is_active'  => 1,
					 'AND' => array('NOT'=>array(array('Job.id'=> $jobIds)))
					);
                
		if($city)
			$cond_for_new_job['Job.city']  = $city;
                      
        if($state)
            $cond_for_new_job['Job.state'] = $state;
		
		$jobCounts['newJob'] = $this->Job->find('count',array('conditions'=>$cond_for_new_job));//New job count

		 $cond_for_archive_job = array('OR'=>array($industry1_cond,$industry2_cond),
                       'Job.salary_from >=' => $salary_range,
					  'Job.is_active'  => 0,
					 'AND' => array('NOT'=>array(array('Job.id'=> $jobIds)))
					);

		if($city)
			$cond_for_archive_job['Job.city']  = $city;
                      
        if($state)
            $cond_for_archive_job['Job.state'] = $state;
		
		$jobCounts['archiveJob'] = $this->Job->find('count',array('conditions'=>$cond_for_archive_job));//Archive job count
		
		return $jobCounts;
	}
	
	/**
	 * To get Jobseeker settings
	 */
	 public function getJobseekerSettings($userId){
	 	return $this->JobseekerSettings->find('first',array('conditions'=>array('user_id'=>$userId)));
	 }
	 
	 function invitations() {
	 	$this->layout ="home";
 	 	$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
	
		$userId = $session->getUserId();
		$this->set('invitationCode',null);
		
        /**** end code ***/	
        
		$startWith = isset($this->params['named']['alpha'])?$this->params['named']['alpha']:"";
	
		$paginateCondition = array(
									'AND' => array(
												array('Invitation.user_id'=>$userId),
												array('Invitation.name_email  LIKE' => "$startWith%")
											)
								);
		$this->paginate = array('conditions'=>$paginateCondition,
                                'limit' => 10,
                                'order' => array("Invitation.id" => 'asc',));  
		 	 	
		$invitationArray =	$this->Invitation->find('all' ,array('conditions'=>array('user_id'=>$userId))) ;
        $Invitations = $this->paginate('Invitation');
	
	    $alphabets = array();
        foreach(range('A','Z') AS $alphabet){
        	$contacts_count = $this->Invitation->find('count',array('conditions'=>array('Invitation.user_id'=>$userId,
        																			 	'Invitation.name_email LIKE' => "$alphabet%"
        																					  )
        																  )
        													);
            $alphabets[$alphabet] = $contacts_count; 
        }
		
        $this->set('alphabets',$alphabets);
		$this->set("invitations", $Invitations);        
        $this->set('contact',null);
        $this->set('startWith',$startWith);
 
	 }

}
?>
