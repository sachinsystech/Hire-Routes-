<?php
class AdminController extends AppController {
    var $uses = array('Companies','User','ArosAcos','Aros','PaymentHistory','Networkers','UserList');
	var $helpers = array('Form','Number');
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','Acl','TrackUser','Utility');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('index');
		$this->Auth->allow('companiesList');
		//$this->Auth->allow('acceptCompanyRequest');
		$this->Auth->allow('Code');
		$this->Auth->allow('paymentInformation');
		$this->Auth->allow('filterPayment');
		$this->Auth->allow('paymentDetails');
		$this->Auth->allow('updatePaymentStatus');
		$this->Auth->allow('userList');
		$this->Auth->allow('userAction');
		$this->Auth->allow('userDetail');
		$this->layout = "admin";
		$roleInfo = $this->TrackUser->getCurrentUserRole();
		if($roleInfo['role_id']!=5){
			$this->redirect("/users/firstTime");
		}
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
					'type'=>'left',
					'fields'=>'user_id',
					'conditions'=>'Job.id = JobseekerApply.job_id'
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
					'fields'=>'user_id, intermediate_users',
					'conditions'=>'Job.id = JobseekerApply.job_id'
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
			'conditions'=>array('PaymentHistory.id'=>$this->params['payment_history_id'])
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
	
	function userList(){
		$userArray = array();
		if(isset($this->params['named']['filter'])){
			$filter = $this->params['named']['filter'];
			$this->set('filter',$filter);
		}
		if(isset($filter)){
			switch($filter){
				case COMPANY:
						$filterRoleid = 1;
						$filter = 'Companies';
						break;
				case JOBSEEKER:
						$filterRoleid = 2;
						$filter = 'Jobseekers';
						break;
				case NETWORKER:
						$filterRoleid = 3;
						$filter = 'Networkers';
						break;
			}
			$this->paginate =array('limit' =>10,
		   						   'conditions' => array('UserRoles.role_id'=>$filterRoleid),
								   'fields' => array("UserList.*,UserRoles.*,$filter.*"),
								  );	
		}else{
			$this->paginate =array('limit'=>10,);
		}
		
		$users= $this->paginate('UserList');
		
		foreach($users as $key=>$value){
			$role_id = isset($value['UserRoles']['role_id'])?$value['UserRoles']['role_id']:false;
			if($role_id ){
				switch($role_id){
					case 1:
							$role = 'Company';
							$table= "Companies";
							break;
					case 2:
							$role = 'Jobseeker';
							$table= "Jobseekers";
							break;
					case 3:
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
				if($value['UserList']['fb_user_id'] == 0){
					$userArray[$key]['account_email'] = $value['UserList']['account_email'];
				}else
					$userArray[$key]['account_email'] = "Facebook User";	
				$userArray[$key]['created'] = date("d M Y h:m:s", strtotime($value['UserList']['created']));
				$userArray[$key]['is_active'] = $value['UserList']['is_active'];
				
				if(isset($value[$table]) && $value[$table]['contact_name']!=null ){
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
		if(isset($this->params['named']['active'])){
			$userId=$this->params['named']['active'];
			$is_active=1;
		}			
		if(isset($this->params['named']['deactive'])){
			$userId=$this->params['named']['deactive'];
			$is_active=0;
		}
		if(isset($userId)){
			$userData =$this->User->find('first',array('conditions'=>"User.id=$userId"));
			if(isset($userData)){
				$userData['User']['is_active'] =$is_active;
				$this->User->save($userData);
			}
		}
		$this->redirect("userList");
		
	}
	
	function userDetail(){
		if(isset($this->params['named']['role_id'])){
			$role_id=$this->params['named']['role_id'];
			$user_id=$this->params['named']['id'];
			$userData= $this->UserList->find('first',array("conditions"=>"UserList.id=$user_id"));
			pr($userData);exit;
		}	
	
	
	}
	
}
?>
