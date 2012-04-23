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
	public $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','TrackUser');
	public $helpers = array('Session','Html', 'Form', 'Javascript','Bcp.DatabaseMenus','Number');
	
	protected $userRole;
	
	function beforeFilter(){
		if(strtoupper($this->params['controller'])!='JOBS'){
			if($this->Session->check('NarrowJob'))
				$this->Session->delete('NarrowJob');
		}
		if($this->Session->check('SearchJob') && strtoupper($this->params['action'])!='SEARCHJOB'){
				$this->Session->delete('SearchJob');
		}
        //here we get intermidiate user id from URLs
        $this->setIntermidiateUser();
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
        if(isset($this->params['url']['code'])&&isset($this->params['jobId'])){
        	if($this->Utility->validateCode($this->params['jobId'],$this->params['url']['code'])){
            	$this->Session->write('code',$this->params['url']['code']);
            }else{
            	$this->Session->setFlash('You may be clicked on old link or entered menually.','error');
            	$this->redirect("/jobs/jobDetail/".$this->params['jobId']);
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
    

}

?>
