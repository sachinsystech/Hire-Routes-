<?php
class AdminController extends AppController {
    var $uses = array('Companies','User','ArosAcos','Aros','PaymentHistory','Networkers',
    					'UserList','Config','Job','JobseekerApply','RewardsStatus','Jobseeker');
	var $helpers = array('Form','Number','Time','Paginator');
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus', 'Acl', 'TrackUser', 'Utility');
	
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
	function processCompanyRequest() {
		$id = $this->params['id'];
		$process = $this->params['process'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id,
																	'User.is_active'=>'0')));
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
			'fields'=>'PaymentHistory.*, Company.*, CompanyUser.account_email, Jobseeker.user_id, Jobseeker.contact_name, JobseekerUser.account_email, JobseekerUser.parent_user_id, Job.title, JobseekerApply.intermediate_users, RewardsStatus.status',
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
					'conditions'=>'RewardsStatus.user_id = Jobseeker.user_id AND RewardsStatus.payment_history_id = PaymentHistory.id'
				)
			),			
			'conditions'=>array('PaymentHistory.id'=>$this->params['payment_history_id'],'JobseekerApply.is_active'=>'1')
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
			'recursive'=>-1,
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
		$this->PaymentHistory->set(array('id'=>$this->data['PaymentHistory']['id'],'payment_status'=>true, 'hr_reward_percent'=>$this->data['PaymentHistory']['hrRewardPercent']));
	 	if($this->PaymentHistory->save())
	 		$this->Session->setFlash('Status updated successfully','success');
	 	else
	 		$this->Session->setFlash('Status update failure','error');
	 	$this->redirect(array('controller' => 'admin','action'=>'paymentDetails',$this->data['PaymentHistory']['id']));
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
							   					UserList.created,UserList.fb_user_id,UserList.is_active,
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
				$userArray[$key]['role_id'] = $role_id;
				$userArray[$key]['role'] = $role;
				$userArray[$key]['account_email'] = $value['UserList']['account_email'];
				$userArray[$key]['created'] = date("m/d/Y h:m:s", strtotime($value['UserList']['created']));
				$userArray[$key]['is_active'] = $value['UserList']['is_active'];
				
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
											'group' => 'scenario',	
										    'fields' => array('sum(PaymentHistory.amount) as reward','scenario'),
				   ));
		for($i=1, $j=0; $i<=9;$i++){
			$configuration['scenario'][$i]= ($senarioSum[$j][0]['reward']*$configuration[$i]) / 100; 
			if($i%3 ==0) $j++;
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
			'fields'=>'DISTINCT PaymentHistory.id, Company.user_id, Company.company_name, Jobseeker.contact_name, Job.title, Job.created, PaymentHistory.amount, PaymentHistory.paid_date, PaymentHistory.transaction_id, User.id, User.account_email, User.last_login,User.last_logout',
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
					'fields'=>'id,user_id,company_name',
					'conditions'=>'Job.company_id = Company.id'
				),
				array(
					'table'=>'jobseeker_apply',
					'alias'=>'JobseekerApply',
					'type'=>'inner',
					'fields'=>'user_id, is_active',
					'conditions'=>'PaymentHistory.job_id = JobseekerApply.job_id AND PaymentHistory.jobseeker_user_id=JobseekerApply.user_id'
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
					//'fields'=>'id, account_email, last_login',
					'conditions'=>'User.id = Company.user_id'
				)
			),
			'order'=>'paid_date desc',
			'limit'=>10,
			'conditions'=>isset($conditions)?$conditions:true
		);
		try{
			$this->PaymentHistory->virtualFields['employer'] = 'Company.company_name';
			$this->PaymentHistory->virtualFields['jobTitle'] = 'Job.title';
			$this->PaymentHistory->virtualFields['datePosted'] = 'Job.created';
			$paymentHistories=$this->paginate('PaymentHistory');
			
			//pr($paymentHistories); exit;
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
				    'fields' => array('MONTH(PaymentHistory.paid_date) As month','sum(PaymentHistory.amount) as reward'),
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
		
		foreach($graphData as $kuch_v){
			$gdarray[$kuch_v[0]['month']] = $kuch_v[0]['reward']/1000; 
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
			$jobseekerData=$this->Jobseeker->find('first',array(
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
								'conditions'=>'JobseekerApply.user_id = Jobseeker.user_id AND JobseekerApply.is_active = 0'
							)
						),
						'conditions'=>array(
							'Jobseeker.user_id'=>$this->params['id']
						),
						'fields'=>'Jobseeker.user_id, Jobseeker.contact_name, User.account_email, count(JobseekerApply.id) as appliedJob'
					)
				);
			if(empty($jobseekerData['Jobseeker']['user_id'])){
				$this->Session->setFlash('You may be clicked on old link or entered manually.','error');
				$this->redirect('/admin/');
			}
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
						$originsData=$this->User->find('first',array(
									'fields'=>'User.id, User.parent_user_id, Parent.account_email, Company.company_name, Company.id, Networker.contact_name',
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
						if(!empty($originsData['Company']['id'])||$originsData['User']['parent_user_id']==NULL)
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
		$Users   = $this->User->find('list',array('fields'=>'User.id',
													'joins'=>$joins,
													'conditions'=>$cond
												)
											);
		if(count($Users)== 0 ){
			return null;
			
		}
  	    return array_merge(array(count($Users)),(array)$this->getlevelInformation($Users));
	}
	
	private function getNetworkersData($level, $userIds=NULL){
		for($level;$level>0;$level--){
			$userIds=$this->getRecursiveNetworkers($userIds);
		}
		$this->paginate=array(
							'fields'=>'User.id, User.parent_user_id, User.account_email, count(DISTINCT Jobseeker.id) as jobseekerCount, Networker.contact_name, Networker.notification, count(DISTINCT SharedJob.job_id) as sharedJobsCount',
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
							),
							'conditions'=>array(
								'User.id'=>$userIds
							),
							'group'=>'User.id',
							'limit'=>10,
						);
		$this->User->virtualFields['jobseekerCount'] = 'count(DISTINCT Jobseeker.id)';
		$this->User->virtualFields['sharedJobsCount'] = 'count(DISTINCT SharedJob.job_id)';
		$this->User->virtualFields['notification'] = 'Networker.notification';
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
				$company=$this->Companies->find('first',array('fields'=>'Companies.company_name','conditions'=>array('Companies.user_id'=>$networkersData[$key]['User']['parent_user_id'])));
				if(empty($company)){
					$networkersData[$key]['origin']=1;
				}else{
					$networkersData[$key]['origin']=$company['Companies']['company_name'];
				}
			}
			//End get Origin
			
			//To get Networkers Total Reward
				$reward = $this->RewardsStatus->find('all',array(
												'conditions'=>array(
													'RewardsStatus.status'=>1,
													'RewardsStatus.user_id'=>$networkersData[$key]['User']['id']
												),
												'joins'=>array(
															array(
								     							'table' => 'payment_history',
										 						'alias' => 'PaymentHistory',
										                        'type' => 'INNER',
										                        'conditions' => array('RewardsStatus.payment_history_id = PaymentHistory.id')
									     					),
															array(
																'table' => 'jobseeker_apply',
										  						'alias' => 'JobseekerApply',
										  						'type' => 'INNER',
										  						'conditions' => array('PaymentHistory.applied_job_id = JobseekerApply.id AND FIND_IN_SET('.$networkersData[$key]['User']['id'].',JobseekerApply.intermediate_users)')
									     					),
																),
												'fields'=>array(
													'SUM(((PaymentHistory.amount)*(PaymentHistory.networker_reward_percent))/(substrCount(JobseekerApply.intermediate_users,",")*100)) as networker_reward'
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
		
		$users= $this->User->find('list',array('fields'=>'User.id',
													'joins'=>$joins,
													'conditions'=>$cond
												)
											);
		return $users;

	}
	
	function employer(){
		$sortBy="company_name";
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

			'fields'=>'Companies.user_id, Companies.contact_name, Companies.company_name, Companies.company_url, User.id, User.account_email, User.last_login,User.last_logout, count(DISTINCT PaymentHistory.job_id) as jobFilled, sum(PaymentHistory.amount) as awardPaid',
			'group'=>'Companies.user_id',
			'order'=>'Companies.user_id desc'
		);
		$this->Companies->virtualFields['jobFilled'] = 'count(DISTINCT PaymentHistory.job_id)';
		$this->Companies->virtualFields['awardPaid'] = 'sum(PaymentHistory.amount)';
		$this->Companies->virtualFields['email'] = 'User.account_email';
		$employers=$this->paginate('Companies');
		$user_ids=null;
		if(!empty($employers[0]))
		foreach($employers as $key=> $employer)
			$user_ids[]=$employer['Companies']['user_id'];
		$employersJobs=$this->Job->find('all',array(
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
			$companyDetail = $this->UserList->find('first',array('conditions'=>array('UserList.is_active'=>1,
																				  'UserList.id'=>$companyId,
																				  'UserRoles.role_id'=>1,
																				  ),
																'fields'=>array('UserList.id','UserList.account_email',
																'UserList.last_login','Companies.*'),					  
												));
			$companyDetail['activeJobCount']=$this->Job->find('count',array('conditions'=>
																					array('Job.user_id'=>$companyId,
																				          'Job.is_active'=>1)));
		
			$companyDetail['archJobCount']= $this->Job->find('count',array('conditions'=>
																					array('Job.user_id'=>$companyId,
																		   				  'Job.is_active'=>0)));
			$appliedJobCount=$this->Job->find('all',array('conditions'=>
														array('Job.user_id'=>$companyId,
															'Job.is_active'=>1),
															'joins'=>array( 
																		array('table' => 'jobseeker_apply',
																			  'alias' => 'JobseekerApply',
																			  'type' => 'LEFT',
																			  'conditions'=> 'JobseekerApply.job_id=Job.id AND JobseekerApply.is_active =0', 
															     				),
																			),
															 'fields'=>array('COUNT(Job.id) as appliedJobCount',)
															));		
															
			$companyDetail['appliedJobCount'] =$appliedJobCount[0][0]['appliedJobCount'];
			
			$jobs =$this->PaymentHistory->find('all',array(
												'conditions'=>array('PaymentHistory.user_id'=>$companyId),
												'joins'=>array(
																array('table'=>'jobs',
																'alias'=>'Job',
																'type'=>'Inner',
																'conditions'=>array('Job.id=PaymentHistory.job_id',
																	),
																),
				
																array('table'=>'job_views',
																'alias'=>'JobViews',
																'type'=>'LEFT',
																'conditions'=>'Job.id=JobViews.job_id',
																),
																array('table' => 'jobseeker_apply',
																'alias' => 'JobseekerApply',
																'type' => 'LEFT',
																'conditions' => 'JobseekerApply.job_id=Job.id AND JobseekerApply.is_active= 0'
																		,
																 ),
																),
												'recursive'=>1,
												'fields'=>array('Job.id ,Job.user_id,Job.reward,Job.title,Job.created',
																	'COUNT(DISTINCT(PaymentHistory.id)) AS submission',
																	'COUNT(DISTINCT(JobViews.id)) as views',),
													'group'=>array('Job.id'),
													));				
		
			$PaymentHistory =$this->PaymentHistory->find('all', array(
														'conditions' =>array('user_id'=>$companyId),
														'fields'=>array('sum(amount) as totalPaidReward '),
						));
			
			$totalRewards= $this->Job->find('all',array('conditions' =>array('user_id'=>$companyId),
														'fields'=>array('sum(reward) as totalReward '),
						));
			if(isset($companyDetail['Companies'])  && isset($jobs) && isset($PaymentHistory)){
			    $this->set('totalRewards',$totalRewards[0][0]['totalReward']);
			    $this->set('totalPaidReward',$PaymentHistory[0][0]['totalPaidReward']);
			    $this->set('jobs',$jobs);
				$this->set('PaymentHistory',$PaymentHistory); 				  
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
		$jobDetail = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId),
												  'joins'=>array(array('table' => 'industry',
										                               'alias' => 'ind',
										             				   'type' => 'LEFT',
										             				   'conditions' => array('Job.industry = ind.id',)),
											   			         array('table' => 'specification',
										             				   'alias' => 'spec',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.specification = spec.id',)),
																 array('table' => 'companies',
										             				   'alias' => 'comp',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.company_id = comp.id',)),
																 array('table' => 'cities',
										            				   'alias' => 'city',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.city = city.id',)),
											                     array('table' => 'states',
										                               'alias' => 'state',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.state = state.id',))
																),
												 'fields'=>array('Job.id ,Job.user_id,Job.title,Job.company_id,comp.company_name,city.city,state.state,Job.job_type,
Job.short_description, Job.reward, Job.created, Job.salary_from, Job.salary_to, Job.description, ind.name as industry_name, spec.name as specification_name, comp.company_url'),));
		
		$jobtypes = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary');
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
		$this->paginate= array('limit'=>10,
							   'conditions'=>array('UserList.id=Jobseekers.user_id'),
							   'fields'=>array('UserList.*','Jobseekers.*'),
							   'order'=>array('UserList.created'=>'desc'));
		$jobseekers=$this->paginate("UserList");	
		$this->set('jobseekers',$jobseekers);
	}
}

?>
