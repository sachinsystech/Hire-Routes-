<?php
class AdminController extends AppController {
    var $uses = array('Companies','User','ArosAcos','Aros');
	var $helpers = array('Form');
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','Acl');
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		//$this->Auth->allow('index');
		//$this->Auth->allow('CompaniesList');
		//$this->Auth->allow('acceptCompanyRequest');
		$this->Auth->allow('Code');
		$this->layout = "admin";
	}
	function index(){

	}
	
	
	function CompaniesList() {
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
			
			if($this->ArosAcos->save($arosAcosData) && $this->User->save($user['User'])){
				$this->sendAcceptCompanyRequestEmail($id);			
				$this->Session->setFlash('Successfully activated user.', 'success');
			}else{
				$this->Session->setFlash('Internal error.', 'error');
			}
		}
		else{
			$this->Session->setFlash('Company not exits.May be you click on old link.', 'success');
		}
		$this->redirect("/admin/CompaniesList");
	}


	function declineCompanyRequest() {
		$id = $this->params['id'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		if($user){
			$user['User']['is_active'] = '2';
			if($this->User->save($user['User'])){
				$this->Session->setFlash('Successfully declined user.', 'success');
				$this->sendDeclineCompanyRequestEmail($id);
			}else{
				$this->Session->setFlash('Internal error.', 'error');
			}
		}
		else{
			$this->Session->setFlash('Company not exits.May be you click on old link.', 'success');
		}
		$this->redirect("/admin/CompaniesList");
	}

	function sendAcceptCompanyRequestEmail($id){
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		try{
			$this->Email->to = $user['User']['account_email'];
			$this->Email->subject = 'Hire Routes : Accept Account Request';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'company_account_accept';
			$this->Email->sendAs = 'html';
			$this->set('user', $user['User']);
			$this->Email->send();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
	}
	function sendDeclineCompanyRequestEmail($id){
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		try{
			$this->Email->to = $user['User']['account_email'];
			$this->Email->subject = 'Hire Routes : Decline Account Request';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'company_account_decline';
			$this->Email->sendAs = 'html';
			$this->set('user', $user['User']);
			$this->Email->send();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
	}
	function Code() {

	}


}
?>
