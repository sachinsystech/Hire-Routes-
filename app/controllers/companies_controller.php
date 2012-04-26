<?php

class CompaniesController extends AppController {

	var $name = 'Companies';
   	var $uses = array('User', 'Company', 'Companies', 'Job', 'Industry', 'State', 'Specification', 'UserRoles', 'PaymentInfo', 'JobseekerApply', 'JobViews', 'PaymentHistory','PaypalResponse');
	var $components = array('TrackUser','Utility','RequestHandler');

	var $helpers = array('Form','Paginator','Time');
	
	/*	display a form to post new Job by company		*/
	function postJob(){
		$userId = $this->TrackUser->getCurrentUserId();
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			$this->set('states',$this->Utility->getState());
			$this->set('industries',$this->Utility->getIndustry());

			if(isset($this->data['Job'])){
				if(!(strtoupper(trim($this->params['form']['save']))=='POST AND SHARE')){
					$this->data['Job']['is_active']=3;	//For 3=>unpublished, 1=>active job posts
				}
				$company = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
				$this->data['Job']['user_id']= $userId;
				$this->data['Job']['company_id']= $company['Companies']['id'];
				$this->data['Job']['company_name']= $company['Companies']['company_name'];
				$this->Job->set($this->data['Job']);
				if($this->Job->validates()){
					if($this->Job->save()){
    		    	    switch($this->params['form']['save']){
    		    	        case 'Post and Share':
    		    	            $this->Session->setFlash('Job has been saved successfuly.', 'success');
    		    	            $this->redirect('/companies/editJob/'.$this->Job->id);
    		    	            break;
    		    	        case 'Save for Later':
    		    	        default:
    		    	            $this->Session->setFlash('Job has been saved successfuly.', 'success');	
								$this->redirect('/companies/editJob/'.$this->Job->id);
        		            break;
	    		        }
    			    }else{
    			        $this->Session->setFlash('Internal error while save job.', 'error');	
    			        $this->redirect('/companies/postJob/');
    			    }
				}
			}
		}
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
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		
		//	fetching jobs with given condition
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
													'ja.is_active' => 0
										),
													
									)
							),
				    'order' => array($shortByItem => 'desc'),
				    'recursive'=>0,
				    'fields'=>array('Job.id ,Job.user_id,Job.title,Job.created,COUNT(ja.id) as submissions'),
				    'group'=>array('Job.id'),
				    );
		$jobs = $this->paginate("Job");
		$this->set('jobs',$jobs);
		// end for job fetching...
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());

	}

