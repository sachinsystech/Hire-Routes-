<?php

class CompaniesController extends AppController {

	var $name = 'Companies';
   	var $uses = array('User','Company','Companies','Job','Industry','State','Specification','UserRoles','PaymentInfo',
'JobseekerApply','JobViews');
	var $components = array('TrackUser','Utility');
	var $helpers = array('Form','Paginator','Time');
	
	/*	display a form to post new Job by company		*/
	function postJob(){

		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			
			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
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

	function newJob(){
		
		$displayPageNo = isset($this->params['named']['display'])?$this->params['named']['display']:10;
	    $this->set('displayPageNo',$displayPageNo);

		if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
			    				$shortByItem = 'created'; 
			    				break;	
	        		case 'industry':
	        				$shortByItem = 'industry'; 
	        				break;
			    				break;
			    	case 'salary':
			    				$shortByItem = 'salary_from'; 
			    				break;
			    	default:
			    			$this->redirect("/companies/newJob");	        		        	
			    }
		}else{
			$this->set('shortBy',"date-added");
			$shortByItem = 'created'; 
		}

		$userId = $this->TrackUser->getCurrentUserId();	
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}

		$conditions = array('Job.user_id'=>$userId,"Job.is_active"=>1);
		$this->paginate = array(
				            'conditions' => $conditions,
				"limit"=>$displayPageNo,
				'joins'=>array(
									array('table' => 'jobseeker_apply',
										'alias' => 'ja',
										'type' => 'LEFT',
										'conditions' => array(
													'Job.id = ja.job_id',
										)
									)
							),
				    'order' => array($shortByItem => 'desc'),
				    'recursive'=>0,
				    'fields'=>array('Job.id ,Job.user_id,Job.title,Job.created,COUNT(ja.id) as submissions'),
				    'group'=>array('Job.id'),
				    );
		$jobs = $this->paginate("Job");
		$this->set('jobs',$jobs);
		$arch_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>0);
		$archJobCount = $this->Job->find('count',array('conditions'=>$arch_conditions));
		$this->set('archJobCount',$archJobCount);
	}

