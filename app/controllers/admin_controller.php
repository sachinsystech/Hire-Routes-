<?php
class AdminController extends AppController {
    var $uses = array('Companies','User','ArosAcos','Aros','PaymentHistory','Networkers','UserList','Config');
	var $helpers = array('Form','Number');
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','Acl','TrackUser','Utility');
	
	public function beforeFilter(){
		parent::beforeFilter();
		
		if($this->Session->read('Auth.User.id')!=1){
			$this->redirect('/');
		}
		if($this->userRole!=ADMIN){
			$this->redirect("/users/loginSuccess");
		}
		
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('index');
		$this->Auth->allow('companiesList');
		$this->Auth->allow('Code');
		$this->Auth->allow('paymentInformation');
		$this->Auth->allow('filterPayment');
		$this->Auth->allow('paymentDetails');
		$this->Auth->allow('updatePaymentStatus');
		$this->Auth->allow('userList');
		$this->Auth->allow('config');
		$this->Auth->allow('userAction');
		
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
				'Companies.act_as',
				'User.account_email'
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

	/****	Accept company request	***/
	function acceptCompanyRequest() {
		$id = $this->params['id'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		if($user){
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
			if($this->ArosAcos->save($arosAcosData) && $this->User->save($user['User'])){
				$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
				$to = $user['User']['account_email'];
				$subject = 'Hire Routes : Accept Account Request';
				$template = 'company_account_accept';
				$message = $user['User'];
				$this->sendEmail($to,$subject,$template,$message);			
				$this->Session->setFlash('Successfully activated user.', 'success');
			}else{
				$this->Session->setFlash('Internal error.', 'error');
				$this->redirect("/admin/companiesList");
			}
		}
		else{
			$this->Session->setFlash('Company not exit. OR you maybe clickd on old link.', 'error');
		}
		$this->redirect("/admin/companiesList");
	}

	/****	Decline company request	***/
	function declineCompanyRequest() {
		$id = $this->params['id'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		if($user){
			$user['User']['is_active'] = '2';
			// deactivate user's account	
			if($this->User->save($user['User'])){
			
				$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
				$to = $user['User']['account_email'];
				$subject = 'Hire Routes : Decline Account Request';
				$template = 'company_account_decline';
				$message = $user['User'];
				$this->sendEmail($to,$subject,$template,$message);		
				$this->Session->setFlash('User has been declined.', 'success');				
			}else{
				$this->Session->setFlash('Internal error.', 'error');
				$this->redirect("/admin/companiesList");
			}
		}
		else{
			$this->Session->setFlash('Company not exit. OR you maybe clickd on old link.', 'error');
		}
		$this->redirect("/admin/companiesList");
	}
	
	/**
	 * For payment information 
	 */
	function paymentInformation()
	{
		$conditions[]='JobseekerApply.is_active=1';
		if(!empty($this->data['paymentInformation']['status'])){
			$conditions[]='payment_status ='.$this->data['paymentInformation']['status'];
	 		$this->set('status',$this->data['paymentInformation']['status']);
	 	}
	 	if(!empty($this->data['paymentInformation']['from_date'])){
	 		$conditions[]="date(paid_date) >='".date("Y-m-d",strtotime($this->data['paymentInformation']['from_date']))."'";
	 		$this->set('from_date',$this->data['paymentInformation']['from_date']);
	 	}
	 	if(!empty($this->data['paymentInformation']['to_date'])){
	 		$conditions[]="date(paid_date) <='".date("Y-m-d",strtotime($this->data['paymentInformation']['to_date']))."'";
	 		$this->set('to_date',$this->data['paymentInformation']['to_date']);
	 	}
	 		 	
		$this->paginate = array(
			'fields'=>'PaymentHistory.id, Company.company_name, Jobseeker.contact_name, Job.title, PaymentHistory.amount, PaymentHistory.paid_date, PaymentHistory.transaction_id',
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
					'fields'=>'id, company_name',
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
				)
			),
			'limit'=>10,
			'conditions'=>isset($conditions)?$conditions:true
		);
		try{
			$paymentHistories=$this->paginate('PaymentHistory');
			$this->set('paymentHistories',$paymentHistories);
		}catch(Exception $e){
			$this->Session->setFlash("Server Problem!",'ERROR');
		}
	}
	
	/**
	 * For payment details 
	 */
	function paymentDetails()
	{
		$payment_detail = $this->PaymentHistory->find('first',array(
			'fields'=>'PaymentHistory.id, Company.company_name, Company.contact_phone, Company.company_url, Jobseeker.contact_name, Jobseeker.contact_phone, User.account_email, Job.title, PaymentHistory.amount, JobseekerApply.intermediate_users,PaymentHistory.paid_date, PaymentHistory.transaction_id, PaymentHistory.payment_status',
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
					'fields'=>'id, company_name, contact_phone, company_url',
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
					'alias'=>'User',
					'type'=>'left',
					'fields'=>'id, account_email',
					'conditions'=>'JobseekerApply.user_id = User.id'
				)
			),
			'limit'=>10,			
			'conditions'=>array('PaymentHistory.id'=>$this->params['payment_history_id'],'JobseekerApply.is_active'=>'1')
		));
		$networker_ids=explode(',',$payment_detail['JobseekerApply']['intermediate_users']);
		$this->paginate=array(
			'fields'=>'contact_name, User.account_email',
			'recursive'=>-1,
			'joins'=>array(
				array(
					'table'=>'users',
					'alias'=>'User',
					'fields'=>'id, account_email',
					'type'=>'inner',
					'conditions'=>'User.id = Networkers.user_id'
				)
			),
			'conditions'=>array('user_id'=>$networker_ids),
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
		$this->PaymentHistory->set(array('id'=>$this->data['PaymentHistory']['id'],'payment_status'=>true));
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
				$contact_name=trim($data['contact_name']);
				$conditions[]=array('OR'=>array("Jobseekers.contact_name LIKE\"".$contact_name."%\"",
	   								 		    "Networkers.contact_name LIKE\"".$contact_name."%\"",
    						   					"Companies.contact_name LIKE\"".$contact_name."%\"",
	   								));
				$this->set('contact_name',$contact_name);	
			}
			if(isset($data['contact_phone']) && !empty($data['contact_phone'])){			
				$contact_phone=trim($data['contact_phone']);
				$conditions[]=array('OR'=>array("Jobseekers.contact_phone LIKE\"".$contact_phone."%\"",
	   						   					"Networkers.contact_phone LIKE\"".$contact_phone."%\"",
	   						   					"Companies.contact_phone LIKE\"".$contact_phone."%\"",
	   						   		));				
				$this->set('contact_phone',$contact_phone);	
			}
			if(isset($data['account_email']) && !empty($data['account_email'])){			
				$conditions[]= "UserList.account_email LIKE \"".trim($data['account_email'])."%\"";
				$this->set('account_email',$data['account_email']);	
			}
			if(isset($data['from_date']) && !empty($data['from_date'])){
	 			$conditions[]="date(UserList.created) >='".date("Y-m-d",strtotime($data['from_date']))."'";
	 			$this->set('from_date',$data['from_date']);
	 		}
		 	if(isset($data['to_date']) && !empty($data['to_date'])){
		 		$conditions[]="date(UserList.created) <='".date("Y-m-d",strtotime($data['to_date']))."'";
		 		$this->set('to_date',$data['to_date']);
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
				if($value['UserList']['fb_user_id']==0){
					$userArray[$key]['account_email'] = $value['UserList']['account_email'];
				}else
					$userArray[$key]['account_email'] = "fb";
					
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
		$action = isset($this->params['form']['action'])?$this->params['form']['action']:"";
		if($action=="Activate"){
			$is_active='1';
		}elseif($action=="De-activate"){
			$is_active='0';
		}
		if(isset($userId)){
			$userData =$this->User->find('first',array('conditions'=>array("User.id"=>$userId,
																		'NOT'=>array("User.group_id"=>array(1,2)))));
			
			if(isset($userData)){
				$userData['User']['id']=$userId;
				$userData['User']['is_active'] =$is_active;
				if($this->User->save($userData)){
					$is_active==0?$this->Session->setFlash('User De-activated successfully','success'):
					$this->Session->setFlash('User Activated successfully','success');
					return "Succsess";
				}else{
					$this->Session->setFlash('Internal error occurs.','error');
					return ;
				}	
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered manually.', 'error');
				return ;
			}
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered manually......', 'error');
			return "error";
		}		
	}
	
	function config(){
		$configuration = $this->Config->find('first',array('conditions'=>array('Config.key'=>'rewardPercent')));
		    if($this->data){
		         if($this->data['Config']["rewardPercent"]){
		             $configuration['Config']['value'] = $this->data['Config']["rewardPercent"];
		             if($this->Config->save($configuration)){
		             $this->Session->setFlash('The Configuration details have been updated.', 'success');
					 }
		         }
		    }
		$this->set('rewardPercent',$configuration['Config']['value']);
	}
}
?>
