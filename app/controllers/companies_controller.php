<?php
require_once(APP_DIR.'/vendors/facebook/facebook.php');
require_once(APP_DIR.'/vendors/linkedin/linkedin.php');
require_once(APP_DIR.'/vendors/linkedin/OAuth.php');

class CompaniesController extends AppController {

	var $name = 'Companies';
   	var $uses = array('User', 'Company', 'Companies', 'Job', 'Industry', 'State', 'Specification', 'UserRoles', 'PaymentInfo', 'JobseekerApply', 'JobViews', 'PaymentHistory');
	var $components = array('TrackUser','Utility','RequestHandler');

	var $helpers = array('Form','Paginator','Time');
	
	/*	display a form to post new Job by company		*/
	function postJob(){

		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			$this->set('states',$this->Utility->getState());
			$this->set('industries',$this->Utility->getIndustry());
			//$this->set('specifications',$this->Utility->getSpecification());
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

		

		$paidReward = $this->PaymentHistory->find('all',array('conditions'=>array('PaymentHistory.user_id'=>$userId,
																				'PaymentHistory.payment_status' =>1),
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

		$arch_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>0);
		$archJobCount = $this->Job->find('count',array('conditions'=>$arch_conditions));
		$this->set('archJobCount',$archJobCount);

		$active_job_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>1);
		$activejobCount = $this->Job->find('count',array('conditions'=>$active_job_conditions));
		$this->set('activejobCount',$activejobCount);		
	}

	/* Company data ends */


	function save(){
        $userId = $this->TrackUser->getCurrentUserId();
		$company = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
		$this->data['Job']['user_id']= $userId;
		$this->data['Job']['company_id']= $company['Companies']['id'];
		$this->data['Job']['company_name']= $company['Companies']['company_name'];
		if($this->Job->save($this->data['Job'])){
            switch($this->params['form']['save']){
                case 'Post and Share Job with Network':
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');
                    $this->redirect('/companies/shareJob/'.$this->Job->id);
                    break;
                case 'Save for Later':
                default:
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');	
                    //$this->redirect('/companies/editJob/'.$this->Job->id);
					$this->redirect('/companies/newJob');
                    break;
        
            }
        }else{
            $this->Session->setFlash('Internal error while save job.', 'error');	
            $this->redirect('/companies/newJob/');
        }		
	}
	
