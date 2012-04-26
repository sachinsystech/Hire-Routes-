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
   	Router::connect('/admin/companiesList/:id', array('controller' => 'admin','action' => 'acceptCompanyRequest'),array('id' => '[0-9]+'));
  	Router::connect('/admin/acceptCompanyRequest/:id', array('controller' => 'admin','action' => 'acceptCompanyRequest'),array('id' => '[0-9]+'));
  	Router::connect('/admin/declineCompanyRequest/:id', array('controller' => 'admin','action' => 'declineCompanyRequest'),array('id' => '[0-9]+'));
  	Router::connect('/admin/paymentDetails/:payment_history_id/*', array('controller' => 'admin','action' => 'paymentDetails'),array('payment_history_id' => '[0-9]+'));
 /** end Admin URL **/
 
	Router::connect('/admin/codes', array('controller' => 'codes','action' => 'add'));
	Router::connect('/codes/delete/:id', array('controller' => 'codes','action' => 'delete'));	
	
	Router::connect('/', array('controller' => 'home', 'action' => 'index', 'home'));
	Router::connect('/companyInformation', array('controller' => 'home', 'action' => 'companyInformation'));	
	Router::connect('/networkerInformation', array('controller' => 'home', 'action' => 'networkerInformation'));		
	Router::connect('/jobseekerInformation', array('controller' => 'home', 'action' => 'jobseekerInformation'));		
	Router::connect('/howItWorks', array('controller' => 'home', 'action' => 'howItWorks'));	
	
	
	Router::connect('/companies/archiveJob/:id', array('controller' => 'companies','action' => 'archiveJob'),array('id' => '[0-9]+')); 
	Router::connect('/companies/showApplicant/:id/*', array('controller' => 'companies','action' => 'showApplicant'),array('id' => '[0-9]+')); 
	Router::connect('/companies/rejectApplicant/:id/:jobId', array('controller' => 'companies','action' => 'rejectApplicant'),array('id' => '[0-9]+','jobId' => '[0-9]+')); 

	Router::connect('/companies/viewResume/:ftype/:id', array('controller' => 'Companies','action' => 'viewResume')); 


	Router::connect('/users/saveFacebookUser/:userType', array('controller' => 'users', 'action' => 'saveFacebookUser'));

	
/**

 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages', array('controller' => 'home', 'action' => 'index', 'home'));
	
	Router::connect('/contactUs', array('controller'=> 'home', 'action'=>'contactUs'));
	Router::connect('/contactUs/:jobId/', array('controller'=> 'home', 'action'=>'contactUs'));
	
	
	Router::connect('/howItWorks',array('controller'=>'home','action'=>'howItWorks'));
	Router::connect('/howItWorks/:jobId/',array('controller'=>'home','action'=>'howItWorks'));
	
	Router::connect('/companies', array('controller' => 'companies', 'action' => 'accountProfile'));
	Router::connect('/companies/editJob/:jobId', array('controller' => 'companies', 'action' => 'editJob'));
	Router::connect('/companies/editProfile', array('controller' => 'companies', 'action' => 'editProfile'));
	Router::connect('/companies/checkout/:id', array('controller' => 'companies', 'action' => 'checkout'));
	Router::connect('/companies/paypalProPayment/:id', array('controller' => 'companies', 'action' => 'paypalProPayment'));
	Router::connect('/companies/paymentHistoryInfo/:id/:tid', array('controller' => 'companies', 'action' => 'paymentHistoryInfo'));
	Router::connect('/companies/paymentInfo/', array('controller' => 'companies', 'action' => 'paymentInfo'));
	Router::connect('/companies/paymentInfo/:id', array('controller' => 'companies', 'action' => 'paymentInfo'));
	Router::connect('/companies/acceptApplicant/:id', array('controller' => 'companies', 'action' => 'acceptApplicant'), array('jobId' => '[0-9]+'));
	Router::connect('/companies/jobStats/:jobId', array('controller' => 'companies', 'action' => 'jobStats'), array('jobId' => '[0-9]+'));

	Router::connect('/companies/deleteJob',array('controller'=>'companies','action'=>'deleteJob'));	


	Router::connect('/companies/share_email', array('controller'=>'companies', 'action'=>'share_render'));
	Router::connect('/companies/share_job_by_email', array('controller'=>'companies', 'action'=>'shareJobByEmail'));


	Router::connect('/jobs/', array('controller' => 'jobs', 'action' => 'index'));
	Router::connect('/jobs/:id/*', array('controller' => 'jobs','action' => 'index'),
												array('id' => '[0-9]+'));
	Router::connect('/jobs/jobDetail/:jobId/*', array('controller' => 'jobs','action' => 'jobDetail'),
												array('jobId' => '[0-9]+'));
	Router::connect('/jobs/applyJob/:jobId/*', array('controller' => 'jobs','action' => 'applyJob'),
												array('jobId' => '[0-9]+'));
	Router::connect('/jobs/viewResume/:filetype/:id/:jobId/*', array('controller' => 'jobs','action' => 'viewResume'));
	

	//UTILITY
	Router::connect('/utilities/getCitiesOfState/:state_id', array('controller'=>'utilities', 'action'=>'getCitiesOfState'));
	Router::connect('/utilities/getSpecificationOfIndustry/:industry_id', array('controller'=>'utilities', 'action'=>'getSpecificationOfIndustry'));
	
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
	Router::connect('/users/myAccount', array('controller' => 'users', 'action' => 'myAccount'));


	Router::connect('/networkers/delete/:id', array('controller' => 'networkers','action' => 'delete'));	
	Router::connect('/networkers/sendNotifyEmal/:notifyId', array('controller' => 'networkers','action' => 'sendNotifyEmal'));	
	Router::connect('/networkers/deleteContacts/:id', array('controller' => 'networkers','action' => 'deleteContacts'));
	Router::connect('/networkers/personal/', array('controller' => 'networkers','action' => 'personal'));
	Router::connect('/networkers/editPersonalContact/:id', array('controller' => 'networkers','action' => 'editPersonalContact'));
	
	
	Router::connect('/jobseekers/delete/:id', array('controller' => 'jobseekers','action' => 'delete'));	
	Router::connect('/jobseekers/sendNotifyEmal/:notifyId', array('controller' => 'jobseekers','action' => 'sendNotifyEmal'));
	Router::connect('/jobseekers/viewResume/:filetype/:id', array('controller' => 'jobseekers','action' => 'viewResume'),array('id' => '[0-9]+'));	



