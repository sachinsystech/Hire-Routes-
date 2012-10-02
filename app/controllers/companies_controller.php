<?php

class CompaniesController extends AppController {

	var $name = 'Companies';
   	var $uses = array('User', 'Companies', 'Job', 'PaymentInfo', 'JobseekerApply', 'JobViews', 
   		'PaymentHistory','PaypalResponse','Config','University','RewardsStatus','SharedJob','Invitation'
   	);
	var $components = array('TrackUser','Utility','RequestHandler','Session');
	var $helpers = array('Form','Paginator','Time');
	
	public function beforeFilter(){
		parent::beforeFilter();
		
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect('/login');
		}
		if($session->getUserRole()!=COMPANY){
			$this->redirect("/users/loginSuccess");
		}
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
		
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('accountProfile');		
		$this->Auth->allow('archiveJob');
		$this->Auth->allow('companyData');
		$this->Auth->allow('checkout');
		$this->Auth->allow('getCompanyActiveJobsCount');
		$this->Auth->allow('getCompanyArchiveJobsCount');
		$this->Auth->allow('deleteJob');
		$this->Auth->allow('editJob');		
		$this->Auth->allow('editProfile');		
		$this->Auth->allow('employees');		
		$this->Auth->allow('jobseekerFilledProfile');		
		$this->Auth->allow('jobStats');
		$this->Auth->allow('newJob');
		$this->Auth->allow('paymentHistoryInfo');
		$this->Auth->allow('paymentHistory');
		$this->Auth->allow('paymentInfo');
		$this->Auth->allow('postJob');
		$this->Auth->allow('paypalProPayment');
		$this->Auth->allow('rejectApplicant');
		$this->Auth->allow('showApplicant');
		$this->Auth->allow('showArchiveJobs');		
		$this->Auth->allow('viewResume');		
		$this->Auth->allow('invitations');	
     }
	
	
	/*	display a form to post new Job by company		*/
	function postJob(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		if($userId){
			$this->set('states',$this->Utility->getState());
			$this->set('specifications',$this->Utility->getSpecification());
			$this->set('industries',$this->Utility->getIndustry());
			if(isset($this->data['Job'])){
				if(!(strtoupper(trim($this->params['form']['save']))=='POST AND SHARE')){
					$this->data['Job']['is_active']=3;	//For 3=>unpublished, 1=>active job posts
				}
				$company = $this->Companies->find(
					'first',array('conditions'=>array('Companies.user_id'=>$userId))
				);
				$this->data['Job']['user_id']= $userId;
				$this->data['Job']['company_id']= $company['Companies']['id'];
				$this->data['Job']['company_name']= $company['Companies']['company_name'];
				$this->data['Job'] = $this->Utility->stripTags($this->data['Job']);
				$this->Job->set($this->data['Job']);
				if($this->Job->validates()){
					if($this->Job->save()){
    		    	    switch($this->params['form']['save']){
    		    	        case 'POST AND SHARE':
								$this->Session->write('openShare','open');
    		    	            $this->Session->setFlash('Job has been saved successfuly.', 'success');
    		    	            $this->redirect('/companies/editJob/'.$this->Job->id);
    		    	            break;
    		    	        case 'SAVE FOR LATER':
								$this->Session->setFlash('Job has been saved successfuly. Post it later',
									'success');	
								$this->redirect('/companies/newJob');
								break;
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
		
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}
	
	function newJob(){
		$this->layout ="home";
		$session = $this->_getSession();
		$userId = $session->getUserId();
		$displayPageNo = isset($this->params['named']['display'])?$this->params['named']['display']:6;
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

		//	fetching jobs with given condition
		$conditions = array('Job.user_id'=>$userId,"OR"=>array("Job.is_active"=>array(1,3)));
		$this->paginate = array(
			'conditions' => $conditions,
			'limit'=>$displayPageNo,
			'joins'=>array(
				array(
					'table' => 'jobseeker_apply',
					'alias' => 'ja',
					'type' => 'LEFT',
					'conditions' => array('Job.id = ja.job_id', 'ja.is_active' => 0),
				)
			),
		    'order' => array($shortByItem => 'desc'),
		    'recursive'=>0,
		    'fields'=>array('Job.id, Job.user_id, Job.title, Job.is_active, Job.created, 
		    	COUNT(ja.id) as submissions'
		    ),
			'group'=>array('Job.id'),
		);
		$jobs = $this->paginate("Job");
		$this->set('jobs',$jobs);
		// end for job fetching...

	}

/*
list archive jobs..
*/

	function showArchiveJobs(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$displayPageNo = isset($this->params['named']['display'])?$this->params['named']['display']:6;
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
			'limit'=>$displayPageNo,
			'joins'=>array(
				array(
					'table' => 'jobseeker_apply',
					'alias' => 'ja',
					'type' => 'LEFT',
					'conditions' => array('Job.id = ja.job_id')
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
	}
	
	/* Company data starts*/
	function companyData(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$jobPosted = $this->Job->find(
			'all',array(
				'conditions'=>array('Job.user_id'=>$userId),
				'fields'=>array('SUM(Job.reward) as jobs_reward, count(Job.id) as jobs_posted')
			)
		);

		if($jobPosted){
			$rewardPosted = $jobPosted[0][0]['jobs_reward'];
			$jobPosted	  = $jobPosted[0][0]['jobs_posted'];
		}else{
			$rewardPosted = 0;
			$jobPosted	  = 0;
		}

		$jobApply = $this->JobseekerApply->find(
			'all',array(
				'conditions'=>array('jobs.user_id'=>$userId),
			  	'joins'=>array(
			  		array(
			  			'table' => 'jobs',
	    				'alias' => 'jobs',
						'type'  => 'LEFT',
						'conditions' => 'jobs.id =JobseekerApply.job_id',
					)
		        ),
				'fields'=> array('COUNT(DISTINCT JobseekerApply.job_id) as job_filled, 
					count(JobseekerApply.job_id) as applicants'
				),
			)
		);

		$jobFilled  = $jobApply[0][0]['job_filled'];
		$applicants = $jobApply[0][0]['applicants'];
		$jobReward = $this->Job->find(
			'all',array(
				'conditions'=>array('Job.user_id'=>$userId),
				'fields'=>array('SUM(Job.reward) as jobs_reward'),
			)
		);
		$paidReward = $this->PaymentHistory->find(
			'all',array(
				'conditions'=>array('PaymentHistory.user_id'=>$userId),
				'fields'=>array('SUM(PaymentHistory.amount) as paid_reward'),
			)
		);
		if($paidReward){
			$rewardPaid = $paidReward[0][0]['paid_reward'];
		}else{
			$rewardPaid = 0;
		}
		$jobViews = $this->JobViews->find(
			'count',array(
				'conditions'=>array('jobs.user_id'=>$userId),
			    'joins'=>array(
			    	array(
			    		'table' => 'jobs',
						'alias' => 'jobs',
					    'type'  => 'LEFT',
						'conditions' => 'JobViews.job_id = jobs.id',
					)
				)
			)
		);
		
		$this->set('JobPosted',$jobPosted);
		$this->set('JobFilled',$jobFilled);	
		$this->set('RewardsPosted',$rewardPosted);
		$this->set('RewardsPaid',$rewardPaid);
		$this->set('Applicants',$applicants);
		$this->set('Views',$jobViews);
	}
	/* Company data ends */
	
	public function getCompanyActiveJobsCount(){
		$userId = $this->_getSession()->getUserId();
		$active_job_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>array(1,3));
		$activejobCount = $this->Job->find('count',array('conditions'=>$active_job_conditions));
		return $activejobCount;
	}

	public function getCompanyArchiveJobsCount(){
		$userId = $this->_getSession()->getUserId();	
		$arch_conditions = array('Job.user_id'=>$userId,"Job.is_active"=>0);
		$archJobCount = $this->Job->find('count',array('conditions'=>$arch_conditions));
		return $archJobCount;
	}

/*****	Companies edit their own Job :: 	*********/
	function editJob(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$jobId = $this->params['jobId'];
		$shareJob=isset($this->params['form']['shareJob'])?true:false;

		if($userId && $jobId){
			$jobs = $this->Job->find(
				'first',array(
					'conditions'=>array(
						'Job.id'=>$jobId,
						'Job.user_id'=>$userId,
						'Job.is_active'=>array(1,3)
					)
				)
			);
			if($jobs['Job']){
				$jobs['Job'] = $this->Utility->htmlEntityDecode($jobs['Job']);
				$this->set('job',$jobs['Job']);	
				$this->set('jobId',$jobId);
				$this->set('jobTitle',$jobs['Job']['title']);
				$code=$this->Utility->getCode($jobId,$userId);
                $this->set('intermediateCode',$code);
                if(isset($code)&&!empty($code))
                	$jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$jobId.'/?intermediateCode='.$code;
                else
	                $jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$jobId.'/';
                $this->set('jobUrl',$jobUrl);
				$this->set('states',$this->Utility->getState());
				$this->set('industries',$this->Utility->getIndustry());
				$this->set('specifications',$this->Utility->getSpecification());
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
			if($shareJob) $this->data['Job']['is_active'] = 1;
			$this->data['Job'] = $this->Utility->stripTags($this->data['Job']);
			$this->Job->set($this->data['Job']);
			if($this->Job->validates()){
				$this->Job->save();
				if($shareJob) {
					$this->Session->write('openShare','open');
					$this->Session->setFlash('Job has been posted successfuly.', 'success');
					$this->redirect('/companies/editJob/'.$this->Job->id);
				}
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
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}
	/*------- Fro  prevent the Xss----*/

	
	function accountProfile() {
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}

	function editProfile() {
		$this->layout ="home";
		$session = $this->_getSession();
		$userId = $session->getUserId();
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			if(!empty($this->data['Companies']['company_name'])){
				$this->User->save($this->data['User']);
				if($this->Companies->save($this->data['Companies'])){
					$session->start();
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
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}

	function paymentInfo() {
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();		
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
		$submit_txt = "SAVE";
		if(isset($this->params['id'])){
			$submit_txt = "PROCEED TO CHECKOUT";
		}
		$this->set('submit_txt',$submit_txt);
		if(isset($this->data['PaymentInfo'])){

			require_once(APP.'vendors'.DS."paypalpro/paypal_pro.inc.php");
			$this->data['PaymentInfo'] = $this->Utility->stripTags($this->data['PaymentInfo']);
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
		        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) 
		        	|| "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
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
			        if(isset($this->data['PaymentInfo']['applied_job_id']) 
			        	&& $this->data['PaymentInfo']['applied_job_id']!=""){
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
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());		
	}

	function paymentHistory() {
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$tid = isset($this->params['tid'])?$this->params['tid']:"";
		
		if($userId){
			$conditions = array('PaymentHistory.user_id'=>$userId);
			$this->paginate = array(
				'limit'=>'10', 
				'conditions' => $conditions,
				'order' => array('paid_date' => 'desc'),
			);
			$PaymentHistory = $this->paginate("PaymentHistory");
			$this->set('PaymentHistory',$PaymentHistory);	
		}
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}
	
	function paymentHistoryInfo(){
		
		$userId = $this->_getSession()->getUserId();
		$this->autoRender= false ;
		$id = isset($this->params['form']['id'])?$this->params['form']['id']:"";
		$tid = isset($this->params['form']['tid'])?$this->params['form']['tid']:"";
				
		if($userId && isset($tid) &&isset($id)){
			$PaymentDetail = $this->PaymentHistory->find(
				'first',array(
					'conditions'=>array(
						'PaymentHistory.id'=>$id,
						'PaymentHistory.user_id'=>$userId, 
						'PaymentHistory.transaction_id'=>$tid
					),
					'joins'=>array(
						array(
							'table' => 'jobseeker_apply',
					        'alias' => 'jsapply',
		 				    'type' => 'INNER',
		 				    'conditions' => array('PaymentHistory.applied_job_id = jsapply.id',)
		 				),
					 	array(
					 		'table' => 'jobs',
					        'alias' => 'job',
					        'type' => 'INNER',
					        'conditions' => array('PaymentHistory.job_id = job.id',)
					    ),
					    array(
					    	'table' => 'jobseekers',
					        'alias' => 'js',
					        'type' => 'INNER',
					        'conditions' => array('PaymentHistory.jobseeker_user_id = js.user_id',)
					    ),   
					),
					'fields'=>array('PaymentHistory.amount, PaymentHistory.paid_date, 
						PaymentHistory.transaction_id, job.id,job.title, job.short_description, 
						jsapply.*, js.contact_name'
					) 
				) 
			); 		
			if(!$PaymentDetail){
				$error=array('error'=>1,'message'=>'Something went wrong, please try again.');
				return json_encode($error);
			}	
			$jobInfo = $this->getJob($PaymentDetail['job']['id']);
			$pd =array();
			$pd['transaction_id']=$PaymentDetail['PaymentHistory']['transaction_id'];
			$pd['paid_date']=date("m/d/yy" , strtotime($PaymentDetail['PaymentHistory']['paid_date']));	
			setlocale(LC_MONETARY, 'en_US.UTF-8');
			$pd['amount']=money_format('%2n', $PaymentDetail['PaymentHistory']['amount']);
			if(isset($PaymentDetail['js']['contact_name']) && !empty($PaymentDetail['js']['contact_name'])){
				$pd['contact_name']= ucfirst($PaymentDetail['js']['contact_name']);
			}
			else{
				$pd['contact_name']= "<i>Name Not Available</i>";
			}
			$pd['job_title']=$PaymentDetail['job']['title'];
			$pd['description']=$PaymentDetail['job']['short_description'];	
			$pd['industry']= $jobInfo['ind']['name'].", ".$jobInfo['spec']['name'];
			$location =$jobInfo['state']['state'];
			if(!empty($jobInfo['city']['city'])) {
				$location= $jobInfo['city']['city'].",&nbsp;".$location;
			}
			$pd['location']= $location;
			return json_encode($pd);
		}else{
			$error=array('error'=>1,'message'=>'Something went wrong, please try again.');
			return json_encode($error);
		}
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}
	
	private function getJob($jobId){
		$jobInfo = $this->Job->find(
			'first',array(
				'conditions'=>array('Job.id'=>$jobId),
				'joins'=>array(
					array(
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
		            	'table' => 'states',
		                'alias' => 'state',
		                'type' => 'LEFT',
		                'conditions' => array('Job.state = state.id',)
		            )
				),
				'fields'=>array('Job.*, ind.name, city.city, state.state, spec.name' ),
			)
		);
		return $jobInfo;										 
	}
	
	/** move active job to archive(Disable) **/
	function archiveJob(){
		$userId = $this->_getSession()->getUserId();
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find(
				'first',array(
					'conditions'=>array(
						"Job.id"=>$jobId,
						"Job.user_id"=>$userId,
						"OR"=>array("Job.is_active"=>array(1,3))
					),
					"fileds"=>"id"
				)
			);
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
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find(
				'first',array(
					'conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),
					'fields'=>'id'
				)
			);
			$universities=$this->University->find('list',array('fields'=>'id,name'));
			$this->set('universities',$universities);
			if($jobs['Job']){
				$conditions = array(
					'JobseekerApply.job_id'=>$jobs['Job']['id'], 'JobseekerApply.is_active'=>0
				);
				if(isset($this->data['User'])){
					$i=0;
					foreach($this->data['User'] as $answer=>$user){
						if($user!=""){
							$ans[$i] = array($answer=>$user);
							$i++;
						}
					}
					$conditions = array('OR' => $ans, 'AND' => $conditions);
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
							'conditions'=>array('jobseekers.user_id = User.id')
						),
						array(
							'table'=>'users',
							'alias'=>'NetworkerUser',
							'type'=>'left',
							'conditions'=>array('SUBSTRING_INDEX(JobseekerApply.intermediate_users,",",1) = NetworkerUser.id')
						),
						array(
							'table'=>'networkers',
							'alias'=>'Networker',
							'type'=>'left',
							'conditions'=>array('Networker.user_id = NetworkerUser.id')
						),
						
				    ),
					'limit' => 10, // put display fillter here
					'order' => array('JobseekerApply.id' => 'desc'), // put sort fillter here
					'recursive'=>0,
					'fields'=>array(
						'JobseekerApply.*, jobseekers.contact_name, User.parent_user_id, Job.user_id, NetworkerUser.parent_user_id, NetworkerUser.account_email, Networker.contact_name,Networker.university',
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
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
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
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
			$jobs = $this->Job->find(
				'first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId),"fileds"=>"id")
			);
			if($jobs['Job']){
				$jobStatusArray['aat'] = $this->JobseekerApply->find(
					'count',array('conditions'=>array('job_id'=>$jobId,'is_active'=>0))
				);
				
				$jobStatusArray['alm']= $this->JobseekerApply->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'is_active'=>0,
							'created >'=> date("Y-m-d", strtotime("-1 month")),
							'created <'=> date("Y-m-d")
						)
					)
				);
				$jobStatusArray['alw']= $this->JobseekerApply->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'is_active'=>0,
							'created >'=> date("Y-m-d", strtotime("-1 week")),
							'created <'=> date("Y-m-d")
						)
					)
				);

				
				$jobStatusArray['vat'] = $this->JobViews->find(
					'count',array('conditions'=>array('job_id'=>$jobId))
				);
	
				$jobStatusArray['vlm'] = $this->JobViews->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'created >'=> date("Y-m-d", strtotime("-1 month")),
							'created <'=> date("Y-m-d")
						)
					)
				);

				$jobStatusArray['vlw'] = $this->JobViews->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'created >'=> date("Y-m-d", strtotime("-1 week")),
							'created <'=> date("Y-m-d")
						)
					)
				);
													
				$jobStatusArray['sat'] =$this->SharedJob->find(
					'count',array('conditions'=>array('job_id'=>$jobId))
				);
				
				$jobStatusArray['slm']=$this->SharedJob->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'sharing_date >'=> date("Y-m-d", strtotime("-1 month")),
							'sharing_date <'=> date("Y-m-d")
						)
					)
				);
				$jobStatusArray['slw']=$this->SharedJob->find(
					'count',array(
						'conditions'=>array(
							'job_id'=>$jobId,
							'sharing_date >'=> date("Y-m-d", strtotime("-1 week")),
							'sharing_date <'=> date("Y-m-d")
						)
					)
				);
				
				$this->set('job',$jobs['Job']);	
				$this->set('jobId',$jobId);
				$this->set('jobStatusArray',$jobStatusArray);
				$this->set('NoOfApplicants',$jobStatusArray['aat']);
				$this->set('activejobCount',$this->getCompanyActiveJobsCount());
				$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
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
		
		$userId = $this->_getSession()->getUserId();
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
	$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
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
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
	}

	/*	Do payment of reward amount for given applied-job...*/
    function paypalProPayment() {
        $userId = $this->_getSession()->getUserId();
        $appliedJobId = $this->params['id'];        
        								
        if($userId && $appliedJobId){
        
		    $cardInfo = $this->PaymentInfo->find(
		    	'first',array('conditions'=>array('PaymentInfo.user_id'=>$userId))
		    );
		    $companyInfo = $this->Companies->find(
		    	'first',array('conditions'=>array('Companies.user_id'=>$userId))
		    );
		    
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
						$paymentHistory['paid_date'] = date('Y-m-d H:i:s');

						//***********To Store reward payout percent accoding to Scenario***********		
						$intermediate_user_ids=explode(',',$appliedJob['JobseekerapplyJob']['intermediate_users']);
		    			$count_intermediate_user=count($intermediate_user_ids);
						if(empty($intermediate_user_ids[0]))
							$count_intermediate_user=$count_intermediate_user-1;
		    			$jobSeekerParent=$this->User->find('first', array(
								'recursive'=>-1,
								'joins'=>array(
									array(
										'table'=>'networkers',
										'alias'=>'Networker',
										'type'=>'inner',
										'conditions'=>'Networker.user_id = User.parent_user_id'
									)
								),
								'conditions'=>array(
									'User.id'=>$appliedJob['JobseekerapplyJob']['user_id']
								),
								'fields'=>'Networker.user_id',
							)
						);
						if(!empty($jobSeekerParent)){
							$isFirstTimeSelect = $this->JobseekerApply->find('first',array(
									'conditions'=>array(
										'user_id'=>$appliedJob['JobseekerapplyJob']['user_id'],
										'is_active'=>1
									),
									'fields'=>'count(id) as selectionCount'
								)
							);
							if($isFirstTimeSelect[0]['selectionCount']>1){
								if($count_intermediate_user>0)
									$paymentHistory['scenario']=1;
								else
									$paymentHistory['scenario']=3;
							}else{
								if(in_array($jobSeekerParent['Networker']['user_id'],$intermediate_user_ids))
									$paymentHistory['scenario']=1;
								else{
									$paymentHistory['scenario']=2;
									if(empty($intermediate_user_ids[0]))
										$intermediate_user_ids[0]=$jobSeekerParent['Networker']['user_id'];
									else
										$intermediate_user_ids[]=$jobSeekerParent['Networker']['user_id'];
								}
							}
						}else{
							if($count_intermediate_user>0)
										$paymentHistory['scenario']=1;
									else
										$paymentHistory['scenario']=3;
						}						
						$senerio_percents=$this->Config->find('list',array('fields'=>'key, value','conditions'=>array('key like'=>'%pc_for_scenario_'.$paymentHistory['scenario'].'%')));
							$paymentHistory['hr_reward_percent']=$senerio_percents['hr_reward_pc_for_scenario_'.$paymentHistory['scenario'].''];
							$paymentHistory['networker_reward_percent']=$senerio_percents['nr_reward_pc_for_scenario_'.$paymentHistory['scenario'].''];
							$paymentHistory['jobseeker_reward_percent']=$senerio_percents['js_reward_pc_for_scenario_'.$paymentHistory['scenario'].''];
						//***********End Store reward payout percent***********
						$this->PaymentHistory->save($paymentHistory);
						$paymentHistoryId=$this->PaymentHistory->find('first',array('conditions'=>array(
												'applied_job_id' => $appliedJob['JobseekerapplyJob']['id']
											),
											'fields'=>'id',
											'order'=>'id desc',
										)
									);
						$rewardData['payment_history_id']=$paymentHistoryId['PaymentHistory']['id'];
						$rewardData['status'] = 0;
						$rewardData['user_id']= $appliedJob['JobseekerapplyJob']['user_id'];
						$this->RewardsStatus->save($rewardData);
						foreach($intermediate_user_ids as $key => $id){
							if(!empty($id)){
								$rewardData['user_id']=$id;
								$this->RewardsStatus->create();
								$this->RewardsStatus->save($rewardData);
							}
						}
						$this->Session->setFlash('Applicant has been selected successfully.', 'success');
						$this->sendCongratulationEmail($appliedJob);
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
    	
    	$userId = $this->_getSession()->getUserId();
    	$companyUserInfo = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
    	$JobseekerUserInfo = $this->User->find('first',array('conditions'=>array('User.id'=>$appliedJob['JobseekerapplyJob']['user_id'])));
    	    	
    	$payment_detail = $this->PaymentHistory->find('first',array(
			'fields'=>array(' ((PaymentHistory.amount *PaymentHistory.jobseeker_reward_percent )/100 ) as reward'
			),
			'recursive'=>-1,
			'order' => array('paid_date' => 'desc'),
			'joins'=>array(
				array(
					'table'=>'jobseeker_apply',
					'alias'=>'JobseekerApply',
					'type'=>'left',
					'fields'=>'user_id, intermediate_users, is_active',
					'conditions'=>'PaymentHistory.applied_job_id = JobseekerApply.id'
				),
				array(
					'table'=>'jobseekers',
					'alias'=>'Jobseeker',
					'type'=>'left',
					'fields'=>'id,user_id, contact_name',
					'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id'
				),
			),			
			'conditions'=>array('Jobseeker.user_id'=>$appliedJob['JobseekerapplyJob']['user_id'],
				'JobseekerApply.is_active'=>'1',
				"PaymentHistory.applied_job_id"=>$appliedJob['JobseekerapplyJob']['id'],
			)
		));
    	$jobDetails = $this->getJob($appliedJob['Job']['id']);    	
    	
    	$interMeedUsers = count(explode(',',$appliedJob['JobseekerapplyJob']['intermediate_users']));
    	$appliedOn = date("m/d/Y",strtotime($appliedJob['JobseekerapplyJob']['created']));
    	$jobTyps = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary');
    	
    	$emailMsgInfo = array();
    	$emailMsgInfo['company']['name'] = $companyUserInfo['Companies']['0']['company_name'];
    	$emailMsgInfo['company']['url'] = $companyUserInfo['Companies']['0']['company_url'];
    	$emailMsgInfo['jobseker']['name'] = $JobseekerUserInfo['Jobseekers']['0']['contact_name'];
    	$emailMsgInfo['job']['title'] = $jobDetails['Job']['title'];
    	$emailMsgInfo['job']['reward'] = ($interMeedUsers===1)?"<b>Reward for you : </b>".$payment_detail[0]['reward']."<b>$</b>":"0";
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
			return true;
		}catch(Exception $e){
			$this->redirect("/");
			return;
		}
    }

    private function appliedJob($appliedJobId){
   		$userId = $this->_getSession()->getUserId();
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
		$userId = $this->_getSession()->getUserId();
		$jobId=$this->params['form']['jobId'];
		$action=$this->params['form']['action'];
		if($action=="newJobs"){
			$activate=array(1,3);
		}else 
			$activate=0;

		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>$activate),"fileds"=>"id"));
				if($jobs['Job']){
				$jobs['Job']["is_active"] = 2 ;
				$this->Job->save($jobs);
				$this->Session->setFlash('Successfully, Job has been deleted.', 'success');	
				$success=array('success'=>true);
				return json_encode($success);
			}
		}
		$error=array('error'=>1,'message'=>'You may be clicked on old link or entered manually.');
		return json_encode($error);
    }

	public function employees(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();	
		$conditions[]="PaymentHistory.user_id=$userId";
		if(isset($this->params['named'])){
			$data=$this->params['named'];
		}
		if(isset($this->params['url']['find'])){
			$data=$this->params['url'];
		}
		if(isset($data)){
			if(isset($data['contact_name']) && !empty($data['contact_name'])){			
				$contact_name=addslashes(trim($data['contact_name']));
				$conditions[]=array('OR'=>array("js.contact_name LIKE\"".$contact_name."%\"",	));
				$this->set('contact_name',$data['contact_name']);	
			}
			if(isset($data['contact_phone']) && !empty($data['contact_phone'])){			
				$contact_phone=addslashes(trim($data['contact_phone']));
				$conditions[]=array('OR'=>array("js.contact_phone LIKE\"".$contact_phone."%\"",));
				$this->set('contact_phone',$data['contact_phone']);	
			}
			if(isset($data['account_email']) && !empty($data['account_email'])){			
				$account_email=addslashes(trim($data['account_email']));
				$conditions[]= "users.account_email LIKE \"".$account_email."%\"";
				$this->set('account_email',$data['account_email']);	
			}
			if(isset($data['address']) && !empty($data['address'])){
				$address=addslashes(trim($data['address']));	
				$conditions[]= array('OR'=>array("js.address LIKE\"".$address."%\"",
												"js.state LIKE\"".$address."%\"",
												"js.city LIKE\"".$address."%\"",));
				$this->set('address',$data['address']);	
			}
			if(isset($data['from_date']) && !empty($data['from_date'])){
				if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['from_date'])))){
		 			$conditions[]="date(PaymentHistory.paid_date) >='".date("Y-m-d",strtotime($data['from_date']))."'";
		 		}
	 			$this->set('from_date',$data['from_date']);
	 		}
		 	if(isset($data['to_date']) && !empty($data['to_date'])){
		 		if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['to_date'])))){
			 		$conditions[]="date(PaymentHistory.paid_date) <='".date("Y-m-d",strtotime($data['to_date']))."'";
			 	}
		 		$this->set('to_date',$data['to_date']);
		 	}
		 }
		$this->paginate = array('conditions' =>isset($conditions)?$conditions:true,
								'limit'=>'10', 	
								'joins'=>array(
											array('table'=>'users',
												  'type'=>'LEFT',
												  'conditions'=>array('users.id=PaymentHistory.jobseeker_user_id'),
												 ),
										 	array('table'=>'jobseekers',
												  'alias'=> 'js',
												  'type'=>'LEFT',
												  'conditions'=>array('js.user_id =PaymentHistory.jobseeker_user_id'),
												 ),
											   ),
								'fields'=>array('PaymentHistory.user_id,PaymentHistory.paid_date,js.contact_name,
												js.contact_phone,js.address,js.city,js.state,users.account_email'),
								'order'=>'PaymentHistory.paid_date desc'
								);
		$employees = $this->paginate("PaymentHistory");
		$this->set('employees',$employees);
		$this->set('activejobCount',$this->getCompanyActiveJobsCount());
		$this->set('archJobCount',$this->getCompanyArchiveJobsCount());
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

	function jobseekerFilledProfile(){
		$jobseekerApplyProfile=array();
		$this->autoRender= false ;
		$jobseekerApplyId= $this->params['form']['jobseekerId'];
		if(isset($jobseekerApplyId)){
		
		$jobseekerApplyProfile=$this->JobseekerApply->find('first',array('conditions'=>"JobseekerApply.id=$jobseekerApplyId",
																			'joins'=>array(
																  				array(
																  					'table'=>'universities',
																  		 			'type'=>'left',
																  		 			'alias'=>'uns',
															'conditions'=>'uns.id=JobseekerApply.answer6'
																  )),
																'fields'=>'JobseekerApply.*,uns.*',
															));
			$jobtypes = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary');
			
			$jap['qualificaiton'] = $jobseekerApplyProfile['JobseekerApply']['answer1'];
			$jap['experience'] = $jobseekerApplyProfile['JobseekerApply']['answer2'];
			$jap['ctc_current'] = $jobseekerApplyProfile['JobseekerApply']['answer3'];
			$jap['ctc_expected'] = $jobseekerApplyProfile['JobseekerApply']['answer4'];
			$jap['job_type'] = $jobtypes[$jobseekerApplyProfile['JobseekerApply']['answer5']];
			$jap['university'] = $jobseekerApplyProfile['uns']['name'];
			$jap['shifts_available'] = $jobseekerApplyProfile['JobseekerApply']['answer7'];
			$jap['passport_availability'] = $jobseekerApplyProfile['JobseekerApply']['answer8'];
			$jap['travel_availability'] = $jobseekerApplyProfile['JobseekerApply']['answer9'];
			$jap['training_needs'] = $jobseekerApplyProfile['JobseekerApply']['answer10'];
			return json_encode($jap);
		}
	
	
	}
	
	function invitations() {
 	 	$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
	
		$userId = $session->getUserId();		$traceId = -1;
		/*** code for networker trac **/
        if($userId){
            if($this->userRole == COMPANY){
            	$code=$this->Utility->getCode($traceId,$userId);
                $this->set('intermediateCode',$code);
            }
            if(isset($code)&&!empty($code)){
            	//$inviteUrl=Configure::read('httpRootURL').'?intermediateCode='.$code;
		       	$this->set('invitationCode',$code);
		    }   	
        }
		//$this->set('invitationCode',null);
		
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