	function editJob(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
	
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId)));
			if($jobs['Job']){
				$this->set('job',$jobs['Job']);	
			
				$this->set('states',$this->Utility->getState());
				$this->set('industries',$this->Utility->getIndustry());
				//$this->set('specifications',$this->Utility->getSpecification());
				
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
			$this->Session->write('welcomeUserName',$this->data['Company']['contact_name']);
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/companies');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function paymentInfo() {
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
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
			
			/*** 
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
		    $paymentAction = urlencode("Sale");
	
		    $nvpRecurring = '';
			$methodToCall = 'doDirectPayment';
		    
		    $nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.$padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;

			$paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE, '', '', FALSE, FALSE );
		    $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		    $ack = strtoupper($resArray["ACK"]);
			print_r($resArray);
			exit;
		   
			$authorizationID = urlencode('');
			$note = urlencode('');

			// Add request-specific fields to the request string.
			$nvpstr.="&AUTHORIZATIONID=$authorizationID&NOTE=$note";		

			// Execute the API operation; see the PPHttpPost function above.
			$httpParsedResponseAr = $this->PPHttpPost('DoVoid', $nvpstr);

			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
				exit('Void Completed Successfully: '.print_r($httpParsedResponseAr, true));
			} else  {
				exit('DoVoid failed: ' . print_r($httpParsedResponseAr, true));
			}
			exit;
			/*** end test code***/
            
			if( !$this->PaymentInfo->save($this->data['PaymentInfo'],array('validate'=>'only')) ){	
				$this->render("payment_info");
				return;				
			}else{
				if(isset($this->data['PaymentInfo']['applied_job_id'])&& $this->data['PaymentInfo']['applied_job_id']!=""){
					$this->redirect('/companies/checkout/'.$this->data['PaymentInfo']['applied_job_id']);
				}
				$this->Session->setFlash('Payment Infomation has been updated successfuly.', 'success');	
				$this->redirect('/companies/paymentInfo');
			}		
		}		
	}

	function paymentHistory() {
		$userId = $this->TrackUser->getCurrentUserId();	
		$tid = isset($this->params['tid'])?$this->params['tid']:"";
		$roleInfo = $this->TrackUser->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
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
		$roleInfo = $this->TrackUser->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
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
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/companies/paymentHistory');
			}														
			$this->set('PaymentDetail',$PaymentDetail);	
			$this->set('jobInfo',$this->getJob($PaymentDetail['job']['id']));	
		}
		else{
			$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
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
												  'conditions' => array('JobseekerApply.user_id = jobseekers.user_id ')
											     ),
											array('table' => 'networkers',
												  'alias' => 'networkers',
												  'type' => 'LEFT',
												  'conditions' => array('SUBSTRING_INDEX(JobseekerApply.intermediate_users, ",", -1) = networkers.user_id')
											     )
									      ),
							'limit' => 10, // put display fillter here
							'order' => array('JobseekerApply.id' => 'desc'), // put sort fillter here
							'recursive'=>0,
							'fields'=>array('JobseekerApply.*,
											jobseekers.contact_name,networkers.contact_name'),
							
							);
				

				$applicants = $this->paginate("JobseekerApply");
				//echo "<pre>";  print_r($applicants);
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
				//echo "<pre>"; print_r($applicants);  exit;
	}

	
	function viewResume(){
 		
		if(isset($this->params['id'])){		
			
			$id = $this->params['id'];
			$file_type = $this->params['ftype'];
			
		
			$jobprofile = $this->JobseekerApply->find('first',array('conditions'=>array('id'=>$id)));
			if($jobprofile['JobseekerApply']){

				if($file_type=='resume'){
					$file = $jobprofile['JobseekerApply']['resume'];
					$fl = BASEPATH."webroot/files/resume/".$file;
				}
				if($file_type=='cover_letter'){
					$file = $jobprofile['JobseekerApply']['cover_letter'];
					$fl = BASEPATH."webroot/files/cover_letter/".$file;
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
					// $this->redirect('/jobs/jobProfile');
				}				
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				// $this->redirect('/jobs/jobProfile');
			}
		}		
	}
	

	/** Job Statistics **/
	function jobStats(){
		$userId = $this->TrackUser->getCurrentUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
			
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId),"fileds"=>"id"));
			// 	echo "<pre>"; print_r($jobs); exit;
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


	function facebookObject() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
          'cookie' => true,
		));
		return $facebook;
	}
	
	/****** Delete Job *******/
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


    function getFaceBookLoginURL(){ 
        $loginUrl = $this->facebookObject()->getLoginUrl(array(
                                                                'canvas' => 1,
                                                                'fbconnect' => 0,
                                                                'scope' => 'offline_access,publish_stream'
                    ));
        return $loginUrl;
    }

    /***** shareJob *********/
    function shareJob(){
        /*$this->getFaceBookLoginURL();
        $user = $this->facebookObject()->getUser();
        if($user){
            echo $this->facebookObject()->getAccessToken();exit;
        }*/
        
      /*  $token =  array(
                        'access_token' => 'AAAE1rdcxV8YBADnh8x5tmdYatIHJ0yJTug10lLYH8PuzCGDOXk174jTH1DbTcL5qAdZAMCUfYAHCHx0lsUcigfILSDMSMDiGS36eDaQZDZD'

                    );
        $userdata = $this->facebookObject()->api('/me/friends', 'GET', $token);
        //print_r($userdata);
        foreach ($userdata as $key=>$value) {
    echo count($value) . ' Friends';
    echo '<hr />';
    echo '<ul id="friends">';
    foreach ($value as $fkey=>$fvalue) {
        echo '<li><img src="https://graph.facebook.com/' . $fvalue['id'] . '/picture" title="' . $fvalue['name'] . '"/>'.$fvalue['name'].'</li>';
    }
    echo '</ul>';} */
    //$result = $this->facebookObject()->api("/me/feed",'post',array('message'=>'Testing','access_token' =>'AAAE1rdcxV8YBADnh8x5tmdYatIHJ0yJTug10lLYH8PuzCGDOXk174jTH1DbTcL5qAdZAMCUfYAHCHx0lsUcigfILSDMSMDiGS36eDaQZDZD'));
    //print_r($result);exit;
    //}
    }

    function getFaceBookFriendList(){
        $userId = $this->Session->read('Auth.User.id');
        if(!$this->RequestHandler->isAjax()){
            $user = $this->facebookObject()->getUser();
            if($user){
                
                // save users facebook token
                $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
                $saveUser['User']['facebook_token'] = $this->facebookObject()->getAccessToken();
                $this->User->save($saveUser);
                $this->set('error',false);
                
            }else{
                //this would be call when user decline permission            
            }
        }else{

            $this->autoRender = false;
            $user = $this->User->find('first',array('fields'=>'facebook_token','conditions'=>array('id'=>$userId,'facebook_token !='=>'NULL')));
            //get token from table other wise send for login.
            if($user){
                try{
                    $token =  array(
                                'access_token' =>$user['User']['facebook_token']

                            );
                    $userdata = $this->facebookObject()->api('/me/friends', 'GET', $token);
                    $users = array();
                    $i =0 ;
                    foreach ($userdata as $key=>$value) {
                        foreach ($value as $fkey=>$fvalue) {
                            $users[$i]['name'] = $fvalue['name'] ;
                            $users[$i]['id'] = $fvalue['id'];
                            $users[$i]['url'] = 'https://graph.facebook.com/'.$fvalue['id'].'/picture';
                            $i++;
                        }
                    }
                    return json_encode(array('error'=>0,'data'=>$users));
                }catch(Exception $e){
                    return json_encode(array('error'=>2,'message'=>'Error in facebook connection.Please try after some time.'));
                }
            }else{
                echo json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$this->getFaceBookLoginURL()));
            }   
        }
    }


    function commentAtFacebook(){
        $this->autoRender = false;
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $userId = $this->Session->read('Auth.User.id');
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        if(!empty($userIds) && $message &&  $User){
            foreach($userIds as $id){
                try{

                    $result = $this->facebookObject()->api("/".$id."/feed",'post',array('message'=>$message,'access_token' =>$User['User']['facebook_token']));
                    
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }

            }
        }
        return json_encode(array('error'=>0));

    }


   function getLinkedinFriendList(){
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        $this->autoRender = false;
        //$this->autoRender = false;
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));
        if($user){
            
           // $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
            $linkedin->access_token =unserialize($user['User']['linkedin_token']);
            $xml_response = $linkedin->getProfile("~/connections:(headline,first-name,last-name,picture-url,id)");
            $response=simplexml_load_string($xml_response);
            $users = array();
            
            if(count($response->person)){
                $firstName = 'first-name';
                $lastName = 'last-name';
                $id = 'id';
                $picURL = 'picture-url';
                foreach($response->person as $person){ //print_r($person->$a);
                    $users[] = array('name'=>$person->$firstName." ".$person->$lastName,'id'=>"".$person->$id,'url'=>"".$person->$picURL);                
                }             
            }
            return json_encode(array('error'=>0,'data'=>$users));
//            if($response->status == '404') echo "Not found11";
 //               echo json_encode(array('error'=>1,'message'=>'User id is not valid'));
        }else{
            $linkedin->getRequestToken();
            $this->Session->write('requestToken',serialize($linkedin->request_token));
            echo json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$linkedin->generateAuthorizeUrl()));
        }
    }
   

    function linkedinCallback(){
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        if (isset($_REQUEST['oauth_verifier'])){
            //$_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];
            $linkedin->request_token    =   unserialize($this->Session->read("requestToken"));
            $verifier = $this->params['url']['oauth_verifier'];
            $linkedin->oauth_verifier = $verifier;
            $linkedin->getAccessToken($verifier);
            $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
            $saveUser['User']['linkedin_token'] = serialize($linkedin->access_token);
            $this->User->save($saveUser);
            $this->set('error',false);
        }

    }