/*

list archive jobs..
*/

	function showArchiveJobs(){
		
		$userId = $this->TrackUser->getCurrentUserId();	
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		
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
		// end for job fetching...
		
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}
	
	/* Company data starts*/

	function companyData(){
		$userId = $this->TrackUser->getCurrentUserId();

		$jobPosted = $this->Job->find('all',array('conditions'=>array('Job.user_id'=>$userId),
												 'fields'=>array('SUM(Job.reward) as jobs_reward, count(Job.id) as jobs_posted'), ));

		if($jobPosted){
			$rewardPosted = $jobPosted[0][0]['jobs_reward'];
			$jobPosted	  = $jobPosted[0][0]['jobs_posted'];
		}else{
			$rewardPosted = 0;
			$jobPosted	  = 0;
		}

		$jobApply = $this->JobseekerApply->find('all',array('conditions'=>array('jobs.user_id'=>$userId),
															  	'joins'    =>array(array('table' => 'jobs',
																	    				'alias' => 'jobs',
																						'type'  => 'LEFT',
																						'conditions' => 'jobs.id = JobseekerApply.job_id',											 						   )
																		         ),
																'fields'   => array('COUNT(DISTINCT JobseekerApply.job_id) as job_filled, count(JobseekerApply.job_id) as applicants'), ));

		$jobFilled  = $jobApply[0][0]['job_filled'];
		$applicants = $jobApply[0][0]['applicants'];
		
		
		$jobReward = $this->Job->find('all',array('conditions'=>array('Job.user_id'=>$userId),
													 'fields'=>array('SUM(Job.reward) as jobs_reward'),	));

		

		$paidReward = $this->PaymentHistory->find('all',array('conditions'=>array(
																'PaymentHistory.user_id'=>$userId,
//																'PaymentHistory.payment_status' =>1
																),
													 'fields'=>array('SUM(PaymentHistory.amount) as paid_reward'),));
		if($paidReward){
			$rewardPaid = $paidReward[0][0]['paid_reward'];
		}else{
			$rewardPaid = 0;
		}

		

		$jobViews = $this->JobViews->find('count',array('conditions'=>array('jobs.user_id'=>$userId),
													    'joins'     =>array(array('table' => 'jobs',
																	    		  'alias' => 'jobs',
																		          'type'  => 'LEFT',
																				  'conditions' => 'JobViews.job_id = jobs.id',	))));
		
		$this->set('JobPosted',$jobPosted);
		$this->set('JobFilled',$jobFilled);	
		$this->set('RewardsPosted',$rewardPosted);
		$this->set('RewardsPaid',$rewardPaid);
		$this->set('Applicants',$applicants);
		$this->set('Views',$jobViews);	

		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());		
	}
	/* Company data ends */
	
	private function getCompanyActiveJobsCount(){
		$userId = $this->TrackUser->getCurrentUserId();	
		$active_job_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>1);
		$activejobCount = $this->Job->find('count',array('conditions'=>$active_job_conditions));
		return $activejobCount;
	}

	private function getCompanyArchiveJobsCount(){
		$userId = $this->TrackUser->getCurrentUserId();	
		$arch_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>0);
		$archJobCount = $this->Job->find('count',array('conditions'=>$arch_conditions));
		return $archJobCount;
	}

	