/*

list archive jobs..
*/

	function showArchiveJobs(){
		
		$displayPageNo = isset($this->params['named']['display'])?$this->params['named']['display']:10;
	    $this->set('displayPageNo',$displayPageNo);

		if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
			    				$shortByItem = 'created'; 
			    				break;	
	        		case 'industry':
	        				$shortByItem = 'industry'; 
	        				break;
			    				break;
			    	case 'salary':
			    				$shortByItem = 'salary_from'; 
			    				break;
			    	default:
			    			$this->redirect("/companies/newJob");	        		        	
			    }
		}else{
			$this->set('shortBy',"date-added");
			$shortByItem = 'created'; 
		}

		$userId = $this->TrackUser->getCurrentUserId();	
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}

		$conditions = array('Job.user_id'=>$userId,"Job.is_active"=>0);
		$this->paginate = array(
				            'conditions' => $conditions,
				"limit"=>$displayPageNo,
				'joins'=>array(
									array('table' => 'jobseeker_apply',
										'alias' => 'ja',
										'type' => 'LEFT',
										'conditions' => array(
													'Job.id = ja.job_id',
										)
									)
							),
				    'order' => array($shortByItem => 'desc'),
				    'recursive'=>0,
				    'fields'=>array('Job.id ,Job.user_id,Job.title,Job.created,COUNT(ja.id) as submissions'),
				    'group'=>array('Job.id'),
				    );
		$jobs = $this->paginate("Job");
		$this->set('jobs',$jobs);
		$active_job_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>1);
		$activejobCount = $this->Job->find('count',array('conditions'=>$active_job_conditions));
		$this->set('activejobCount',$activejobCount);
	}


	function save(){
        $userId = $this->TrackUser->getCurrentUserId();
		$company = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
		$this->data['Job']['user_id']= $userId;
		$this->data['Job']['company_id']= $company['Companies']['id'];
		$this->data['Job']['company_name']= $company['Companies']['company_name'];

		$this->Job->set();

		
		if($this->Job->save($this->data['Job'],array('validate'=>'only'))){
            switch($this->params['form']['save']){
                case 'Post and Share Job with Network':
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');
                    $this->redirect('/companies/shareJob/'.$this->Job->id);
                    break;
                case 'Save for Later':
                default:
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');	
                    $this->redirect('/companies/editJob/'.$this->Job->id);
                    break;
        
            }
        }else{
            //$this->Session->setFlash('Internal error while save job.', 'error');	
            $this->redirect('/companies/postJob/');
        }		
	}
	
	function editJob(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
	
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId)));
			if($jobs['Job']){
				$this->set('job',$jobs['Job']);	
			
				$industries = $this->Industry->find('all');
				$industries_array = array();
				foreach($industries as $industry){
					$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
				}
				$this->set('industries',$industries_array);
			
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
				/****************  genrate code for traking user ****************/
					$str = "11:12";
					$temp = base64_encode($str);
					//echo $temp;
					$str = base64_decode("MTE6MTI6Njk=");
					//echo $str;exit;
					$code="";
					if($str != ""){
						$ids = split(":",$str);
						if($ids!=false && count($ids)>0){
							$ids[] = $userId;
							$str = implode(":",$ids);
							$code = base64_encode($str);
						}
					}else{
						$code = base64_encode($userId);				
					}
					$this->set('code',$code);
				/************************** end *********************************/
		
			}	
			else{
				$this->Session->setFlash('You may be clicked on old link.', 'error');				
				$this->redirect('/companies/newJob');
			}
		}
		if(isset($this->data['Job'])){
			$this->data['Job']['user_id'] = $userId;
			$this->Job->save($this->data['Job']);
			$this->Session->setFlash('Job has been updated successfuly.', 'success');				
			$this->redirect('/companies/newJob');
		}
		if(!isset($userId) || !isset($jobId)){
			$this->Session->setFlash('You may be clicked on old link.', 'error');				
			$this->redirect('/companies/newJob');
		}
	}
	
	function accountProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function editProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			$this->Companies->save($this->data['Company']);		
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/companies');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function checkout() {
		$userId = $this->TrackUser->getCurrentUserId();	
		
		$appliedJob = $this->Session->read('appliedJob');
		if(isset($appliedJob) && isset($userId) && $appliedJob['Job']['user_id'] == $userId){
			$this->set('job',$appliedJob['Job']);		
		}
		else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it. ', 'error');	
			$this->redirect("/");
		}
	}

	function paymentInfo() {
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$payment = $this->PaymentInfo->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('payment',$payment['PaymentInfo']);
		$submit_txt = "Save...";
		$appliedJob = $this->Session->read('appliedJob');
		if(isset($appliedJob)){
			$submit_txt = "Proceed to checkout...";
		}
		$this->set('submit_txt',$submit_txt);
		if(isset($this->data['PaymentInfo'])){
            
			if( !$this->PaymentInfo->save($this->data['PaymentInfo'],array('validate'=>'only')) ){	
				$this->render("payment_info");
				return;				
			}else{
				$this->Session->setFlash('Payment Infomation has been updated successfuly.', 'success');	
				if(isset($appliedJob)){
					$this->redirect('/companies/checkout');
				}
				$this->redirect('/companies/paymentInfo');
			}		
		}		
	}

	function paymentHistory() {
		$userId = $this->TrackUser->getCurrentUserId();	
	}

	/** move active job to archive(Disable) **/
	function archiveJob(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),"fileds"=>"id"));
			if($jobs['Job']){
				$jobs['Job']["is_active"] = 0 ;
				$this->Job->save($jobs);
				$this->Session->setFlash('Successfully, Job has been archived.', 'success');	
				$this->redirect("/companies/newJob");
			}
		}
		$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it. ', 'error');	
		$this->redirect("/companies/newJob");
	}	

	/** list of Applicant for given job **/
	function showApplicant(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),"fileds"=>"id"));
			//echo "<pre>"; print_r($jobs); exit;
			if($jobs['Job']){
				$conditions = array('JobseekerApply.job_id'=>$jobs['Job']['id'],"JobseekerApply.is_active"=>0);
				$this->paginate = array(
						    'conditions' => $conditions,
							'joins'=>array(
											array('table' => 'jobseekers',
												'alias' => 'jobseekers',
												'type' => 'LEFT',
												'conditions' => array(
															'JobseekerApply.user_id = jobseekers.user_id ',
												)
											)
									),'limit' => 10, // put display fillter here
							'order' => array('JobseekerApply.id' => 'desc'), // put sort fillter here
							'recursive'=>0,
							'fields'=>array('JobseekerApply.*,jobseekers.contact_name'),
							
							);
				$applicants = $this->paginate("JobseekerApply");
				$this->set('applicants',$applicants);
			}
			else{
				$this->Session->setFlash('May be clicked on old link or not authorize to do it.', 'error');	
				$this->redirect("/companies/newJob");
			}
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
		}
		$this->set('jobId',$jobId);
				//echo "<pre>"; print_r($applicants);  exit;
	}
	
	/** accept applicant for given applied job **/
	function acceptApplicant(){
		$userId = $this->TrackUser->getCurrentUserId();
		$appliedJobId = $this->params['id'];
		if($userId && $appliedJobId){
			$appliedJob = $this->Job->find('first', array(
														'joins' => array(
																		array(
																			'table' => 'jobseeker_apply',
																			'alias' => 'JobseekerapplyJob',
																			'type' => 'INNER',
																			'conditions' => array(
																				"JobseekerapplyJob.job_id = Job.id",
																			)
																		)
														),
														'conditions' => array(
															"Job.user_id = $userId",
															"JobseekerapplyJob.id = $appliedJobId",
															"JobseekerapplyJob.is_active = 0"
														),
														'fields' => array('Job.*','JobseekerapplyJob.*'),
														'order' => 'JobseekerapplyJob.created DESC'
										));
										
			if(isset($appliedJob['Job']) && isset($appliedJob['JobseekerapplyJob'])){
				$this->Session->write('appliedJob', $appliedJob);
				//echo "<pre>";print_r($this->Session->read('appliedJob')); exit;
				$this->redirect("/companies/paymentInfo/");
			}
			else{
				$this->Session->write('appliedJob', null);
				$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
				$this->redirect("/companies");
				return;
			}
			
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies");
			return;
		}
				//echo "<pre>"; print_r($applicants);  exit;
	}

	/** Job Statistics **/
	function jobStats(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
			
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId),"fileds"=>"id"));
			// 	echo "<pre>"; print_r($jobs); exit;
			if($jobs['Job']){
				$applicationalltime = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId)));

		
				$jobprofilelastmonth = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,
													'created >'=> date("Y-m-d", strtotime("-1 month")),
													'created <'=> date("Y-m-d"))));
		
				$jobprofilelastweek = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,
													'created >'=> date("Y-m-d", strtotime("-1 week")),
													'created <'=> date("Y-m-d"))));

				
				$viewalltime = $this->JobViews->find('count',array('conditions'=>array('job_id'=>$jobId)));
	
				$viewlastmonth = $this->JobViews->find('count',array('conditions'=>array('job_id'=>$jobId,
													'created >'=> date("Y-m-d", strtotime("-1 month")),
													'created <'=> date("Y-m-d"))));

				$viewlastweek = $this->JobViews->find('count',array('conditions'=>array('job_id'=>$jobId,
													'created >'=> date("Y-m-d", strtotime("-1 week")),
													'created <'=> date("Y-m-d"))));
		
				$this->set('jobId',$jobId);
				$this->set('application_alltime',$applicationalltime);
				$this->set('application_last_month',$jobprofilelastmonth);
				$this->set('application_last_week',$jobprofilelastweek);
				$this->set('view_alltime',$viewalltime);
				$this->set('view_last_month',$viewlastmonth);
				$this->set('view_last_week',$viewlastweek);
			}else{
				$this->Session->setFlash('success.', 'success');	
				$this->redirect("/companies/newJob");
			}
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
		}
	}
	
	/****** Delete Job *******/
	function deleteJob(){
		$this->autoRender=false;
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId=$this->params['form']['jobId'];
		$action=$this->params['form']['action'];
		if($action=='newJobs'){
			$activate=1;
		}else 
			$activate=0;

		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>$activate),"fileds"=>"id"));
			if($jobs['Job']){
				$jobs['Job']["is_active"] = 2 ;
				$this->Job->save($jobs);
				$this->Session->setFlash('Successfully, Job has been deleted.', 'success');	
				return;
			}
		}
		$this->Session->setFlash('May be you click on old link.','error');	
		return;
	}

    /***** shareJob *********/
    function shareJob(){
        
    }
    
    function paypalProPayment() {
        $userId = $this->TrackUser->getCurrentUserId();
        
        $appliedJob = $this->Session->read('appliedJob');
		if(!isset($appliedJob)){
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies");
			return;
		}
        
        $cardInfo = $this->PaymentInfo->find('first',array('conditions'=>array('PaymentInfo.user_id'=>$userId)));
        $companyInfo = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
        
        require_once(APP.'vendors'.DS."paypalpro/paypal_pro.inc.php");
        
        $firstName =urlencode($companyInfo['Companies']['contact_name']);
        $lastName =urlencode($companyInfo['Companies']['company_name']);
        
        $creditCardType =urlencode($cardInfo['PaymentInfo']['card_type']);
        $creditCardNumber = urlencode($cardInfo['PaymentInfo']['card_no']);
        $expDateMonth =urlencode($cardInfo['PaymentInfo']['expiration_month']);
        $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
        $expDateYear =urlencode($cardInfo['PaymentInfo']['expiration_year']);
        $cvv2Number = urlencode($cardInfo['PaymentInfo']['ccv_code']);
        
        $address = urlencode($cardInfo['PaymentInfo']['address']);
        $city = urlencode($cardInfo['PaymentInfo']['city']);
        $state =urlencode($cardInfo['PaymentInfo']['state']);
        $zip = urlencode($cardInfo['PaymentInfo']['zip']);
        $amount = urlencode($appliedJob['Job']['reward']);
        $currencyCode="USD";
        $paymentAction = urlencode("Sale");
	
        $nvpRecurring = '';
		$methodToCall = 'doDirectPayment';
        
        $nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.$padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;

        $paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE, '', '', FALSE, FALSE );
        $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
        $ack = strtoupper($resArray["ACK"]);
        
        if($ack == "SUCCESS") {
            if(isset($resArray['TRANSACTIONID'])) {
            	echo "SUCCESS : ".$resArray['TRANSACTIONID']; exit;
            	$this->Session->delete('appliedJob');
                // write code to change status of applied job from applied to selected in jobseeker_apply table....
            	/*	*/
                $this->redirect("/companies/newJob/".$resArray['TRANSACTIONID']);
            }else {
                $this->Session->setFlash("Due To Unknown Paypal Response, We Cannot Procced.", 'error');
                $this->redirect("/companies/checkout");
            }
            
        } else {
            $error_msg = "Invalid Data";
            echo "<pre>"; print_r($resArray); exit;
            if(isset($resArray['L_LONGMESSAGE0'])) {
                $error_msg = $resArray['L_LONGMESSAGE0'];
            }elseif(isset($resArray['L_SHORTMESSAGE0'])) {
                $error_msg = $resArray['L_SHORTMESSAGE0'];
            }
            $this->Session->setFlash($error_msg, 'error');
            $this->redirect("/companies/checkout");
        }
  		      
    }

	public function employees(){
		$userId= $this->TrackUser->getCurrentUserId();
		$data=$this->User->find("all",array('joins'=>array(
														'table'=>'payment_history',
														'type'=>'INNER',
														'conditions'=>array(
																		'payment_history.jobseeker_user_id=users.id'	
																			)
															),
											'conditions'=>array("payment_history.user_id=$userId"),
											'fields' =>'User.id',
											)
								);

	pr($data);exit;
/*
	$appliedJob = $this->Job->find('first', array(
														'joins' => array(
																		array(
																			'table' => 'jobseeker_apply',
																			'alias' => 'JobseekerapplyJob',
																			'type' => 'INNER',
																			'conditions' => array(
																				"JobseekerapplyJob.job_id = Job.id",
																			)
																		)
														),
														'conditions' => array(
															"Job.user_id = $userId",
															"JobseekerapplyJob.id = $appliedJobId",
															"JobseekerapplyJob.is_active = 0"
														),
														'fields' => array('Job.*','JobseekerapplyJob.*'),
														'order' => 'JobseekerapplyJob.created DESC'
										));
	*/

	}
}
?>