//sendMessage($ids,$subject,$message)
    function sendMessagetoLinkedinUser(){
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        $this->autoRender = false;
        //$this->autoRender = false;
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));


        if(!empty($userIds) && $message &&  $user){
            foreach($userIds as $id){
                try{

                    $linkedin->access_token =unserialize($user['User']['linkedin_token']);
                    $xml_response = $linkedin->sendMessage($id,$subject,$message);
                    return json_encode(array('error'=>0));
                    
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }

            }
        }



        if($user){
            
         }

    }



    private function getLinkedinObject(){
        return  new LinkedIn(LINKEDIN_ACCESS, LINKEDIN_SECRET, LINKEDIN_CALLBACK_URL);    
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
				$this->redirect("/companies/paymentInfo/$appliedJobId");
			}			
		}else{
			$this->Session->setFlash('May be you click on old link or you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
			return;
		}
				//echo "<pre>"; print_r($applicants);  exit;
	}

	/*	Do payment of reward amount for given applied-job...*/
    function paypalProPayment() {
        $userId = $this->TrackUser->getCurrentUserId();
        $appliedJobId = $this->params['id'];        
        								
        if($userId && $appliedJobId){
        
		    $cardInfo = $this->PaymentInfo->find('first',array('conditions'=>array('PaymentInfo.user_id'=>$userId)));
		    $companyInfo = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
		    
		    $appliedJob = $this->appliedJob($appliedJobId);
		    //echo "<pre>";  print_r($appliedJob);exit;
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

		    $paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE, '', '', FALSE, FALSE );
		    $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		    $ack = strtoupper($resArray["ACK"]);
		    
		    if($ack == "SUCCESS") {
		        if(isset($resArray['TRANSACTIONID'])) {
		        	echo "SUCCESS : ".$resArray['TRANSACTIONID']; exit;
		        	// Here change status of applied job from applied to selected in jobseeker_apply table....
		        	/*	
		        	
		        	 if($this->JobseekerApply->updateAll(array('is_active'=>1), array('JobseekerApply.id'=>$appliedJobId))){
						
						$paymentHistory = array();
						$paymentHistory['user_id'] = $userId;
						$paymentHistory['job_id'] = $appliedJob['Job']['id'];
						$paymentHistory['applied_job_id'] = $appliedJob['JobseekerapplyJob']['id'];
						$paymentHistory['jobseeker_user_id'] = $appliedJob['JobseekerapplyJob']['user_id'];
						$paymentHistory['amount'] = $appliedJob['Job']['reward'];
						$paymentHistory['transaction_id'] = $resArray['TRANSACTIONID'];
						
						$this->PaymentHistory->save($paymentHistory);
												
						//echo "<pre>"; print_r($paymentHistory); 	
						$this->Session->setFlash('Applicant has been selected successfully.', 'success');	
						$this->redirect("/companies/showApplicant/".$appliedJob['Job']['id']);
						return;
					}	        	
		        	
		        	*/
		        	
		            $this->redirect("/companies/newJob/".$resArray['TRANSACTIONID']);
		        }else {
		            $this->Session->setFlash("Due To Unknown Paypal Response, We Cannot Procced.", 'error');
		            $this->redirect("/companies/checkout");
		        }
		        
		    } else {
		        $error_msg = "Invalid Data";
		        
		        /*	here we comes with error but for testing purpose make this success......	*/
		        if($this->JobseekerApply->updateAll(array('is_active'=>1), array('JobseekerApply.id'=>$appliedJobId))){
						
						$paymentHistory = array();
						$paymentHistory['user_id'] = $userId;
						$paymentHistory['job_id'] = $appliedJob['Job']['id'];
						$paymentHistory['applied_job_id'] = $appliedJob['JobseekerapplyJob']['id'];
						$paymentHistory['jobseeker_user_id'] = $appliedJob['JobseekerapplyJob']['user_id'];
						$paymentHistory['amount'] = $appliedJob['Job']['reward'];
						$paymentHistory['transaction_id'] = $resArray['CORRELATIONID'];//TRANSACTIONID
						
						if($this->PaymentHistory->save($paymentHistory)){
							$this->sendCongratulationEmail($appliedJob);	
							$this->Session->setFlash('Applicant has been selected successfully.', 'success');	
							$this->redirect("/companies/showApplicant/".$appliedJob['Job']['id']);
							return;
						}						
					}
		        
		        //echo "<pre>"; print_r($resArray); exit;
		        if(isset($resArray['L_LONGMESSAGE0'])) {
		            $error_msg = $resArray['L_LONGMESSAGE0'];
		        }elseif(isset($resArray['L_SHORTMESSAGE0'])) {
		            $error_msg = $resArray['L_SHORTMESSAGE0'];
		        }
		        $this->Session->setFlash($error_msg, 'error');
		        $this->redirect("/companies/checkout");
		    }
		}
		else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
			return;
		}  		      
    }


