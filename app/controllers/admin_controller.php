<?php
class AdminController extends AppController {
    var $uses = array('Companies','User','ArosAcos','Aros','PaymentHistory','Networkers');
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
		$Companies = $this->Companies->find('all', array(
		'fields' => array('Companies.id','Companies.user_id','Companies.contact_name','Companies.contact_phone','Companies.company_name','Companies.act_as','User.account_email'),
		'joins' => array(
																		array(
																			'table' => 'users',
																			'alias' => 'User',
																			'type' => 'inner',
																			'foreignKey' => false,
																			'conditions'=> array('User.id = Companies.user_id',"User.is_active=0")
																		),
																											)));
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
	
	/**** For payment information ****/
	function paymentInformation(){

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
			'limit'=>10
		);
		$paymentHistories = $this->paginate('PaymentHistory');
		$this->set('paymentHistories',$paymentHistories);	
	}
	
	/**
	 * For filter payment information
	 */
	function filterPayment()
	{
	 	if(!empty($this->data['filter']['status']))
	 		$statusCondition='payment_status ='.$this->data['filter']['status'];
	 	else
	 		$statusCondition=true;
	 	if(!empty($this->data['filter']['from_date'])){
	 		$from_date="date(paid_date) >='".date("Y-m-d",strtotime($this->data['filter']['from_date']))."'";
	 	}
	 	else
	 		$from_date=true;
	 	if(!empty($this->data['filter']['to_date']))
	 		$to_date="date(paid_date) <='".date("Y-m-d",strtotime($this->data['filter']['to_date']))."'";
	 	else
	 		$to_date=true;
	 		
	 		$this->set('from_date',$this->data['filter']['from_date']);
			$this->set('to_date',$this->data['filter']['to_date']);
			$this->set('status',$this->data['filter']['status']);
			
			$this->paginate=array(
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
				'conditions'=>array($from_date,$to_date,$statusCondition)
			);
			try
			{
				$paymentHistories=$this->paginate('PaymentHistory');
				$this->set('paymentHistories',$paymentHistories);
			}catch(Exception $e)
			{
				$this->Session->setFlash("Internal Error!");
			}
			$this->render('payment_information');
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
	 * For filter payment information
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
}
?>
