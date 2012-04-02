<?php
class NotificationsController extends AppController {

	var $name = 'Notifications';
	var $uses = array('JobseekerSettings','User','Job','Industry','State','Specification',
			  'UserRoles', 'City','JobPost','Networkers','NetworkerSettings');

	var $components = array('Email');
	var $helpers = array('Html');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index');
		$this->Auth->allow('JobseekerEvery10Post');
		$this->Auth->allow('JobseekerEveryday');
		$this->Auth->allow('JobseekerEvery3day');
		$this->Auth->allow('JobseekerEveryWeek');
		$this->Auth->allow('NetworkerEvery10Post');
		$this->Auth->allow('NetworkerEveryday');
		$this->Auth->allow('NetworkerEvery3day');
		$this->Auth->allow('NetworkerEveryWeek');
		$this->autoRender = false;
    }

	
	function index(){
		
	}
	
	function JobseekerEvery10Post(){		
		echo "\n\t ******* Email Notification for Every 10 Post for Jobseekers start at :".date("Y-m-D H:i:s")." ***********\n";

		$send_job = 10;
		$subscription_cond = 10;
		$jobseeker_settings = $this->getJobseekerSettings($subscription_cond);	
		
		if(count($jobseeker_settings)){
			foreach($jobseeker_settings as $settings){

				$userId 		 = $settings['JobseekerSettings']['user_id'];				
				$last_job_posted = $this->JobPost->find('first',array('conditions'=>array('user_id'=> $userId,),
																      'order' => array("id" => 'desc',),));
				
				if($last_job_posted){
					$last_job_id = $last_job_posted['JobPost']['job_id'];			

					$setting_cond = array('Job.id >'=> $last_job_id,);
				}else{
					$setting_cond = "";
				}
				
				$jobData = $this->getAllJobseekerJobs($settings,$setting_cond,$send_job);
				$total_job     = count($jobData);	
				
				if($total_job==$send_job){								
					$last_job_id = $jobData[$send_job-1]['Job']['id'];
			
					$jobPost['JobPost']['user_id'] = $userId;
			    	$jobPost['JobPost']['job_id']  = $last_job_id;
					if($last_job_posted['JobPost']['id']){
						$jobPost['JobPost']['id'] = $last_job_posted['JobPost']['id'];
					}else{
						$jobPost['JobPost']['id'] = null;
					}
					
					$this->JobPost->save($jobPost);	
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";			
					$this->sendJobPostEmail($userId,$jobData);		
			 	}else{
					echo "\n\t\t\t\t No jobs to post for Jobseeker ".$userId."\n";
				} 
			}
		}else{
			echo "\n\t\t\t\t  No Jobseeker found to send Notification Email \n";
		}
		
		echo "\n\t ******* Email Notification for Every 10 Post for Jobseekers End at : ".date("Y-m-D H:i:s")." ***************\n\n\n";
	}
	
	function JobseekerEveryday(){
		echo "\n\t ******* Everyday email notifications for jobseeker start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond = 1;
		$jobseeker_settings = $this->getJobseekerSettings($subscription_cond);	
		
		if(count($jobseeker_settings)){		
			foreach($jobseeker_settings as $settings){

				$userId       = $settings['JobseekerSettings']['user_id'];
				$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-1 day")),
						          	  'created <'=> date("Y-m-d h:i:s"));
			
				$jobData = $this->getAllJobseekerJobs($settings,$setting_cond);
			
				if(count($jobData)>0){
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";					
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}
			}
		}else{
			echo "\n\t\t\t\t No Jobseeker found to send Notification Email ***********\n";
		}
		echo "\n\t ******* Everyday email notifications for jobseeker end at :".date("Y-m-D H:i:s")." ***********\n\n\n";		
	}

	function JobseekerEvery3day(){
		echo "\n\t ******* Every 3 day email notifications for jobseeker start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond = 3;
		$jobseeker_settings = $this->getJobseekerSettings($subscription_cond);

		if(count($jobseeker_settings)>0){
			foreach($jobseeker_settings as $settings){
				$userId       = $settings['JobseekerSettings']['user_id'];
				$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-3 day")),
						          	  'created <'=> date("Y-m-d h:i:s"));
			
				$jobData = $this->getAllJobseekerJobs($settings,$setting_cond);			
			
				if(count($jobData)>0){
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";						
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}
			}
		}else{
			echo "\n\t\t\t\t No Jobseeker found to send Notification Email \n";
		}
		
		echo "\n\t ******* Every 3 day email notifications for jobseekers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";		
	}

	function JobseekerEveryWeek(){		
		echo "\n\t ******* Every week email notifications for jobseeker start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond = 7;
		$jobseeker_settings = $this->getJobseekerSettings($subscription_cond);
		
		if(count($jobseeker_settings)){
			foreach($jobseeker_settings as $settings){
				$userId       = $settings['JobseekerSettings']['user_id'];
				$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-1 week")),
						          	  'created <'=> date("Y-m-d h:i:s"));
			
				$jobData = $this->getAllJobseekerJobs($settings,$setting_cond);		
			
				if(count($jobData)>0){	
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";					
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}
			}
		}else{
			echo "\n\t\t\t\t No Jobseeker found to send Notification Email \n";
		}		
		echo "\n\t ******* Every week email notifications for jobseekers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";
	}

	function NetworkerEvery10Post(){
		echo "\n\t ******* Every 10 Post email notifications for networkers start at :".date("Y-m-D H:i:s")." ***********\n";

		$send_job = 10;
		$subscription_cond = 10;
		$networker_settings = $this->getNetworkSettings($subscription_cond);
		
		if(count($networker_settings)>0){	
			$setting_cond = "";
			$NwSettingCon = $this->getNetworkerCondition($networker_settings,$setting_cond);
			foreach($NwSettingCon as $userId=>$cond){
				
				$last_job_posted = $this->JobPost->find('first',array('conditions'=>array('user_id'=> $userId,),
																      'order' => array("id" => 'desc',),));
				
				if($last_job_posted){
					$last_job_id = $last_job_posted['JobPost']['job_id'];			

					$cond = array('Job.id >'=> $last_job_id,);
				}
				
				$jobData  = $this->getAllNetworkerJobs($cond,$send_job);		
				$total_job     = count($jobData);	
				//echo "<pre>"; print_r($jobData);	
				if($total_job==$send_job){								
					$last_job_id = $jobData[$send_job-1]['Job']['id'];
			
					$jobPost['JobPost']['user_id'] = $userId;
			    	$jobPost['JobPost']['job_id']  = $last_job_id;
					if($last_job_posted['JobPost']['id']){
						$jobPost['JobPost']['id'] = $last_job_posted['JobPost']['id'];
					}
					
					$this->JobPost->save($jobPost);	
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";			
					$this->sendJobPostEmail($userId,$jobData);		
			 	}else{
					echo "\n\t\t\t\t No jobs to post for Jobseeker ".$userId."\n";
				}								
			}						
		}else{
			echo "\n\t\t\t\t No networker found to send notification email \n";
		}
		echo "\n\t ******* Every 10 Post email notifications for networkers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";
	}

	function NetworkerEveryday(){

		echo "\n\t ******* Everyday email notifications for networkers start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond  = 1;		
		$networker_settings = $this->getNetworkSettings($subscription_cond);

		if(count($networker_settings)>0){
			$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-1 day")),
						          'created <'=> date("Y-m-d h:i:s"));

			$NwSettingCon = $this->getNetworkerCondition($networker_settings,$setting_cond);
			foreach($NwSettingCon as $userId=>$cond){

				$jobData  = $this->getAllNetworkerJobs($cond);			
			
				if($jobData){	
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";				
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}				
			}						
		}else{
			echo "\n\t\t\t\t No networker found to send notification email \n";
		}
		echo "\n\t******* Everyday email notifications for networkers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";
	}

	function NetworkerEvery3day(){

		echo "\n\t ******* Everyday email notifications for networkers start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond  = 3;			
		$networker_settings = $this->getNetworkSettings($subscription_cond);

		if(count($networker_settings)>0){
			$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-3 day")),
						          'created <'=> date("Y-m-d h:i:s"));

			$NwSettingCon = $this->getNetworkerCondition($networker_settings,$setting_cond);
			foreach($NwSettingCon as $userId=>$cond){

				$jobData  = $this->getAllNetworkerJobs($cond);			
			
				if($jobData){
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";					
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}				
			}						
		}else{
			echo "\n\t\t\t\t No networker found to send notification email \n";
		}
		echo "\n\t ******* Every week email notifications for networkers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";
	}

	function NetworkerEveryWeek(){

		echo "\n\t ******* Every week email notifications for networkers start at :".date("Y-m-D H:i:s")." ***********\n";

		$subscription_cond  = 7;		
		$networker_settings = $this->getNetworkSettings($subscription_cond);

		if(count($networker_settings)>0){
			$setting_cond = array('created >'=> date("Y-m-d h:i:s", strtotime("-1 week")),
						          'created <'=> date("Y-m-d h:i:s"));

			$NwSettingCon = $this->getNetworkerCondition($networker_settings,$setting_cond);
			foreach($NwSettingCon as $userId=>$cond){

				$jobData  = $this->getAllNetworkerJobs($cond);			
			
				if($jobData){
					echo "\n\t\t\t\t Sending job notification email to ".$userId."\n";					
					$this->sendJobPostEmail($userId,$jobData);
				}else{
					echo "\n\t\t\t\t No jobs to post for ".$userId."\n";
				}				
			}						
		}else{
			echo "\n\t\t\t\t No networker found to send notification email \n";
		}
		echo "\n\t ******* Every week email notifications for networkers end at :".date("Y-m-D H:i:s")." ***********\n\n\n";
	}

	private function getNetworkSettings($subscription_cond){
		$networker_settings = $this->NetworkerSettings->find('all',array('conditions'=>array('networkers.notification'=>1,'networkers.subscribe_email' => $subscription_cond),
																		 'joins'=>array(array('table' => 'networkers',
										             										   'alias' => 'networkers',
										                                                       'type' => 'LEFT',
										                                                       'conditions' => array('networkers.user_id = NetworkerSettings.user_id',)),
									                                                          
									                                                    ),
																			'fields'=>array('NetworkerSettings.user_id,NetworkerSettings.industry,NetworkerSettings.specification,NetworkerSettings.city,NetworkerSettings.state'),
															            )
															);
		return($networker_settings);
	}

	private function getNetworkerCondition($networker_settings,$setting_cond){
		
		$userId = 0;
		$job_cond = array();
		$mycon = array();
		// echo "<pre>total".count($networker_settings);
		foreach($networker_settings as $networker_setting){
			if($userId != $networker_setting['NetworkerSettings']['user_id'] && ($userId != 0 ) ){
				$mycon[$userId] = array('OR' => $job_cond,
				   						'AND' => array(array('is_active' => 1))); 
		
				$job_cond = array();
				$userId = $networker_setting['NetworkerSettings']['user_id'];
				$isSend = true;
			}
			if($userId == 0)
				$userId 	= $networker_setting['NetworkerSettings']['user_id'];

			$industry		= $networker_setting['NetworkerSettings']['industry'];
			$specification  = $networker_setting['NetworkerSettings']['specification'];
			$city			= $networker_setting['NetworkerSettings']['city'];
			$state 			= $networker_setting['NetworkerSettings']['state'];

			$tempCond = array();
			if($industry>1){
				$tempCond[] = array('Job.industry' => $industry);	
			}
			if($specification)
				$tempCond[] = array('Job.specification' => $specification);
			if($city)
				$tempCond[] = array('Job.city ' => $city);
			if($state)
				$tempCond[] = array('Job.state' => $state);
	  
			if(!$tempCond){
				$tempCond = array(1);
			}
			$job_cond[] =  array('AND' =>$tempCond);
		}

		$mycon[$userId] = array('OR' => $job_cond,
				   				'AND' => array(array('is_active' => 1),
											   $setting_cond,
											  ) 
								);
		return($mycon);
	}

	private function getAllNetworkerJobs($cond,$limit=0){
		$jobData  = $this->Job->find('all',array('conditions'=>$cond,
												 'limit'     =>$limit,
											 'joins'=>array(array('table' => 'industry',
										             		      'alias' => 'ind',
										             			  'type' => 'LEFT',
										             			  'conditions' => array('Job.industry = ind.id',)),
											   			    array('table' => 'specification',
										             			  'alias' => 'spec',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.specification = spec.id',)),
															array('table' => 'cities',
										             			  'alias' => 'city',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.city = city.id',)),
											                array('table' => 'states',
										                          'alias' => 'state',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.state = state.id',))
                                                           ),
															
											 'fields'=>array('Job.id ,Job.user_id,Job.title,Job.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, Job.is_active, ind.name as industry_name, spec.name as specification_name')
											)
							  );

		return($jobData);
	}

	private function getJobseekerSettings($subscription_cond){

		$jobseeker_settings = $this->JobseekerSettings->find('all',array('conditions'=>array('notification'=>1,
																		'subscribe_email' => $subscription_cond)));		
		return($jobseeker_settings);
	}

	private function getAllJobseekerJobs($settings,$setting_cond,$limit=0){
		
			
			$industry1 		= $settings['JobseekerSettings']['industry_1'];
			$industry2 		= $settings['JobseekerSettings']['industry_2'];
        	$industry = array();
			if($industry1 != 1)
				$industry[] = $industry1;
			if($industry2 != 1)
				$industry[] = $industry2;
			$specification1 = explode(",",$settings['JobseekerSettings']['specification_1']);
	    	$specification2 = explode(",",$settings['JobseekerSettings']['specification_2']);
			$specification  = array_merge($specification1, $specification2);
	   	 	$city 			= $settings['JobseekerSettings']['city'];
			$state 			= $settings['JobseekerSettings']['state'];
			$salary_range   = $settings['JobseekerSettings']['salary_range'];

			$cond = array('Job.specification' => $specification,
                          'Job.salary_from <=' => $salary_range,
					      'Job.salary_to >=' => $salary_range,
					      'Job.is_active'  => 1,
						  $setting_cond,
						);
			
			if(count($industry)>0)
				$cond['Job.industry'] = $industry;
			if($city)
				$cond['Job.city']  = $city;                      
        	if($state)
            	$cond['Job.state'] = $state;
			
			$jobData  = $this->Job->find('all',array('conditions'=>$cond,
												 'limit'     =>$limit,
											 'joins'=>array(array('table' => 'industry',
										             		      'alias' => 'ind',
										             			  'type' => 'LEFT',
										             			  'conditions' => array('Job.industry = ind.id',)),
											   			    array('table' => 'specification',
										             			  'alias' => 'spec',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.specification = spec.id',)),
															array('table' => 'cities',
										             			  'alias' => 'city',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.city = city.id',)),
											                array('table' => 'states',
										                          'alias' => 'state',
										                          'type' => 'LEFT',
										                          'conditions' => array('Job.state = state.id',))
                                                           ),
															
											 'fields'=>array('Job.id ,Job.user_id,Job.title,Job.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, Job.is_active, ind.name as industry_name, spec.name as specification_name')
											)
							  );

		return($jobData);
	}
	

	private function sendJobPostEmail($id,$job){
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$job_cnt = count($job);
		
		try{
			$this->Email->to = $user['User']['account_email'];
			$this->Email->subject = 'Hire Routes : '.$job_cnt.' Job(s) Matching Your Profile';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'job_post';
			$this->Email->sendAs = 'html';
			$this->set('user', $user['User']);
			$this->set('job', $job);
		    $this->Email->send();	
			echo "\n\t\t\t\t email sent to ".$id." ----------> ".$user['User']['account_email']."\n";		
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();	
		}		
	}	

}
?>