/**
 * For test view share_email
 */
	function share_render()
	{
		$this->render('share_email');
	}

/**
 * For test send_email
 */
	function shareJobByEmail()
	{
		$this->autoRender= false ;
		if(isset($this->params['form']['toEmail'])&&!empty($this->params['form']['toEmail']))
		{
			$from='traineest@gmail.com';
			$to=trim($this->params['form']['toEmail']);
			$subject=$this->params['form']['subject'];
			$job_details=$this->Job->find('first',array('fields'=>array(
														'Job.id','title','reward','Company.company_name','city','state'
														),
														'recursive'=>-1,
														'joins'=>array(
															array(
															'table'=>'companies',
															'alias'=>'Company',
															'type'=>'inner',
															'fields'=>'Company.id,Company.company_name',
															'conditions'=>array(
																'Job.company_id = Company.id'
																)
															)
														),
														'conditions'=>array('Job.id'=>5, 'is_active'=>1)
													)
												);
			$message=$this->params['form']['message'];
			if(!isset($from)||empty($job_details))
				return "Email address not found";
			if(isset($job_details)&&!empty($job_details))
				return $this->sendEmail($to,$from,$subject,$message,$job_details);
			else
				return "Job not selected!";
		}
		else
		{
			return "Email address not specified!";
		}

	}

	protected function sendEmail($to,$from,$subject,$message,$job_details)
	{
		$this->autoRender= false ;
		if(isset($to) && $to!="" && isset($from) && $from!="")
		{
			if(isset($job_details)&&!empty($job_details))
			{
				try
				{
					$this->Email->from=$from;
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->template='shared_job_details';
					$this->set('message',$message);
					$this->set('job_details',$job_details);
					$this->Email->sendAs='both';
					$this->Email->send();
				}catch(Exception $e)
				{
					pr($e);
				}
			}
			else
				return "Job not selected";
			return "Email send";
		}
		else
		{
			return "Email address is not specified!";
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
    	$appliedOn = $appliedJob['JobseekerapplyJob']['created'];
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
		$this->paginate = array('conditions' => array('PaymentHistory.user_id'=>$userId),
								'limit'=>'10', 	
								'joins'=>array(
											array('table'=>'users',
												  'type'=>'inner',
												  'conditions'=>array('users.id=PaymentHistory.jobseeker_user_id',
																	  'users.is_active=1'),
												 ),
										 	array('table'=>'jobseekers',
												  'alias'=> 'js',
												  'type'=>'inner',
												  'conditions'=>array('js.user_id =PaymentHistory.jobseeker_user_id'),
												 ),
											   ),
								'fields'=>array('PaymentHistory.user_id,PaymentHistory.paid_date,js.contact_name,
												js.contact_phone,js.city,js.state,users.account_email'),
								);
		$employees = $this->paginate("PaymentHistory");
		$this->set('employees',$employees);
		// end for job fetching...
    }

/**		*****	Twitter :: Handling	*****	**/

	private function getTwitterObject(){
		require_once(APP_DIR.'/vendors/twitter/EpiCurl.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiOAuth.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiTwitter.php'); 
		require_once(APP_DIR.'/vendors/twitter/secret.php');
		$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
		return $twitterObj;
	}

	private function connectTwitter(){
		$this->redirect($this->getTwitterObject()->getAuthorizationUrl());
	}

	function twitterCallback(){
	 	$userId = $this->Session->read('Auth.User.id');
		$oauth_token = isset($this->params['url']['oauth_token'])?$this->params['url']['oauth_token']:'';
		if($oauth_token){
			$twitterObj = $this->getTwitterObject();
			$twitterObj->setToken($oauth_token);
			$token = $twitterObj->getAccessToken();			
			
			$currentUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
            $currentUser['User']['twitter_token'] = $token->oauth_token;
            $currentUser['User']['twitter_token_secret'] = $token->oauth_token_secret;
            if($this->User->save($currentUser)){
            	$this->redirect("/companies/getTwitterFriendList");
            }            
		}
	}	
	
	function postTweet(){
		$user = $user = $this->data['Twitter']['SendTo'];
		$msg = $this->data['Twitter']['msg'];
		$twitterObj = $this->getTwitterObject();
		$twitterObj->setToken($this->Session->read('Twitter.twitter_token'),$this->Session->read('Twitter.twitter_token_secret'));
		$myArray = array('user' => $user, 'text' => $msg);
        $resp = $twitterObj->post_direct_messagesNew( $myArray);
        $temp = $resp->response;
		$this->Session->setFlash('Your message has been posted successfuly.', 'success');
		$this->redirect("/companies/getTwitterFriendList");
	}
	
	function getTwitterFriendList(){
        $userId = $this->Session->read('Auth.User.id');
		$user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'),'conditions'=>array('id'=>$userId,
																								'twitter_token !='=>'',
																								'twitter_token_secret !='=>'')));
		if(!$user){
			$this->connectTwitter();
		}
		else{
			$twitterObj = $this->getTwitterObject();
			
			$this->Session->write('Twitter.twitter_token',$user['User']['twitter_token']);
			$this->Session->write('Twitter.twitter_token_secret',$user['User']['twitter_token_secret']);
			
			$twitterObj->setToken($user['User']['twitter_token'],$user['User']['twitter_token_secret']);
			$twitterInfo= $twitterObj->get_accountVerify_credentials();
			$twitterInfo->response;

			$username = $twitterInfo->screen_name;
			$profilepic = $twitterInfo->profile_image_url;
			
			$trends_url = "http://api.twitter.com/1/statuses/followers/$username.json";
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $trends_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$curlout = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($curlout, true);			
			$this->set('url',$twitterObj->getAuthorizationUrl());
			$this->set('username',$username);
			$this->set('profilepic',$profilepic);
			$this->set('response',$response);
		}		
    }
   /**		*****	End of Twitter :: Handling	*****	**/  
    


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
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
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
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}

		return $httpParsedResponseAr;
	}

}
?>