/*****	Companies edit their own Job :: 	*********/
	function editJob(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
	
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId)));
			if($jobs['Job']){
				$this->set('job',$jobs['Job']);	
				$this->set('jobId',$jobId);
				$this->set('jobTitle',$jobs['Job']['title']);
				$code=$this->Utility->getCode($jobId,$userId);
                $this->set('code',$code);
                if(isset($code)&&!empty($code))
                	$jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$jobId.'/?code='.$code;
                else
	                $jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$jobId.'/';
                $this->set('jobUrl',$jobUrl);
				$this->set('states',$this->Utility->getState());
				$this->set('industries',$this->Utility->getIndustry());
				
				/****************  genrate code for traking user **************** /
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

				$NoOfApplicants = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,'is_active'=>0)));
				$this->set('NoOfApplicants',$NoOfApplicants);
		
			}	
			else{
				$this->Session->setFlash('You may be clicked on old link.', 'error');				
				$this->redirect('/companies/newJob');
			}
		}
		if(isset($this->data['Job'])){
			$this->data['Job']['user_id'] = $userId;
			$this->Job->set($this->data['Job']);
			if($this->Job->validates()){
				$this->Job->save();
				$this->Session->setFlash('Job has been updated successfuly.', 'success');
				$this->redirect('/companies/newJob');
			}else{
				$this->Session->setFlash('Job data Invalid.', 'error');
			}
		}
		if(!isset($userId) || !isset($jobId)){
			$this->Session->setFlash('You may be clicked on old link.', 'error');				
			$this->redirect('/companies/newJob');
		}
	}
	
	function accountProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			$this->set('user',$user['User']);
			$this->set('company',$user['Companies'][0]);
	}

	function editProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			if(!empty($this->data['Companies']['company_name'])){
				$this->User->save($this->data['User']);
				if($this->Companies->save($this->data['Companies'])){
					$this->Session->write('welcomeUserName',$this->data['Companies']['contact_name']);
					$this->Session->setFlash('Profile has been updated successfuly.', 'success');
					$this->redirect('/companies');
				}
			}else{
			$this->set('company_error','Company required');			
			}
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function paymentInfo() {
		$userId = $this->TrackUser->getCurrentUserId();		
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$payment = $this->PaymentInfo->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('payment',$payment['PaymentInfo']);
		$appliedJobId = isset($this->params['id'])?$this->params['id']:null;
		if(isset($appliedJobId)){
			$appliedJob = $this->appliedJob($appliedJobId);
		    if(!isset($appliedJob) || !isset($appliedJob['JobseekerapplyJob'])){
				$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
				$this->redirect("/companies/paymentInfo");
				return;
			}
		}
		$this->set('appliedJobId',$appliedJobId);
		
		$submit_txt = "Save...";
		if(isset($this->params['id'])){
			$submit_txt = "Proceed to checkout..>>";
		}
		$this->set('submit_txt',$submit_txt);
		if(isset($this->data['PaymentInfo'])){
			
		
			require_once(APP.'vendors'.DS."paypalpro/paypal_pro.inc.php");
				
		    $firstName =urlencode($this->data['PaymentInfo']['cardholder_name']);
		    $lastName =urlencode($this->data['PaymentInfo']['cardholder_name']);
		    
		    $creditCardType =urlencode($this->data['PaymentInfo']['card_type']);
		    $creditCardNumber = urlencode($this->data['PaymentInfo']['card_no']);
		    $expDateMonth =urlencode($this->data['PaymentInfo']['expiration_month']);
		    $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		    $expDateYear =urlencode($this->data['PaymentInfo']['expiration_year']);
		    $cvv2Number = urlencode($this->data['PaymentInfo']['ccv_code']);
		    
		    $address = urlencode($this->data['PaymentInfo']['address']);
		    $city = urlencode($this->data['PaymentInfo']['city']);
		    $state =urlencode($this->data['PaymentInfo']['state']);
		    $zip = urlencode($this->data['PaymentInfo']['zip']);
		    $amount = urlencode('1');
		    $currencyCode="USD";
		    $paymentAction = urlencode("Authorization");
	
		    $nvpRecurring = '';
			$methodToCall = 'doDirectPayment';
		    
		    $nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.$padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;

			$paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE, '', '', FALSE, FALSE );
		    $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		    $ack = strtoupper($resArray["ACK"]);
            if($ack =="SUCCESS"){            
            	//To store Paypal response
            	$resArray['transaction_type']='card_authorization';
            	$this->PaypalResponse->save(array('paypal_string'=>serialize($resArray)));
                // card is valid
			    $authorizationID = urlencode($resArray['TRANSACTIONID']);
			    $note = urlencode('valid credit card');

			    // Add request-specific fields to the request string.
			    $nvpstr.="&AUTHORIZATIONID=$authorizationID&NOTE=$note";		
		        // Execute the API operation; see the PPHttpPost function above.
		        $httpParsedResponseAr = $this->PPHttpPost('DoVoid', $nvpstr);
		        $msg="";
		        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
		        	$msg="Payment information Authorized";
		        	if(isset($resArray['L_SHORTMESSAGE0'])){
		                $msg = $resArray['L_SHORTMESSAGE0'];
	           		}
				}else{
			       	$this->render("payment_info");
			       	return;
				}
		        if(!$this->PaymentInfo->save($this->data['PaymentInfo'],array('validate'=>'only')) ){	
			        $this->render("payment_info");
			        return;				
		        }else{
			        if(isset($this->data['PaymentInfo']['applied_job_id'])&& $this->data['PaymentInfo']['applied_job_id']!=""){
				        $this->redirect('/companies/checkout/'.$this->data['PaymentInfo']['applied_job_id']);
				    }
				        $this->Session->setFlash('Payment Infomation has been updated successfuly.', 'success');	
				        $this->redirect('/companies/paymentInfo');
			        }		
            }else{
                // card is not valid
                $error_msg = "Invalid Data";
	            if(isset($resArray['L_LONGMESSAGE0'])) {
	                $error_msg = $resArray['L_LONGMESSAGE0'];
	            }elseif(isset($resArray['L_SHORTMESSAGE0'])) {
	                $error_msg = $resArray['L_SHORTMESSAGE0'];
	            }
	            $this->Session->setFlash($error_msg, 'error');
	            $this->redirect("/companies/paymentInfo/");
            }
		}		
	}

	function paymentHistory() {
		$userId = $this->TrackUser->getCurrentUserId();	
		$tid = isset($this->params['tid'])?$this->params['tid']:"";
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		if($userId){

			$conditions = array('PaymentHistory.user_id'=>$userId);
			$this->paginate = array(
					'conditions' => $conditions,
						'order' => array('paid_date' => 'desc'),
						);
			$PaymentHistory = $this->paginate("PaymentHistory");
			$this->set('PaymentHistory',$PaymentHistory);	
		}
	}
	
function paymentHistoryInfo(){
		
		$userId = $this->TrackUser->getCurrentUserId();
		$id = isset($this->params['id'])?$this->params['id']:"";
		$tid = isset($this->params['tid'])?$this->params['tid']:"";
		if($this->userRole!=COMPANY){
			$this->redirect("/users/firstTime");
		}
		
		if($userId && isset($tid) &&isset($id)){
				$PaymentDetail = $this->PaymentHistory->find('first',
																array('conditions'=>array(
																							'PaymentHistory.id'=>$id, 
																							'PaymentHistory.user_id'=>$userId, 
																							'PaymentHistory.transaction_id'=>$tid
																						),
												  						'joins'=>array(
												  									array('table' => 'jobseeker_apply',
																			           'alias' => 'jsapply',
																	 				   'type' => 'INNER',
																	 				   'conditions' => array('PaymentHistory.applied_job_id = jsapply.id',)),
															   			         
																				 	array('table' => 'jobs',
																			           'alias' => 'job',
																			           'type' => 'INNER',
																			           'conditions' => array('PaymentHistory.job_id = job.id',)),
																			        array('table' => 'jobseekers',
																			           'alias' => 'js',
																			           'type' => 'INNER',
																			           'conditions' => array(
																				           		'PaymentHistory.jobseeker_user_id = js.user_id',)),   
																			),
																 		'fields'=>array( 'PaymentHistory.amount, PaymentHistory.paid_date, PaymentHistory.transaction_id, job.id,job.title, job.short_description, jsapply.*, js.contact_name') 
																 	) 
																); 		
			if(!$PaymentDetail){
				$this->Session->setFlash('You may be clicked on old link or entered  manually.', 'error');				
				$this->redirect('/companies/paymentHistory');
			}														
			$this->set('PaymentDetail',$PaymentDetail);	
			$this->set('jobInfo',$this->getJob($PaymentDetail['job']['id']));	
		}
		else{
			$this->Session->setFlash('You may be clicked on old link or entered  manually.', 'error');				
			$this->redirect('/companies/paymentHistory');
		}
	}
	
	private function getJob($jobId){
		$jobInfo = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId),
			  'joins'=>array(array('table' => 'industry',
	                               'alias' => 'ind',
	             				   'type' => 'INNER',
	             				   'conditions' => array('Job.industry = ind.id',)),
		   			         array('table' => 'specification',
	             				   'alias' => 'spec',
	                               'type' => 'INNER',
	                               'conditions' => array('Job.specification = spec.id',)),
							 array('table' => 'cities',
	            				   'alias' => 'city',
	                               'type' => 'INNER',
	                               'conditions' => array('Job.city = city.id',)),
		                     array('table' => 'states',
	                               'alias' => 'state',
	                               'type' => 'INNER',
	                               'conditions' => array('Job.state = state.id',))
							),
			 'fields'=>array('Job.*, ind.name, city.city, state.state, spec.name' ), ));
		return $jobInfo;										 
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
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),"fields"=>"id"));
			//echo "<pre>"; print_r($jobs); exit;
			if($jobs['Job']){
				$conditions = array('JobseekerApply.job_id'=>$jobs['Job']['id'],"JobseekerApply.is_active"=>0);
	
				if(isset($this->data['User'])){

					$i=0;
					foreach($this->data['User'] as $answer=>$user){
						if($user!=""){
							$ans[$i] = array($answer=>$user);
							$i++;
						}
					}
					
					$conditions = array('OR' => $ans,
					                    'AND' => $conditions
					                  );
					
					$this->set('filterOpt',$this->data['User']);
				}

				$this->paginate = array(
						    'conditions' => $conditions,
							'joins'=>array(
											array('table' => 'jobseekers',
												  'alias' => 'jobseekers',
												  'type' => 'LEFT',
												  'fields'=>'jobseekers.contact_name',
												  'conditions' => array('JobseekerApply.user_id = jobseekers.user_id ')
											),
											array(
												'table'=>'jobs',
												'alias'=>'Job',
												'fields'=>'Job.user_id',
												'type'=>'left',
												'conditions'=>'JobseekerApply.job_id=Job.id'
											),
											array(
												'table'=>'users',
												'alias'=>'User',
												'type'=>'left',
												'fields'=>'parent_user_id',
												'conditions'=>array('SUBSTRING_INDEX(JobseekerApply.intermediate_users, ",", 1) = User.id')
											)
									      ),
							'limit' => 10, // put display fillter here
							'order' => array('JobseekerApply.id' => 'desc'), // put sort fillter here
							'recursive'=>0,
							'fields'=>array('JobseekerApply.*, 
											jobseekers.contact_name,
											User.parent_user_id,
											Job.user_id',
									),
							);
				
				$applicants = $this->paginate("JobseekerApply");
				$this->set('NoOfApplicants',count($applicants));
				$this->set('applicants',$applicants);
				$this->set('jobId',$jobId);
			}else{
				$this->Session->setFlash('May be clicked on old link or not authorize to do it.', 'error');	
				$this->redirect("/companies/newJob");
			}
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
		}
		$this->set('jobId',$jobId);
	}

	
	function viewResume(){
 		
		if(isset($this->params['id'])){		
			
			$id = $this->params['id'];
			$file_type = $this->params['ftype'];
			
		
			$jobprofile = $this->JobseekerApply->find('first',array('conditions'=>array('id'=>$id)));
			if($jobprofile['JobseekerApply']){

				if($file_type=='resume'){
					$file = $jobprofile['JobseekerApply']['resume'];
					$fl = APP."webroot/files/resume/".$file;
				}
				if($file_type=='cover_letter'){
					$file = $jobprofile['JobseekerApply']['cover_letter'];
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
				}				
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
				$this->redirect("/companies/newJob");				
			}
		}		
	}
	

	/** Job Statistics/Data Details... **/
	function jobStats(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
			
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId),"fileds"=>"id"));
			if($jobs['Job']){
				$applicationalltime = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,'is_active'=>0)));
				
				$jobprofilelastmonth = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,
													'is_active'=>0,
													'created >'=> date("Y-m-d", strtotime("-1 month")),
													'created <'=> date("Y-m-d"))));
		
				$jobprofilelastweek = $this->JobseekerApply->find('count',array('conditions'=>array('job_id'=>$jobId,
													'is_active'=>0,
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
				$this->set('NoOfApplicants',$applicationalltime);
			}else{
				$this->Session->setFlash('May be clicked on old link or not authorize to do it.', 'error');	
				$this->redirect("/companies/newJob");
			}
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
		}
	}


	/****** Reject Applicant for company Job *******/
	function rejectApplicant(){
		$userId = $this->TrackUser->getCurrentUserId();
		$id = $this->params['id'];
		$JobId = $this->params['jobId']; 
		if($userId && $id){
			
			if($this->JobseekerApply->updateAll(array('is_active'=>2), array('JobseekerApply.id'=>$id))){
				$this->Session->setFlash('Applicant has been rejected successfully.', 'success');
			}else{
				$this->Session->setFlash('Error occurred while rejecting applicant.Please try later!', 'error');
			}	
				$this->redirect("/companies/showApplicant/".$JobId);
			return;
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies");
			return;
		}
	}

 

	/** accept applicant for given applied job **/
	function checkout(){
		$userId = $this->TrackUser->getCurrentUserId();
		$appliedJobId = $this->params['id'];
		if($userId && $appliedJobId){
		
			$paymentInfo = $this->PaymentInfo->find('first',array('conditions'=>array('user_id'=>$userId)));
			
			if(isset($paymentInfo['PaymentInfo'])){
			
				$appliedJob = $this->appliedJob($appliedJobId);
										
				if(isset($appliedJob['Job']) && isset($appliedJob['JobseekerapplyJob'])){
					$this->set('job',$appliedJob['Job']);
					$this->set('appliedJobId',$appliedJobId);
					$this->render('checkout');	
					return;	
				}
				else{
					$this->Session->setFlash('May be you click on old link or you are not authorize to do it.', 'error');	
					$this->redirect("/companies/newJob");
					return;
				}
			}
			else{
				$this->Session->setFlash('First fill your Payment Informatoin.', 'error');
				$this->redirect("/companies/paymentInfo/$appliedJobId");
			}			
		}else{
			$this->Session->setFlash('May be you click on old link or you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
			return;
		}
	}

	/*	Do payment of reward amount for given applied-job...*/
    function paypalProPayment() {
        $userId = $this->TrackUser->getCurrentUserId();
        $appliedJobId = $this->params['id'];        
        								
        if($userId && $appliedJobId){
        
		    $cardInfo = $this->PaymentInfo->find('first',array('conditions'=>array('PaymentInfo.user_id'=>$userId)));
		    $companyInfo = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
		    
		    $appliedJob = $this->appliedJob($appliedJobId);
		    if(!isset($appliedJob) || !isset($appliedJob['JobseekerapplyJob'])){
				$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
				$this->redirect("/companies/newJob");
				return;
			}

		    if(!isset($cardInfo['PaymentInfo'])){
				$this->Session->setFlash('First fill your Payment Informatoin.', 'error');	
				$this->redirect("/companies/PaymentInfo/$appliedJob");
				return;
			}

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
		    $paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE,null,null);
		    $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		    $ack = strtoupper($resArray["ACK"]);
		    if($ack == "SUCCESS") {
		    
		    	//To store Paypal response
            	$resArray['transaction_type']='payment';
            	$this->PaypalResponse->save(array('paypal_string'=>serialize($resArray)));
		    	
		        if(isset($resArray['TRANSACTIONID'])) {
		        	// Here change status of applied job from applied to selected in jobseeker_apply table....
		        	 if($this->JobseekerApply->updateAll(array('is_active'=>1), array('JobseekerApply.id'=>$appliedJobId))){
						$paymentHistory = array();
						$paymentHistory['user_id'] = $userId;
						$paymentHistory['job_id'] = $appliedJob['Job']['id'];
						$paymentHistory['applied_job_id'] = $appliedJob['JobseekerapplyJob']['id'];
						$paymentHistory['jobseeker_user_id'] = $appliedJob['JobseekerapplyJob']['user_id'];
						$paymentHistory['amount'] = $appliedJob['Job']['reward'];
						$paymentHistory['transaction_id'] = $resArray['TRANSACTIONID'];
						
						if($this->PaymentHistory->save($paymentHistory)){
						
						}
						$this->sendCongratulationEmail($appliedJob);
						$this->Session->setFlash('Applicant has been selected successfully.', 'success');	
						$this->redirect("/companies/showApplicant/".$appliedJob['Job']['id']);
						return;
					}	        	
		            $this->redirect("/companies/newJob/".$resArray['TRANSACTIONID']);
		        }else {
		            $this->Session->setFlash("Due To Unknown Paypal Response, We Cannot Procced.", 'error');
		            $this->redirect("/companies/checkout");
		        }
		        
		    }else {
		        $error_msg = "Invalid Data";
				if(isset($resArray['L_SHORTMESSAGE0'])) {
		            $error_msg = $resArray['L_SHORTMESSAGE0'];
		        }
		        $this->Session->setFlash($error_msg, 'error');
		        $this->redirect("/companies/checkout/".$appliedJob['JobseekerapplyJob']['id']);
		    }
		}
		else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
			return;
		}  		      
    }

