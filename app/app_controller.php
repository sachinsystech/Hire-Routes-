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
	public $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus');
	public $helpers = array('Session','Html', 'Form', 'Javascript','Bcp.DatabaseMenus');
	function beforeFilter(){
	
		/* SMTP Options for GMAIL */
	  	$this->Email->smtpOptions = array(
		   'port'=>'465',
		   'timeout'=>'30',
		   'auth' => true,
		   'host' => 'ssl://smtp.gmail.com',
		   'username'=>'hireroutes@gmail.com',
		   'password'=>'hire100100',
	  	);

	   	/* Set delivery method */
	   	$this->Email->delivery = 'smtp';
	
		$this->Auth->fields = array(
			'username' => 'account_email',
			'password' => 'password'
		);
	
		//$this->Auth->authError = __('You do not have permission to access the page you just selected.', true);

		$this->Auth->loginAction = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');

		$this->Auth->logoutRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');

		$this->Auth->loginRedirect = array('plugin' => '', 'controller' => 'pages', 'action' => 'index');

		$this->Auth->allow('logout');
	}

}

?>
