<?php
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | FightMetric MMA Tournament Pick'em Project                           |
// +----------------------------------------------------------------------+
// | Authors: Kremnev Andrej <andrey.k@a2design.biz>                      |
// |                         <md5hash@rambler.ru>                         |
// +----------------------------------------------------------------------+

class AppController extends Controller {

	var $uses = array('Invitations','InvitaionCode');
	
	public $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','TrackUser','ApiSession','Utility');
	
	public $helpers = array('Session','Html', 'Form', 'Javascript','Bcp.DatabaseMenus','Number');
	
	protected $userRole;
	
	function beforeRender(){
		$facebook = $this->requestAction('/Facebook/facebookObject');
		$this->set("FBLoginUrl",$facebook->getLoginUrl(array('scope' => 'email,read_stream')));
		//$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		//$linkedin->getRequestToken();
		//$this->Session->write('requestToken',serialize($linkedin->request_token));
		//$this->set("LILoginUrl","");//$linkedin->generateAuthorizeUrl() );	
	}
	function beforeFilter(){
		if(strtoupper($this->params['controller'])!='JOBS'){
			if($this->Session->check('NarrowJob'))
				$this->Session->delete('NarrowJob');
		}
		if($this->Session->check('SearchJob') && strtoupper($this->params['action'])!='SEARCHJOB'){
				$this->Session->delete('SearchJob');
		}
		$session = $this->_getSession();
		
		if($session->isLoggedIn()){
			$data['User']['id']=$session->getUserId();
			if(isset($data['User']['id']) && ($this->params['action'])!='logout'){
				$data['User']['last_login']=date('Y-m-d H:i:s'); 
				$data['User']['group_id']=0;
				$this->User->save($data);
			}
		}
        //here we get intermidiate user id from URLs
        $this->setIntermidiateUser();
		$recentJobs = $this->Utility->getRecentJobs();
		if(isset($recentJobs) && $recentJobs != null){
			$this->Session->write('recentJobs',$recentJobs);
      	}
        $this->setICC();
        $this->setInvitationCode();
		/* SMTP Options for GMAIL */
	  	$this->Email->smtpOptions = array(
		   'port'=>'465',
		   'timeout'=>'30',
		   'auth' => true,
		   'host' => 'ssl://smtp.gmail.com',
		   'username'=>'hireroutes',
		   'password'=>'hire100100',
	  	);

	   	/* Set delivery method */
	   	$this->Email->delivery = 'smtp';
	
		//Set user role
		if($this->Session->check('userRole'))
		{
			$this->userRole=$this->Session->read('userRole.id');
		}
	
		$this->Auth->fields = array(
			'username' => 'account_email',
			'password' => 'password'
		);
	
		$this->Auth->loginAction = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');

		$this->Auth->logoutRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');

		$this->Auth->loginRedirect = array('plugin' => '', 'controller' => 'pages', 'action' => 'index');

		$this->Auth->allow('logout');
		
	}



    function setIntermidiateUser(){
       /****************  genrate code for traking user ****************/
        if(isset($this->params['url']['intermediateCode'])){
        	if(isset($this->params['jobId'])){
	        	if($this->Utility->getJobIdFromCode($this->params['jobId'],$this->params['url']['intermediateCode'])){
    	        	$this->Session->write('intermediateCode',$this->params['url']['intermediateCode']);
    	        }else{
    	        	$this->Session->setFlash('You may be clicked on old link or entered menually.','error');
    	        	$this->redirect("/jobs/jobDetail/".$this->params['jobId']);
    	        }
			}else{
				$this->Session->write('intermediateCode',$this->params['url']['intermediateCode']);
			}
        }
		
	/************************** end *********************************/ 
    }
    
    /****	Common function to send email	****/
	protected function sendEmail($to,$subject,$template,$message,$replyTo=null,$from=null){
 		if($replyTo==null || empty($replyTo)){
 			$replyTo = USER_ACCOUNT_REPLY_EMAIL;
 		}
 		if($from==null || empty($from)){
	  		$from = 'Hire-Routes :: '.USER_ACCOUNT_SENDER_EMAIL;
 		}
 		try{
		 	$this->Email->to = $to;
			$this->Email->subject = $subject;
			$this->Email->replyTo = $replyTo;
			$this->Email->from = $from;
			$this->Email->template = $template;
			$this->Email->sendAs = 'html';
			$this->set('message',$message);
			$this->Email->send();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
			return false; 
		}
		return true; 
    }
    
    protected function _getSession()
    {
        return $this->ApiSession;
    }
    
    protected function setICC()
    {
        if(isset($this->params['url']['icc'])){
    	   	//check if it is not presented
    	   	$icCode = $this->params['url']['icc'];
    	   	$invitationDetail = $this->Invitations->find('first', array('conditions'=>array('ic_code'=>$icCode)));
			if(!isset($invitationDetail ) || $invitationDetail == null){
				$this->Session->delete('intermediateCode');
				$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');
				$this->redirect("/");
				return;
			}
			$this->Session->write('icc',$icCode);
		}
	}
	
	protected function setInvitationCode() {
		if(isset($this->params['url']['inviteCode'])){
			$inviteCode = $this->params['url']['inviteCode'];  
			$invitationDetail = $this->InvitaionCode->find('first', array('conditions'=>
																			array('invitaion_code'=>$inviteCode,
																				  'status'=>0,
					)));
			if(!isset($invitationDetail ) || $invitationDetail == null){
				$this->Session->delete('intermediateCode');
				$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');
				$this->redirect("/");
				return;
			}
			$this->Session->write('invitationCode',$inviteCode);
		}
	}
	
}

?>
