<?php
class AdminController extends AppController {

    var $uses = array('Companies','User','ArosAcos','Aros','PaymentHistory','Networkers','Invitation','PointLabels',
    					'UserList','Config','Job','JobseekerApply','RewardsStatus','Jobseeker','NetworkersTitle',
    					'GraduateUniversityBreakdown','University',);
	var $helpers = array('Form','Number','Time','Paginator','Js');
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus', 'Acl', 'TrackUser', 'Utility','RequestHandler');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect('/users/login');
		}
		if($this->userRole!=ADMIN){
			$this->redirect("/users/loginSuccess");
		}
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('config');
		$this->Auth->allow('companyjobdetail');	
		$this->Auth->allow('companiesList');
		$this->Auth->allow('employer');
		$this->Auth->allow('employerSpecificData');	
		$this->Auth->allow('fetchRewardTimeGraph');
		$this->Auth->allow('filterPayment');
		$this->Auth->allow('index');
		$this->Auth->allow('jobseekerSpecificData');
		$this->Auth->allow('jobseeker');
		$this->Auth->allow('networkerData');
		$this->Auth->allow('networkerSpecificData');
		$this->Auth->allow('paymentDetails');
		$this->Auth->allow('rewardPayment');
		$this->Auth->allow('userAction');
		$this->Auth->allow('updatePaymentStatus');
		$this->Auth->allow('userList');
		$this->Auth->allow('employerLoginStatus');
		$this->Auth->allow('processCompanyRequest');
		$this->Auth->allow('jobs');
		$this->Auth->allow('jobSpecificData');
		$this->Auth->allow('points');
		$this->Auth->allow('editPointsLevelInfo');			
		$this->Auth->allow('rewardPoint');
		$this->Auth->allow('usersInvitations');	
		$this->layout = "admin";
	}
	
	/****	Admin default view	***/
	function index(){

	}

	/****	listing companies to accept/decline registration request	***/
	function companiesList() {
		$this->paginate=array(
			'fields' => array('Companies.id',
				'Companies.user_id',
				'Companies.contact_name',
				'Companies.contact_phone',
				'Companies.company_name',
				'Companies.company_url',
				'Companies.act_as',
				'User.account_email',
				'User.created'
			),
			'joins' => array(
				array('table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions'=> array('User.id = Companies.user_id',"User.is_active=0")
					),
			),
			'limit'=>10,
		);
		$Companies = $this->paginate('Companies');
		$this->set('Companies',$Companies);		
	}
	
	/**** Accept/Decline company request ****/
	function processCompanyRequest(){
	
		$id = $this->params['id'];
		$process = $this->params['process'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id,'User.is_active'=>'0')));
		
		if($user){
			if($process=='accept'){
				$user['User']['is_active'] = '1';
				$user['User']['confirm_code']="";
				$aros = $this->Aros->find('first',array('conditions'=>array('Aros.foreign_key'=>$id)));
				$arosAcosData['aro_id'] = $aros['Aros']['id'];
				$arosAcosData['aco_id'] = 47;
				$arosAcosData['_create'] = 1;
				$arosAcosData['_read'] = 1;						
				$arosAcosData['_update'] = 1;
				$arosAcosData['_delete'] = 1;	
				// activate user's account
				if(!$this->Utility->setNetworkerPoints($user )){
					$this->Session->setFlash('Internal error.', 'error');
					$this->redirect("/admin/companiesList");
				}
				if($this->ArosAcos->save($arosAcosData)){
					$this->saveCompanyStatus($user['User'],$process);
				}else{
					$this->Session->setFlash('Internal error.', 'error');
					$this->redirect("/admin/companiesList");
				}
			}else{
				$user['User']['is_active'] = '2';
				$this->saveCompanyStatus($user['User'],$process);
			}
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
		}
		$this->redirect("/admin/companiesList");
	}
	
	/**** To save company status Activated/Deactivated ****/
	private function saveCompanyStatus($userData,$process){
	
 		if($this->User->save($userData)){
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userData['id'])));
			$to = $user['User']['account_email'];
			$subject = 'Hire Routes : '.$process.' Account Request';
			$template = 'company_account_'.$process;
			$message = $user['User'];
			$this->sendEmail($to,$subject,$template,$message);		
			$this->Session->setFlash('User has been '.$process.'ed.', 'success');
		}else{
			$this->Session->setFlash('Internal error.', 'error');
			$this->redirect("/admin/companiesList");
		}
		return true;
	}
		
	
	/**
	 * For payment details 
	 */
	function paymentDetails()
	{
		$payment_detail = $this->PaymentHistory->find('first',array(
			'fields'=>array('PaymentHistory.*', 'Company.*', 'CompanyUser.account_email',
				'Jobseeker.user_id', 'Jobseeker.contact_name', 'JobseekerUser.account_email',
				'JobseekerUser.parent_user_id', 
				'Job.title', 'JobseekerApply.intermediate_users', 'RewardsStatus.status'
			),
			'recursive'=>-1,
			'order' => array('paid_date' => 'desc'),
			'joins'=>array(
				array(
					'table'=>'jobs',
					'alias'=>'Job',
					'type'=>'left',
					'fields'=>'id, title',
					'conditions'=>'Job.id = PaymentHistory.job_id'
				),
				array(
					'table'=>'companies',
					'alias'=>'Company',
					'type'=>'left',
					'fields'=>'id, company_name, contact_phone, company_url, Company.user_id',
					'conditions'=>'Job.company_id = Company.id'
				),
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
					'fields'=>'user_id, contact_name',
					'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id'
				),
				array(
					'table'=>'users',
					'alias'=>'JobseekerUser',
					'type'=>'left',
					'fields'=>'id, account_email',
					'conditions'=>'JobseekerApply.user_id = JobseekerUser.id'
				),
				array(
					'table'=>'users',
					'alias'=>'CompanyUser',
					'type'=>'left',
					'fields'=>'id, account_email',
					'conditions'=>'Company.user_id = CompanyUser.id'
				),
				array(
					'table'=>'rewards_status',
					'alias'=>'RewardsStatus',
					'type'=>'inner',
					'conditions'=>'RewardsStatus.user_id = Jobseeker.user_id AND 
						RewardsStatus.payment_history_id = PaymentHistory.id'
				)
			),			
			'conditions'=>array('PaymentHistory.id'=>$this->params['payment_history_id'], 
				'JobseekerApply.is_active'=>'1'
			)
		));
		
		if(empty($payment_detail)){
			$this->Session->setFlash('You click on old link or entered manually.','error');
			$this->redirect('/admin/rewardPayment/');
		}
		
		$networker_ids=explode(',',$payment_detail['JobseekerApply']['intermediate_users']);
		if($payment_detail['PaymentHistory']['scenario']==2){
				$networker_ids[] = $payment_detail['JobseekerUser']['parent_user_id'];
		}
		
		$this->paginate=array(
			'fields'=>'Networkers.user_id, contact_name, RewardsStatus.status, User.account_email',
			'recursive'=>'-1',
			'joins'=>array(
				array(
					'table'=>'users',
					'alias'=>'User',
					'fields'=>'id, account_email',
					'type'=>'inner',
					'conditions'=>'User.id = Networkers.user_id'
				),
				array(
					'table'=>'rewards_status',
					'alias'=>'RewardsStatus',
					'type'=>'inner',
					'conditions'=>'RewardsStatus.user_id = Networkers.user_id AND RewardsStatus.payment_history_id = '.$payment_detail['PaymentHistory']['id']
				)
			),
			'conditions'=>array('Networkers.user_id'=>$networker_ids),
			'limit'=>10
		);
		$networkers=$this->paginate('Networkers');
		
		$this->set('payment_detail',$payment_detail);
		$this->set('networkers',$networkers);
	}
	
	/**
	 * For Update payment information
	 */
	 
	function updatePaymentStatus()
	{
		$this->autoRender=false;
		$this->RewardsStatus->updateAll(array('status'=>1),$this->params['form']);
		return $this->RewardsStatus->getAffectedRows();
	}
	
	/*
	* Show all types of user list
	*/
	function userList(){

		$conditions[]='UserList.confirm_code=""';
		/*Retrive data form url on paginator click*/	
		if(isset($this->params['named'])){
			$data=$this->params['named'];
		}
		/*Retrive data on form submit */
		if(isset($this->params['url']['find'])){
			$data=$this->params['url'];
		}
		if(isset($data)){
			if(isset($data['contact_name']) && !empty($data['contact_name'])){
				$contact_name=addslashes(trim($data['contact_name']));
				$conditions[]=array('OR'=>array("Jobseekers.contact_name LIKE\"".$contact_name."%\"",
	   								 		    "Networkers.contact_name LIKE\"".$contact_name."%\"",
    						   					"Companies.contact_name LIKE\"".$contact_name."%\"",
	   								));
				$this->set('contact_name',$data['contact_name']);	
			}
			if(isset($data['contact_phone']) && !empty($data['contact_phone'])){			
				$contact_phone=addslashes(trim($data['contact_phone']));
				$conditions[]=array('OR'=>array("Jobseekers.contact_phone LIKE\"".$contact_phone."%\"",
	   						   					"Networkers.contact_phone LIKE\"".$contact_phone."%\"",
	   						   					"Companies.contact_phone LIKE\"".$contact_phone."%\"",
	   						   		));				
				$this->set('contact_phone',$data['contact_phone']);
			}
			if(isset($data['account_email']) && !empty($data['account_email'])){			
				$contact_email=addslashes(trim($data['account_email']));			
				$conditions[]= "UserList.account_email LIKE \"".$contact_email."%\"";
				$this->set('account_email',$data['account_email']);	
			}
			if(isset($data['from_date']) && !empty($data['from_date'])){
				if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['from_date'])))){
					$conditions[]="date(UserList.created) >='".date("Y-m-d",strtotime($data['from_date']))."'";
		 			$this->set('from_date',$data['from_date']);
		 		}
	 		}
		 	if(isset($data['to_date']) && !empty($data['to_date'])){
		 		if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['to_date'])))){
			 		$conditions[]="date(UserList.created) <='".date("Y-m-d",strtotime($data['to_date']))."'";
			 		$this->set('to_date',$data['to_date']);
			 	}
		 	}
		 	if(isset($data['isActivated'])){
		 		switch($data['isActivated']){
		 			case "deactivated":
		 					$conditions[]="UserList.is_active=0";
		 					break;
		 			case "activated":
					 		$conditions[]="UserList.is_active=1";		 				
					 		break;
					 default:
					 		$conditions[]=array("UserList.is_active"=>array(1,0));					 
	 		
		 		}
		 		$this->set('isActivated',$data['isActivated']);
		 	}
		 }
		$filterRoleCond = null;
		$filter=null;
		$userFilter = 'Companies.*,Jobseekers.*,Networkers.*';

		if(isset($data['filter']) && !empty($data['filter']) ){
			switch($data['filter']){
				case 'company':
						$userFilter = 'Companies.*';
						$filterRoleCond = array('UserRoles.role_id'=>COMPANY);
						break;
				case 'jobseeker':
						$userFilter = 'Jobseekers.*';
						$filterRoleCond = array('UserRoles.role_id'=>JOBSEEKER);
						break;
				case 'networker':
						$userFilter = 'Networkers.*';
						$filterRoleCond = array('UserRoles.role_id'=>NETWORKER);
						break;
				default:
						$this->Session->setFlash('You click on old link or entered manually.','error');
						$this->redirect('/admin/userList');
			}
		}
		$this->set('filter',isset($data['filter'])?$data['filter']:null);		
		$this->paginate =array('limit' =>10,
	   						   'conditions' => array($filterRoleCond,
	   						   						"AND"=>array($conditions),	
	   						   					    'NOT'=>array('UserList.id'=>array(1,2),'UserRoles.role_id'=>5),	
	   						   						),
							   'fields' => array("UserList.account_email,UserList.id,
							   					UserList.created,UserList.last_login,
							   					UserList.last_logout,UserList.fb_user_id,UserList.is_active,
							   					UserRoles.*,$userFilter"),
							   'order' => array('UserList.created' => 'desc'),
							  );	

		$users= $this->paginate('UserList');
		$userArray = array();
		foreach($users as $key=>$value){
			$role_id = isset($value['UserRoles']['role_id'])?$value['UserRoles']['role_id']:false;
			if($role_id){
				switch($role_id){
					case COMPANY:
							$role = 'Company';
							$table= "Companies";
							break;
					case JOBSEEKER:
							$role = 'Jobseeker';
							$table= "Jobseekers";
							break;
					case NETWORKER:
							$role = 'Networker';
							$table= "Networkers";
							break;
					default:
							$table="";
							$role="";
				}
				$userArray[$key]['id'] = $value['UserList']['id'];
				$networkers = $this->getLevelInformation($value['UserList']['id']);
				$userArray[$key]['networkCount']=0;
				if(isset($networkers)){
					foreach($networkers as $index=>$userCount){
					$userArray[$key]['networkCount']=$userArray[$key]['networkCount'] + $userCount;
					}
				}
				$userArray[$key]['role_id'] = $role_id;
				$userArray[$key]['role'] = $role;
				$userArray[$key]['account_email'] = $value['UserList']['account_email'];
				$userArray[$key]['created'] = date("m/d/Y h:m:s", strtotime($value['UserList']['created']));
				$userArray[$key]['is_active'] = $value['UserList']['is_active'];
				$userArray[$key]['last_login'] = $value['UserList']['last_login'];
				$userArray[$key]['last_logout'] = $value['UserList']['last_logout'];				
				if(isset($value[$table])){
					$userArray[$key]['contact_name'] = $value[$table]['contact_name'];
					$userArray[$key]['contact_phone'] = $value[$table]['contact_phone'];
				}else{
					$userArray[$key]['contact_name'] = "";
					$userArray[$key]['contact_phone'] = "";
				}
			}
		}
		$this->set('userArray',$userArray);	
	}
		
	function userAction(){
		$this->autoRender=false;
		$userId = isset($this->params['form']['userId'])?$this->params['form']['userId']:"";
		$is_active=isset($this->params['form']['action'])?$this->params['form']['action']:"";
		if(isset($userId) && isset($is_active)){
			$userData =$this->User->find('first',array('conditions'=>array("User.id"=>$userId,
																		'NOT'=>array("User.group_id"=>array(1,2)))));
			if(isset($userData)){
				$userData['User']['id']=$userId;
				$userData['User']['is_active'] =$is_active;
				if($this->User->save($userData)){
					$is_active==0?$this->Session->setFlash('User De-activated successfully','success'):
					$this->Session->setFlash('User Activated successfully','success');
					return ;
				}else{
					$this->Session->setFlash('Internal error occurs.','error');
					return ;
				}	
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
				return ;
			}
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
			return ;
		}		
	}
	
	function config(){
		
	}
	
	function rewardPayment(){
		
	    if(isset($this->data['Config'])){
	   	    $i = 1;
	   	    $validFlag= true;
	   	    $cdarray= array();
	   	    $sumOfSenario=0;
	    	foreach($this->data['Config'] as $key=>$value) {
				$cdarray[$i]['id'] = $i;
				$cdarray[$i]['key'] = $key;
				$cdarray[$i]['value'] = $value;
				$sumOfSenario =$cdarray[$i]['value']+$sumOfSenario;
				if($i%3==0 ){
					if($sumOfSenario != 100 ){
						$this->set("rp_error","Sum for scenario-".($i/3)." should be 100.");
						$this->set('scenario',$i/3);
						$validFlag=false;
						break;
					}
					$sumOfSenario=0;
				}
				$i++;
			}
			if($validFlag){ 
				$this->Config->saveAll($cdarray);
				$this->Session->setFlash('The Reward Configuration have been updated.', 'success');	    		
			}
	    }
	    $params = array(
				   'conditions' => array('Config.id'=>array(1,2,3,4,5,6,7,8,9)), 
				   'fields' => array('Config.id','Config.value')
				   );
		$configuration = $this->Config->find('list',$params);
		$senarioSum=$this->PaymentHistory->find('all',array(
												'fields' =>'scenario , sum( (hr_reward_percent *amount) /100) as hr_amount , sum((amount*networker_reward_percent)/100)  as nr_amount, sum((jobseeker_reward_percent*amount ) /100 ) as js_amount',
												'group'=> 'scenario',
												));
		$i=1;												
		foreach($senarioSum as $key => $element){
			$configuration['scenario'][$i++]= $element[0]["nr_amount"];
			$configuration['scenario'][$i++]= $element[0]["hr_amount"];
			$configuration['scenario'][$i++]= $element[0]["js_amount"];						
		}												
												
		$this->set('configuration',$configuration);
			
		/****	Employer Payment Details 	***/
		if(isset($this->params['named'])){
			$data=$this->params['named'];
		}
		/*Retrive data on form submit */
		if(isset($this->params['url']['find'])){
			$data=$this->params['url'];
		}	
		$conditions[]='JobseekerApply.is_active=1';
		if(isset($data['from_date']) && !empty($data['from_date'])){
			if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['from_date'])))){
				$conditions[]="date(paid_date) >='".date("Y-m-d",strtotime($data['from_date']))."'";
		 	}	
	 		$this->set('from_date',$data['from_date']);
	 	}
	 	if(isset($data['to_date']) && !empty($data['to_date'])){
			 if($this->Utility->checkDateFormat(date("Y-m-d",strtotime($data['to_date'])))){	
	 			$conditions[]="date(paid_date) <='".date("Y-m-d",strtotime($data['to_date']))."'";
	 		}
	 		$this->set('to_date',$data['to_date']);
	 	}
	
		$this->paginate = array(
			'fields'=>'DISTINCT PaymentHistory.id, Company.user_id, Company.company_name, 
				Jobseeker.contact_name, Job.title, Job.created, PaymentHistory.amount, 
				PaymentHistory.paid_date, PaymentHistory.transaction_id, User.id, User.account_email, 
				User.last_login,User.last_logout',
			'recursive'=>'-1',
			'order' => array('paid_date' => 'desc'),
			'joins'=>array(
				array(
					'table'=>'jobs',
					'alias'=>'Job',
					'type'=>'left',
					'fields'=>'id, title',
					'conditions'=>'Job.id = PaymentHistory.job_id'
				),
				array(
					'table'=>'companies',
					'alias'=>'Company',
					'type'=>'left',
					'fields'=>'id,user_id,company_name',
					'conditions'=>'Job.company_id = Company.id'
				),
				array(
					'table'=>'jobseeker_apply',
					'alias'=>'JobseekerApply',
					'type'=>'inner',
					'fields'=>'user_id, is_active',
					'conditions'=>'PaymentHistory.job_id = JobseekerApply.job_id AND 
						PaymentHistory.jobseeker_user_id=JobseekerApply.user_id'
				),
				array(
					'table'=>'jobseekers',
					'alias'=>'Jobseeker',
					'type'=>'left',
					'fields'=>'user_id, contact_name',
					'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id'
				),
				array(
					'table'=>'users',
					'alias'=>'User',
					'type'=>'left',
					'conditions'=>'User.id = Company.user_id'
				)
			),
			'order'=>'paid_date desc',
			'limit'=>10,
			'conditions'=>isset($conditions)?$conditions:true
		);
		try{
			//Create virtual field to perform sorting
			$this->PaymentHistory->virtualFields['employer'] = 'Company.company_name';
			$this->PaymentHistory->virtualFields['jobTitle'] = 'Job.title';
			$this->PaymentHistory->virtualFields['datePosted'] = 'Job.created';
			$paymentHistories=$this->paginate('PaymentHistory');
			
			$this->set('paymentHistories',$paymentHistories);
		}catch(Exception $e){
			$this->Session->setFlash("Server Problem!",'ERROR');
		}
	}
	
	function fetchRewardTimeGraph(){
		/***	Graph data	***/
		$this->autoRender=false;
	    $year = $this->params['form']['yearReward']; 
	    $graphParams = array(
	    	'conditions' => array('YEAR(PaymentHistory.paid_date)'=>$year), 
			'fields' => array('MONTH(PaymentHistory.paid_date) As month', 
				'sum(PaymentHistory.amount) as reward'
			),
			'group' => 'MONTH(PaymentHistory.paid_date)',
		);
		$graphData = $this->PaymentHistory->find('all',$graphParams);
		$months = array(
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec'
                );
		$gdarray=array();
		if(!empty($graphData)){
			foreach($graphData as $kuch_v){
				$gdarray[$kuch_v[0]['month']] = $kuch_v[0]['reward']/1000; 
			}
		}

		$result = array();
		foreach($months as $k=>$v){
			if(in_array($k,array_keys($gdarray))){
				$result[] = $gdarray[$k];
			}	
			else{
				$result[] = 0;
			}
		}
		return json_encode(array('data'=>$result,'year'=>$year));
	}
	
	function jobseekerSpecificData(){
		if(isset($this->params['id'])&&$this->params['id']>2){
			$jobseekerData=$this->Jobseeker->find(
				'first',array(
					'recursive'=>'-1',
					'joins'=>array(
						array(
							'table'=>'users',
							'alias'=>'User',
							'type'=>'INNER',
							'conditions'=>'User.id = Jobseeker.user_id'
						),
						array(
							'table'=>'jobseeker_apply',
							'alias'=>'JobseekerApply',
							'type'=>'LEFT',
							'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id'
						),
						array(
							'table'=>'jobseeker_profile',
							'alias'=>'JobseekerProfile',
							'type'=>'LEFT',
							'conditions'=>'JobseekerProfile.user_id = Jobseeker.user_id'
						),
						array(
							'table'=>'universities',
							'alias'=>'University',
							'type'=>'LEFT',
							'conditions'=>'University.id = JobseekerProfile.answer6'
						)
					),
					'conditions'=>array(
						'Jobseeker.user_id'=>$this->params['id']
					),
					'fields'=>'Jobseeker.*, User.account_email, JobseekerProfile.*, University.name,
						count(JobseekerApply.id) as appliedJob'
				)
			);
			if(empty($jobseekerData['Jobseeker']['user_id'])){
				$this->Session->setFlash('You may be clicked on old link or entered manually.','error');
				$this->redirect('/admin/');
			}
			$jobsData=null;
			if($jobseekerData['0']['appliedJob']>0){
				$this->paginate=array(
					'joins'=>array(
						array(
							'table'=>'jobseeker_apply',
							'alias'=>'JobseekerApply',
							'type'=>'INNER',
							'conditions'=>'JobseekerApply.job_id = Job.id 
								AND JobseekerApply.user_id ='.$jobseekerData['Jobseeker']['user_id']
						),
						array(
							'table'=>'jobseeker_apply',
							'alias'=>'applyCount',
							'type'=>'LEFT',
							'conditions'=>'applyCount.job_id = Job.id' 
						),
						array(
							'table'=>'job_views',
							'alias'=>'JobView',
							'type'=>'LEFT',
							'conditions'=>'JobView.job_id = Job.id'
						),
						array(
							'table'=>'industry',
							'alias'=>'Industry',
							'type'=>'LEFT',
							'conditions'=>'Industry.id = Job.industry'
						),
						array(
							'table'=>'specification',
							'alias'=>'Specification',
							'type'=>'LEFT',
							'conditions'=>'Specification.id = Job.specification'
						),
						array(
							'table'=>'states',
							'alias'=>'State',
							'type'=>'LEFT',
							'conditions'=>'State.id = Job.state'
						),
						array(
							'table'=>'cities',
							'alias'=>'City',
							'type'=>'LEFT',
							'conditions'=>'City.id = Job.city'
						),
					),
					'conditions'=>'Job.is_active=1',
					'limit'=>10,
					'fields'=>'Job.id, Job.title, Job.reward, City.city, State.state, Industry.name, 
						Specification.name, Job.created, count(DISTINCT applyCount.id) as applicants, 
						count(DISTINCT JobView.id) AS views',
					'group'=>'Job.id'
				);
				$jobsData = $this->paginate('Job');
			}
			$this->set('jobsData',$jobsData);
			$this->set('jobseekerData',$jobseekerData);
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered manually.','error');
			$this->redirect('/admin/');
		}
	}
		

	function networkerData(){
		$level=1;
		if(isset($this->params['named']['level'])&&!empty($this->params['named']['level'])){
			if(preg_match('/^[0-9]+$/',$this->params['named']['level'])){
				$level=$this->params['named']['level'];
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
			}
		}
		$levelInformation=$this->getLevelInformation();
		if(!empty($levelInformation)&&count($levelInformation)<$level){
			$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
			$level=1;
		}
		$networkersData=$this->getNetworkersData($level);
		$this->set('selectedLevel',$level);
		$this->set('levelInformation',$levelInformation);
		$this->set('networkersData',$networkersData);
	}
	
	function networkerSpecificData(){
		if(isset($this->params['id'])&&$this->params['id']>2){
			$level=1;
			if(isset($this->params['named']['level'])&&!empty($this->params['named']['level'])){
				if(preg_match('/^[0-9]+$/',$this->params['named']['level'])){
					$level=$this->params['named']['level'];
				}else{
					$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
				}
			}
			$networkerData=$this->getNetworkersData(0,$this->params['id']);
			if(!isset($networkerData)||empty($networkerData)){
				$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
				$this->redirect('/admin/networkerData');
			}else{
				$networkersLevelInfo=$this->getLevelInformation($this->params['id']);
				if(!empty($networkersLevelInfo) && count($networkersLevelInfo)<$level){
					$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
					$level=1;
				}
				$networkersNetworkerData = $this->getNetworkersData($level,$this->params['id']);
				$originData=null;
				if($networkerData[0]['origin']==RANDOM){
					$cond=true;
					$userId=$networkerData[0]['User']['id'];
					$originsData=null;
					while($cond){
						$originsData=$this->User->find(
							'first',array(
								'fields'=>'User.id, User.parent_user_id, Parent.account_email, 
									Company.company_name, Company.id, Networker.contact_name',
								'recursive'=>'-1',
								'joins'=>array(
									array(
										'table'=>'companies',
										'alias'=>'Company',
										'type'=>'LEFT',
										'conditions'=>'Company.user_id=User.parent_user_id'
									),
									array(
										'table'=>'networkers',
										'alias'=>'Networker',
										'type'=>'LEFT',
										'conditions'=>'Networker.user_id=User.parent_user_id'
									),
									array(
										'table'=>'users',
										'alias'=>'Parent',
										'type'=>'LEFT',
										'conditions'=>'Parent.id=User.parent_user_id'
									),
								),
								'conditions'=>array(
									'User.id'=>$userId,
								)
							)
						);
						$originData[]=$originsData;
						$userId=$originsData['User']['parent_user_id'];
						if(!empty($originsData['Company']['id'])
							|| $originsData['User']['parent_user_id']==NULL)
							$cond=false;
					}
				}else{
					if($networkerData[0]['origin']===HR){
						$originData[]="Hire Routes";
					}else{
						$originData[]=$networkerData[0]['origin'];
					}
				}
				$this->set('networkerData',$networkerData[0]);
				$this->set('selectedLevel',$level);
				$this->set('networkersLevelInfo',$networkersLevelInfo);
				$this->set('networkersNetworkerData', $networkersNetworkerData);
				$this->set('originData',$originData);
			}
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered manually.','error');
			$this->redirect('/admin/networkerData');
		}
	}
	
	function usersInvitations()
	{	
		if(isset($this->params['id'])){
			$this->paginate=array(
				'limit'=>10,
				'conditions'=>array('user_id'=>$this->params['id'], 'status'=>1,),
				'order'=>'created desc'
			);
			$invitations=$this->paginate('Invitation');
			$this->set('invitations',$invitations);
		}else{
			$this->set('invitations',"");
		}
	}
	
	private function getLevelInformation($userId=NULL){
		if(empty($userId)){
			$cond=array('OR'=>array(
								'User.parent_user_id IS NULL',
								'User.parent_user_id = Company.user_id'
							)
						);
			$joins=array(
						array(
							'table'=>'companies',
							'alias'=>'Company',
							'fields'=>'Company.user_id',
							'type'=>'left',
							'conditions'=>'Company.user_id = User.parent_user_id'
						),
						array(
							'table'=>'networkers',
							'alias'=>'Networkers',
							'fields'=>'id',
							'type'=>'inner',
							'conditions'=>'User.id = Networkers.user_id'
						)
					);
		}else{
			$cond=array('User.parent_user_id'=>$userId);
			$joins=array(
						array(
							'table'=>'networkers',
							'alias'=>'Networkers',
							'fields'=>'id',
							'type'=>'inner',
							'conditions'=>'User.id = Networkers.user_id'
						)
					);
		}
		$Users = $this->User->find(
			'list',array('fields'=>'User.id', 'joins'=>$joins, 'conditions'=>$cond));
		if(count($Users)== 0){
			return null;
		}
  	    return array_merge(array(count($Users)),(array)$this->getlevelInformation($Users));
	}
	
	private function getNetworkersData($level, $userIds=NULL){
		for($level;$level>0;$level--){
			$userIds=$this->getRecursiveNetworkers($userIds);
		}
		$this->paginate=array(
			'fields'=>'User.id, User.parent_user_id, User.account_email, User.created,
				count(DISTINCT Jobseeker.id) as jobseekerCount, Networker.contact_name, 
				GraduateUniversity.name ,GraduateDegree.degree, Networker.points,
				Networker.notification, count(DISTINCT SharedJob.job_id) as sharedJobsCount, University.name',
			'recursive'=>-1,
			'joins'=>array(
				array(
					'table'=>'users',
					'alias'=>'JobseekerUser',
					'type'=>'LEFT',
					'conditions'=>'JobseekerUser.parent_user_id=User.id'
				),
				array(
					'table'=>'jobseekers',
					'alias'=>'Jobseeker',
					'type'=>'LEFT',
					'conditions'=>'Jobseeker.user_id=JobseekerUser.id'
				),
				array(
					'table'=>'networkers',
					'alias'=>'Networker',
					'type'=>'LEFT',
					'conditions'=>'Networker.user_id=User.id'
				),
				array(
					'table'=>'shared_jobs',
					'alias'=>'SharedJob',
					'type'=>'LEFT',
					'conditions'=>'SharedJob.user_id=User.id'
				),
				array(
					'table'=>'universities',
					'alias'=>'University',
					'type'=>'LEFT',
					'conditions'=>'Networker.graduate_university_id=University.id'
				),
				array(
					'table'=>'universities',
					'alias'=>'GraduateUniversity',
					'type'=>'LEFT',
					'conditions'=>'Networker.university=GraduateUniversity.id'
				),
				array(
					'table'=>'graduate_degrees',
					'alias'=>'GraduateDegree',
					'type'=>'LEFT',
					'conditions'=>array('GraduateDegree.id=
					Networker.graduate_degree_id'),
				),
				
			),
			'conditions'=>array(
				'User.id'=>$userIds
			),
			'group'=>'User.id',
			'limit'=>10,
			'order'=>'User.created desc'
		);
		//Add virtual fields to sort data
		$this->User->virtualFields['jobseekerCount'] = 'count(DISTINCT Jobseeker.id)';
		$this->User->virtualFields['sharedJobsCount'] = 'count(DISTINCT SharedJob.job_id)';
		$this->User->virtualFields['notification'] = 'Networker.notification';
		$this->User->virtualFields['university'] = 'University.name';
		$this->User->virtualFields['points'] = 'Networker.points';
		$networkersData = $this->paginate('User');
													
		foreach($networkersData as $key => $value){
			//To get Networkers networker count
			$networkerslevelInformation=$this->getlevelInformation($networkersData[$key]['User']['id']);
			if(empty($networkerslevelInformation)){
				$networkersData[$key]['networkersCount'] =0;
			}else{
				$networkersData[$key]['networkersCount'] = array_sum($networkerslevelInformation);
			}
			$networkersData[$key]['level']=count($networkerslevelInformation);
			//End get Networkers networker count
			
			//To get Origin	
			if(empty($networkersData[$key]['User']['parent_user_id'])){
				$networkersData[$key]['origin']=0;
			}else{
				$company=$this->Companies->find(
					'first',array(
						'fields'=>'Companies.company_name', 
						'conditions'=>array(
							'Companies.user_id'=>$networkersData[$key]['User']['parent_user_id']
						)
					)
				);
				if(empty($company)){
					$networkersData[$key]['origin']=1;
				}else{
					$networkersData[$key]['origin']=$company['Companies']['company_name'];
				}
			}
			//End get Origin
			
			//To get Networkers Total Reward
			$reward = $this->RewardsStatus->find(
				'all',array(
					'conditions'=>array(
						'RewardsStatus.status'=>1,
						'RewardsStatus.user_id'=>$networkersData[$key]['User']['id']
					),
					'joins'=>array(
						array(
 							'table' => 'payment_history',
	 						'alias' => 'PaymentHistory',
	                        'type' => 'INNER',
	                        'conditions' => array('RewardsStatus.payment_history_id =PaymentHistory.id')
     					),
						array(
							'table' => 'jobseeker_apply',
	  						'alias' => 'JobseekerApply',
	  						'type' => 'INNER',
	  						'conditions' => array('PaymentHistory.applied_job_id = JobseekerApply.id 
	  							AND FIND_IN_SET('.$networkersData[$key]['User']['id'].', 
	  							JobseekerApply.intermediate_users)'
	  						)
     					),
					),
					'fields'=>array(
						'SUM(((PaymentHistory.amount)*(PaymentHistory.networker_reward_percent))
						/(substrCount(JobseekerApply.intermediate_users,",")*100)) as networker_reward'
					),
				)
			);
			if(empty($reward[0][0]['networker_reward'])){
				$networkersData[$key]['networkerRewards']=0;
			}else{
				$networkersData[$key]['networkerRewards']=$reward[0][0]['networker_reward'];
			}
		//End get Networkers Total Reward
			
		}
		return $networkersData;
	}
	
	private function getRecursiveNetworkers($userIds=NULL){
		if(empty($userIds)){
			$cond=array(
				'OR'=>array(
					'User.parent_user_id IS NULL',
					'User.parent_user_id = Company.user_id'
				)
			);
			$joins=array(
				array(
					'table'=>'companies',
					'alias'=>'Company',
					'fields'=>'Company.user_id',
					'type'=>'left',
					'conditions'=>'Company.user_id = User.parent_user_id'
				),
				array(
					'table'=>'networkers',
					'alias'=>'Networkers',
					'fields'=>'id',
					'type'=>'inner',
					'conditions'=>'User.id = Networkers.user_id'
				)
			);
		}else{
			$cond=array('User.parent_user_id'=>$userIds);
			$joins=array(
				array(
					'table'=>'networkers',
					'alias'=>'Networkers',
					'fields'=>'id',
					'type'=>'inner',
					'conditions'=>'User.id = Networkers.user_id'
				)
			);
		}
		$users= $this->User->find('list',array('fields'=>'User.id', 'joins'=>$joins, 'conditions'=>$cond ));
		return $users;
	}
	
	function employer(){
		$sortBy=null;
		if(isset($this->params['named']['sort'])&&!empty($this->params['named']['sort'])){
			$sortBy=$this->params['named']['sort'];
		}
		$this->paginate=array(
			'recursive'=>'-1',
			'joins'=>array(
				array(
					'table'=>'payment_history',
					'alias'=>'PaymentHistory',
					'type'=>'LEFT',
					'conditions'=>'Companies.user_id = PaymentHistory.user_id'
				),
				array(
					'table'=>'users',
					'alias'=>'User',
					'type'=>'inner',
					'conditions'=>'Companies.user_id = User.id AND User.is_active = 1'
				),
			),
			'limit'=>10,
			'fields'=>'Companies.user_id, Companies.contact_name, Companies.company_name, 
				Companies.company_url, User.id, User.account_email, User.created, User.last_login,User.last_logout, 
				count(DISTINCT PaymentHistory.job_id) as jobFilled, 
				sum(PaymentHistory.amount) as awardPaid',
			'group'=>'Companies.user_id',
			'order'=>'Companies.user_id desc'
		);
		
		$this->Companies->virtualFields['jobFilled'] = 'count(DISTINCT PaymentHistory.job_id)';
		$this->Companies->virtualFields['awardPaid'] = 'sum(PaymentHistory.amount)';
		$this->Companies->virtualFields['email'] = 'User.account_email';
		$this->Companies->virtualFields['created'] = 'User.created';
		$employers=$this->paginate('Companies');
		
		$user_ids=null;
		if(!empty($employers[0]))
		foreach($employers as $key=> $employer)
			$user_ids[]=$employer['Companies']['user_id'];
		$employersJobs=$this->Job->find(
			'all',array(
				'fields'=>'Job.user_id, count(Job.id) AS jobPosted, sum(Job.reward) AS awardPosted',
				'group'=>'Job.user_id',
				'conditions'=>array('Job.user_id'=>$user_ids)
			)
		);
		foreach($employers as $key=> $employer){
			foreach($employersJobs as $jobKey => $employerJobs){
				if($employerJobs['Job']['user_id']==$employer['Companies']['user_id']){
					$employers[$key][0]['jobPosted']=$employerJobs['0']['jobPosted'];
					$employers[$key][0]['awardPosted']=$employerJobs['0']['awardPosted'];
				}
			}
			if(!isset($employers[$key][0]['jobPosted'])){
				$employers[$key][0]['jobPosted']=0;
				$employers[$key][0]['awardPosted']=0;
			}
		}
		$this->set('sortBy',$sortBy);
		$this->set('employers',$employers);
	}


	/***		Ajax to refresh login status		***/
	function employerLoginStatus(){
		$this->autoRender = false;
		$ids = $this->params['form']['ids'];
		$employers =  $this->User->find('all', array(
												'fields' => 'User.id,User.last_login,User.last_logout',
												'recursive'=>-1,
												'conditions' =>array('User.id' =>$ids),
												)
										);
										
		foreach($employers AS $emp){
			$l1 = strtotime($emp['User']['last_login']);
			$l2 = strtotime($emp['User']['last_logout']);
			$result[$emp['User']['id']] = array('last_login'=>$l1, 'last_logout'=>$l2);
		}
		return json_encode(array('data'=>$result));
	}

	/* * *	* * *	* * *	* * *	* * */
	
	public function employerSpecificData(){
		if(isset($this->params["companyId"])){
			$companyId = $this->params["companyId"];
			$companyDetail = $this->UserList->find(
				'first',array(
					'conditions'=>array(
						'UserList.is_active'=>1,
						'UserList.id'=>$companyId,
						'UserRoles.role_id'=>1,
					),
					'fields'=>array(
						'UserList.id','UserList.account_email','UserList.last_login','Companies.*' 
					),					  
				)
			);
			$companyDetail['activeJobCount'] = $this->Job->find(
				'count',array('conditions'=>array('Job.user_id'=>$companyId,'Job.is_active'=>1))
			);
		
			$companyDetail['archJobCount']= $this->Job->find(
				'count',array('conditions'=>array('Job.user_id'=>$companyId,'Job.is_active'=>array(0)))
			);
			
			$appliedJobCount=$this->Job->find(
				'all',array(
					'conditions'=>array('Job.user_id'=>$companyId),
					'joins'=>array( 
						array(
							'table' => 'jobseeker_apply',
							'alias' => 'JobseekerApply',
							'type' => 'inner',
							'conditions'=> 'JobseekerApply.job_id=Job.id', 
						),
					),
					'fields'=>array('COUNT(distinct(Job.id)) as appliedJobCount',)
				)
			);	
															
			$companyDetail['appliedJobCount'] =$appliedJobCount[0][0]['appliedJobCount'];
			
			$PaymentHistory =$this->PaymentHistory->find(
				'all', array(
					'conditions' =>array('user_id'=>$companyId),
					'fields'=>array('sum(amount) as totalPaidReward '),
				)
			);
			
			$totalRewards= $this->Job->find(
				'all',array(
					'conditions' =>array('user_id'=>$companyId),
					'fields'=>array('sum(reward) as totalReward '),
				)
			);
			$this->paginate =array(
					'conditions'=>array('Job.user_id'=>$companyId),
					'limit'=>'10',
					'joins'=>array(
						array(
							'table'=>'job_views',
							'alias'=>'JobViews',
							'type'=>'LEFT',
							'conditions'=>'JobViews.job_id=Job.id',
						),
						array(
							'table' => 'jobseeker_apply',
							'alias' => 'JobseekerApply',
							'type' => 'LEFT',
							'conditions' => 'JobseekerApply.job_id=Job.id '
						),
					),
					
					'fields'=>'Job.id, Job.user_id, Job.reward, Job.title, Job.created, Job.is_active, 
						COUNT(DISTINCT(JobseekerApply.id)) AS submission,
						COUNT(DISTINCT(JobViews.id)) as views',
					'group'=>array('Job.id'),
				);				
			$this->Job->virtualFields['submission'] = 'COUNT(DISTINCT(JobseekerApply.id))';
			$this->Job->virtualFields['views'] = 'COUNT(DISTINCT(JobViews.id))';
			$jobs = $this->paginate("Job");
			if(isset($companyDetail['Companies'])  && isset($jobs)){
			    $this->set('totalRewards',$totalRewards[0][0]['totalReward']);
			    $this->set('totalPaidReward',$PaymentHistory[0][0]['totalPaidReward']);
			    $this->set('jobs',$jobs);
				$this->set('companyDetail',$companyDetail);
			}else{
			    $this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
			    $this->redirect("/admin/rewardPayment");
			}
		}else{
			$this->Session->setFlash("You may be clicked on old link or entered manually.","error");
			$this->redirect("/admin/rewardPayment");
		}
	}	
	
	function companyjobdetail(){
		$this->autoRender= false ;
		$jobId = isset($this->params['form']['jobId'])?$this->params['form']['jobId']:"";
		$jobDetail = $this->Job->find(
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
						'table' => 'companies',
					    'alias' => 'comp',
					    'type' => 'LEFT',
					    'conditions' => array('Job.company_id = comp.id',)
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
				'fields'=>'Job.id, Job.user_id, Job.title, Job.company_id, comp.company_name, city.city, 
					state.state, Job.job_type, Job.short_description, Job.reward, Job.created, 
					Job.salary_from, Job.salary_to, Job.description, ind.name as industry_name, 
					spec.name as specification_name, comp.company_url'
			)
		);
		
		$jobtypes = array(
			'1'=>'Full Time',
			'2'=>'Part Time',
			'3'=>'Contract',
			'4'=>'Internship',
			'5'=>'Temporary'
		);
		if(isset($jobDetail['Job']['id'])){
			$jobDetail['Job']['job_type']=$jobtypes[$jobDetail['Job']['job_type']];
			$jobDetail['error']=false;
			return json_encode($jobDetail);
		}else{
			$error=array('error'=>true,'message'=>'You may be clicked on old link or entered manually');
			return json_encode($error);
		}
	}
	
	function jobseeker(){
		$this->paginate = array(
			'limit'=>10,
			'conditions'=>array('UserList.id=Jobseekers.user_id'),
			'joins'=>array( 
						array(
							'table' => 'networkers',
							'alias' => 'Netwrk',
							'type' => 'left',
							'conditions'=> 'Netwrk.user_id=UserList.parent_user_id', 
						),
						array(
							'table' => 'users',
							'alias' => 'UsrNetwrkr',
							'type' => 'left',
							'conditions'=> 'Netwrk.user_id=UsrNetwrkr.id', 
						),
					),
					
			'fields'=>array('UsrNetwrkr.id, UsrNetwrkr.account_email, 
							Netwrk.id, Netwrk.user_id, Netwrk.contact_name, 
							UserList.*',  'Jobseekers.*'),
			'order'=>array('UserList.created'=>'desc')
		);
		$jobseekers=$this->paginate("UserList");	
		
		//echo "<pre>";
		//print_r($jobseekers);
		//exit;
		
		$this->set('jobseekers',$jobseekers);
	}
	
	function jobs(){
		$sortBy=null;
		if(isset($this->params['named']['sort'])&&!empty($this->params['named']['sort'])){
			$sortBy=$this->params['named']['sort'];
		}
		$this->paginate = array(
			'recursive'=>'-1',
			'joins'=>array(
				array(
					'table'=>'industry',
					'alias'=>'Industry',
					'type'=>'LEFT',
					'conditions'=>'Industry.id = Job.industry'
				),
				array(
					'table'=>'specification',
					'alias'=>'Specification',
					'type'=>'LEFT',
					'conditions'=>'Specification.id=Job.specification'
				),
				array(
					'table'=>'cities',
					'alias'=>'City',
					'type'=>'LEFT',
					'conditions'=>'City.id=Job.city'
				),
				array(
					'table'=>'states',
					'alias'=>'State',
					'type'=>'LEFT',
					'conditions'=>'State.id=Job.state'
				),
				array(
					'table'=>'companies',
					'alias'=>'Company',
					'type'=>'LEFT',
					'conditions'=>'Company.id=Job.company_id'
				),
			),
			'fields'=>'Job.*, City.city, State.state, Industry.name, Specification.name, Company.company_name',
			'limit'=>10,
			'order'=>'Job.created desc'
		);
		$this->Job->virtualFields['industry_name'] = 'Industry.name';
		$this->Job->virtualFields['specification_name'] = 'Specification.name';
		$this->Job->virtualFields['state_name'] = 'State.state';
		$this->Job->virtualFields['city_name'] = 'City.city';
		$this->Job->virtualFields['company'] = 'Company.company_name';
		$jobs=$this->paginate('Job');
		$this->set('sortBy',$sortBy);
		$this->set('jobs',$jobs);		
	}
	
	function jobSpecificData(){
		if(isset($this->params['id'])){
			$jobId=$this->params['id'];
			$jobData=$this->Job->find(
				'first',array(
					'conditions'=>array('Job.id'=>$jobId),
					'recursive'=>'-1',
					'joins'=>array(
						array(
							'table'=>'industry',
							'alias'=>'Industry',
							'type'=>'LEFT',
							'conditions'=>'Industry.id = Job.industry'
						),
						array(
							'table'=>'specification',
							'alias'=>'Specification',
							'type'=>'LEFT',
							'conditions'=>'Specification.id=Job.specification'
						),
						array(
							'table'=>'cities',
							'alias'=>'City',
							'type'=>'LEFT',
							'conditions'=>'City.id=Job.city'
						),
						array(
							'table'=>'states',
							'alias'=>'State',
							'type'=>'LEFT',
							'conditions'=>'State.id=Job.state'
						),
						array(
							'table'=>'companies',
							'alias'=>'Company',
							'type'=>'LEFT',
							'conditions'=>'Company.user_id=Job.user_id'
						),
						array(
							'table'=>'job_views',
							'alias'=>'JobView',
							'type'=>'LEFT',
							'conditions'=>'JobView.job_id = Job.id'
						),
						array(
							'table'=>'networkers',
							'alias'=>'Networker',
							'type'=>'LEFT',
							'conditions'=>'Networker.user_id = JobView.user_id'
						),
						array(
							'table'=>'jobseekers',
							'alias'=>'Jobseeker',
							'type'=>'LEFT',
							'conditions'=>'Jobseeker.user_id = JobView.user_id'
						),
						array(
							'table'=>'shared_jobs',
							'alias'=>'JobShared',
							'type'=>'LEFT',
							'conditions'=>'JobShared.job_id = Job.id'
						),array(
							'table'=>'jobseeker_apply',
							'alias'=>'JobApplied',
							'type'=>'LEFT',
							'conditions'=>'JobApplied.job_id = Job.id'
						),
					),
					'fields'=>'Job.*,Company.company_name, Industry.name, Specification.name, City.city, State.state, count(DISTINCT JobView.id) AS jobViews, count(DISTINCT JobShared.id) AS sharedJobs, count(DISTINCT JobApplied.id) AS appliedJobs, count(DISTINCT Networker.id) AS networkerViews, count(DISTINCT Jobseeker.id) as jobseekerViews'
				)
			);
			
			$jobApplyers=$this->jobApplyers($jobId);
			$this->set('jobData',$jobData);
			$this->set('jobApplyers',$jobApplyers);
		}else{
			$this->Session->setFlash("You may be clicked on old link or entered manually.","error");
			$this->redirect("/admin/Jobs");
		}
	}
	
	function jobApplyers($jobId){
		$this->paginate=array(
			'joins'=>array(
				array(
					'table'=>'jobseeker_apply',
					'alias'=>'JobseekerApply',
					'type'=>'INNER',
					'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id AND JobseekerApply.job_id='.$jobId
				),
				array(
					'table'=>'users',
					'alias'=>'User',
					'type'=>'INNER',
					'conditions'=>'User.id = Jobseeker.user_id'
				)
			),
			'fields'=>'Jobseeker.*,User.account_email, JobseekerApply.is_active',
			'limit'=>10,
		);
		return $this->paginate('Jobseeker');
	}
	
	function points(){

		$config = $this->Config->find('all',array('conditions'=>
													array('Config.key'=>
													array("jobseekers_point_number" ,"company_point_number")),
											'fields'=>'Config.*',)
									);
	    if(isset($this->data['Config']) && $config != null){
	    	$js = $this->data['Config']['jobseekers_point_number'];
	    	$cr = $this->data['Config']['company_point_number'] ;
	    	if( ( $js!= null && is_numeric($js) ) &&  ($cr != null && is_numeric($cr) )){
				$configData[0]['id']= $config[0]['Config']['id'];
				$configData[0]['value']= $this->data['Config']['company_point_number'];
				$configData[1]['id']= $config[1]['Config']['id'];
				$configData[1]['value']= $this->data['Config']['jobseekers_point_number'];
				$this->Config->saveAll($configData);
				$this->Session->setFlash('The Points Configuration have been updated.', 'success');	    		
			}else{
				$this->set("error", "Both fields are requried and must be numeric");
			}
		}

		$config = $this->Config->find('all',array('conditions'=>
													array('Config.key'=>
													array("company_point_number", "jobseekers_point_number")),

											'fields'=>'Config.*',)
								);
		if($config != null){
			$this->set('config', $config);
		}else{
			$this->Session->setFlash('Please fill the point configuration for jobseeker and networker.', 'warning');	    		
		}
		
		$universities = $this->University->find('all', array(
																'fields'=>array('University.*'),
													));
		//pr($universities); exit;
		$graduateUniversities = $this->GraduateUniversityBreakdown->find('all', array(
													'joins'=>array(
															array(
															'table'=>'graduate_degrees',
															'alias'=>'GraduateDegrees',
															'type'=>'inner',
															'conditions'=>'GraduateDegrees.id = GraduateUniversityBreakdown.degree_type'
													)),
													'fields'=>array('GraduateDegrees.degree ,GraduateUniversityBreakdown.*'),
													));
		//pr($graduateUniversities);exit;
		$this->set('universities',$universities);
		$this->set('graduateUniversity',$graduateUniversities);
		$pointLables = $this->PointLabels->find('all');
		$this->set('pointLables',$pointLables);
	}
	
	public function editPointsLevelInfo(){
		$pointsLevelData = $this->data['PointLabels'];
		if( $this->PointLabels->saveAll($pointsLevelData)){
			$this->Session->setFlash('Points Information updated successfully.', 'success');	    		
		}else{
			$this->Session->setFlash('Internal Error.', 'error');
		}
		$this->redirect("/admin/points");
	}

	function rewardPoint() {

	}

}

?>