/*
	send congratulation email to selected applicant.
*/
    private function sendCongratulationEmail($appliedJob){
    	
    	$userId = $this->TrackUser->getCurrentUserId();
    	$companyUserInfo = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
    	$JobseekerUserInfo = $this->User->find('first',array('conditions'=>array('User.id'=>$appliedJob['JobseekerapplyJob']['user_id'])));
    	$jobDetails = $this->getJob($appliedJob['Job']['id']);    	
    	$interMeedUsers = count(explode(',',$appliedJob['JobseekerapplyJob']['intermediate_users']));
    	$appliedOn = date("m/d/Y",strtotime($appliedJob['JobseekerapplyJob']['created']));
    	$jobTyps = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary');
    	
    	$emailMsgInfo = array();
    	$emailMsgInfo['company']['name'] = $companyUserInfo['Companies']['0']['company_name'];
    	$emailMsgInfo['company']['url'] = $companyUserInfo['Companies']['0']['company_url'];
    	$emailMsgInfo['jobseker']['name'] = $JobseekerUserInfo['Jobseekers']['0']['contact_name'];
    	$emailMsgInfo['job']['title'] = $jobDetails['Job']['title'];
    	$emailMsgInfo['job']['reward'] = ($interMeedUsers===1)?"<b>Reward for you : </b>".(($jobDetails['Job']['reward']*75)/100)."<b>$</b>":"";
    	$emailMsgInfo['job']['description'] = $jobDetails['Job']['short_description'];
    	$emailMsgInfo['job']['industry'] = isset($jobDetails['ind']['name'])?$jobDetails['ind']['name']:"";
    	$emailMsgInfo['job']['specification'] = isset($jobDetails['spec']['name'])?$jobDetails['spec']['name']:"";
    	$emailMsgInfo['job']['city'] = isset($jobDetails['city']['city'])?$jobDetails['city']['city']:"";
    	$emailMsgInfo['job']['state'] = isset($jobDetails['state']['state'])?$jobDetails['state']['state']:"";
    	$emailMsgInfo['job']['salary_range'] = $jobDetails['Job']['salary_from']."<b>$</b> - ".$jobDetails['Job']['salary_to']."<b>$</b>";
    	$emailMsgInfo['job']['type'] = $jobTyps[$jobDetails['Job']['job_type']];
    	$emailMsgInfo['job']['applied_on'] = $appliedOn;
    	try{
			$this->Email->to = $JobseekerUserInfo['User']['account_email'];
			$this->Email->subject = 'Congratulations : Job Offer Acceptance...!!';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'select_applicant';
			$this->Email->sendAs = 'html';
			$this->set('emailMsgInfo', $emailMsgInfo);
			$this->Email->send();
		}catch(Exception $e){
			$this->redirect("/");
			return;
		}
    }

    private function appliedJob($appliedJobId){
   		$userId = $this->TrackUser->getCurrentUserId();
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
										'fields' => array('Job.*',
														 'JobseekerapplyJob.id,
														 JobseekerapplyJob.user_id,
														 JobseekerapplyJob.job_id,
														 JobseekerapplyJob.is_active,
														 JobseekerapplyJob.intermediate_users,
														 JobseekerapplyJob.created'
														 
														 ),
										'order' => 'JobseekerapplyJob.created DESC'
								));
		return $appliedJob;
    }

