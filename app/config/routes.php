<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
 
 /** Admin URL **/
  Router::connect('/admin/acceptCompanyRequest/:id', array('controller' => 'admin','action' => 'acceptCompanyRequest'),array('id' => '[0-9]+'));
  Router::connect('/admin/declineCompanyRequest/:id', array('controller' => 'admin','action' => 'declineCompanyRequest'),array('id' => '[0-9]+'));
 /** end Admin URL **/
 
	Router::connect('/', array('controller' => 'home', 'action' => 'index', 'home'));
	Router::connect('/companyInformation', array('controller' => 'home', 'action' => 'companyInformation'));	
	Router::connect('/networkerInformation', array('controller' => 'home', 'action' => 'networkerInformation'));		
	Router::connect('/jobseekerInformation', array('controller' => 'home', 'action' => 'jobseekerInformation'));		

	Router::connect('/users/saveFacebookUser/:userType', array('controller' => 'users', 'action' => 'saveFacebookUser'));
	Router::connect('/coupons', array('controller' => 'coupons', 'action' => 'view'));				
	
/**

 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages', array('controller' => 'home', 'action' => 'index', 'home'));

	Router::connect('/companies/editJob/:userId/:jobId', array('controller' => 'companies', 'action' => 'editJob'));
	Router::connect('/companies', array('controller' => 'companies', 'action' => 'accountProfile'));
	
	Router::connect('/jobs/', array('controller' => 'jobs', 'action' => 'index'));
	Router::connect('/jobs/:id', array('controller' => 'jobs','action' => 'index'),
												array('id' => '[0-9]+'));
	
	//Router::connect('/users/:action', array('controller' => 'users'));
	Router::connect('/users/userSelection', array('controller' => 'users','action' => 'userSelection'));
	Router::connect('/users/confirmation/:id', array('controller' => 'users','action' => 'confirmation'),
												array('id' => '[0-9]+'));
	Router::connect('/users/companyRecruiterSignup', array('controller' => 'users','action' => 'companyRecruiterSignup'));
	Router::connect('/users/networkerSignup', array('controller' => 'users','action' => 'networkerSignup'));
	Router::connect('/users/jobseekerSignup', array('controller' => 'users','action' => 'jobseekerSignup'));	
	Router::connect('/users/account/:id/:code', array('controller' => 'users','action' => 'account'));		
	Router::connect('/users/firstTime/', array('controller' => 'users','action' => 'firstTime'));	
	Router::connect('/users/accountConfirmation/:id/:code', array('controller' => 'users','action' => 'accountConfirmation'));		

	Router::connect('/networkers/delete/:id', array('controller' => 'networkers','action' => 'delete'));	
	Router::connect('/networkers/sendNotifyEmal/:notifyId', array('controller' => 'networkers','action' => 'sendNotifyEmal'));	

	Router::connect('/jobseekers/delete/:id', array('controller' => 'jobseekers','action' => 'delete'));	
	Router::connect('/jobseekers/sendNotifyEmal/:notifyId', array('controller' => 'jobseekers','action' => 'sendNotifyEmal'));	