// =======================delete jobs=========
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


	public function employees(){
		$userId = $this->TrackUser->getCurrentUserId();	
		$conditions[]="PaymentHistory.user_id=$userId";
		$condition_phone=null;
		$condition_name=null;
		if(isset($this->params['named'])){
			$data=$this->params['named'];
			//echo "<pre>"; print_r($data);//exit;
		}
		if(isset($this->params['url']['from_date'])){
			$data=$this->params['url'];
			//echo "<pre>"; print_r($data);//exit;
		}
		if(isset($data)){
			if(isset($data['contact_name']) && !empty($data['contact_name'])){			
				$contact_name=trim($data['contact_name']);
				$conditions[]=array('OR'=>array("js.contact_name LIKE\"".$contact_name."%\"",	));
				$this->set('contact_name',$contact_name);	
			}
			if(isset($data['contact_phone']) && !empty($data['contact_phone'])){			
				$contact_phone=trim($data['contact_phone']);
				$conditions[]=array('OR'=>array("js.contact_phone LIKE\"".$contact_phone."%\"",));
				$this->set('contact_phone',$contact_phone);	
			}
			if(isset($data['account_email']) && !empty($data['account_email'])){			
				$conditions[]= "users.account_email LIKE \"".trim($data['account_email'])."%\"";
				$this->set('account_email',$data['account_email']);	
			}
			if(isset($data['state']) &&   !empty($data['state'])){			
				$conditions[]= "js.state LIKE\"%".$data['state']."%\"";
				$conditions[]= "js.city LIKE\"".$data['state']."%\"";
				$this->set('state',$data['state']);	
			}
			if(isset($data['from_date']) && !empty($data['from_date'])){
	 			$conditions[]="date(PaymentHistory.paid_date) >='".date("Y-m-d",strtotime($data['from_date']))."'";
	 			$this->set('from_date',$data['from_date']);
	 		}
		 	if(isset($data['to_date']) && !empty($data['to_date'])){
		 		$conditions[]="date(PaymentHistory.paid_date) <='".date("Y-m-d",strtotime($data['to_date']))."'";
		 		$this->set('to_date',$data['to_date']);
		 	}
		 }
		
		$this->paginate = array('conditions' =>isset($conditions)?$conditions:true,
								'limit'=>'10', 	
								'joins'=>array(
											array('table'=>'users',
												  'type'=>'LEFT',
												  'conditions'=>array('users.id=PaymentHistory.jobseeker_user_id',
																	  'users.is_active=1'),
												 ),
										 	array('table'=>'jobseekers',
												  'alias'=> 'js',
												  'type'=>'LEFT',
												  'conditions'=>array('js.user_id =PaymentHistory.jobseeker_user_id'),
												 ),
											   ),
								'fields'=>array('PaymentHistory.user_id,PaymentHistory.paid_date,js.contact_name,
												js.contact_phone,js.city,js.state,users.account_email'),
								'order'=>'PaymentHistory.paid_date desc'
								);
		$employees = $this->paginate("PaymentHistory");
		$this->set('employees',$employees);
		// end for job fetching...
    }

	private function PPHttpPost($methodName_, $nvpStr_) {
		$environment = 'sandbox';

		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode(API_USERNAME);
		$API_Password = urlencode(API_PASSWORD);
		$API_Signature = urlencode(API_SIGNATURE);
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
		if("sandbox" === $environment || "beta-sandbox" === $environment) {
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		$version = urlencode('51.0');

		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		// Get response from the server.
		$httpResponse = curl_exec($ch);
		if(!$httpResponse) {
			$this->Session->setFlash('Internal error!Please try again', 'error');
		}

		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);

		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}

		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			$this->Session->setFlash('Internal Error! Try again', 'error');
		}

		return $httpParsedResponseAr;
	}

}
?>

