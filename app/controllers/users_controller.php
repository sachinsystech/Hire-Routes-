<?php 
/**
 * Include files
 */
require_once(APP_DIR.'/vendors/facebook/facebook.php'); 

/**
 * UserController
 *
 * User Application controller class for organization of registration, login, facebook login, redirection etc.
 * Provides basic functionality, such as rendering signup views, account confirmation, approval
 * use Session and Auth component.
 * Bcp plugin for users managing modules as resources

 */
class UsersController extends AppController {
    var $uses = array('User', 'Companies', 'UserRoles', 'Networkers', 'Jobseekers', 'NetworkerSettings', 'JobseekerSettings', 'Acos', 'Aros',	'ArosAcos',	'Code','ReceivedJob','University','GraduateDegree','Invitation');
	var $components = array('Email', 'Session', 'Bcp.AclCached', 'Cookie', 'Auth', 'Security', 'Bcp.DatabaseMenus', 'Acl', 'TrackUser', 'Utility','RequestHandler');
				
	var $helpers = array('Form');

/**
 * Called before the UserController action.
**/
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('account');		
		$this->Auth->allow('accountConfirmation');		
		$this->Auth->allow('beforeLoggedIn');
		$this->Auth->allow('companyRecruiterSignup');		
		$this->Auth->allow('confirmation');		
		$this->Auth->allow('companyRecruiterSignup');
		$this->Auth->allow('firstTime');
		$this->Auth->allow('facebookUser');
		$this->Auth->allow('facebookUserSelection');
		$this->Auth->allow('forgotPassword');	
		$this->Auth->allow('index');
		$this->Auth->allow('jobseekerSignup');
		$this->Auth->allow('saveLinkedinUser');
		$this->Auth->allow('logout'); 
		$this->Auth->allow('login');
		$this->Auth->allow('loginSuccess');
		$this->Auth->allow('myAccount');		
		$this->Auth->allow('networkerSignup');	
		$this->Auth->allow('saveFacebookUser');
		$this->Auth->allow('userSelection');
		$this->Auth->allow('invitations');
		$this->Auth->allow('linkedinUserSelection');

	}

/**
 * Called as default action for UserController.
**/	
	function index(){
		if($this->_getSession()->isLoggedIn()){
			$this->loginSuccess();	
		}
		else{
			$this->redirect("/users/userSelection");
		}
    }
/**
 * Displays a view to choose which type of user you want to register if user is not logged-in, 
 * Redirecting respactive my-account page (If user logged-in). 
**/
	function userSelection(){
		if($this->_getSession()->isLoggedIn()){
			$this->loginSuccess();	
		}
	}

/**
 * Display Company/Recruiter registration view.
**/ 
	function companyRecruiterSignup(){
		$this->layout = "home" ;
		if($this->_getSession()->isLoggedIn()){
			$this->loginSuccess();	
		}

		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
				$this->render("company_recruiter_signup");
				return;
			}
			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("company_recruiter_signup");
				return;
			}
			if( $userId = $this->saveUser($this->data['User']) ){
				$userRoleId = COMPANY;
				$this->saveUserRoles($userId,$userRoleId);				
				$company = array();
				$company = $this->data['Companies'];
				$company['user_id'] = $userId;
				$company['act_as'] = $this->data['Companies']['role'];
				if($this->Companies->save($company) ){			
					$this->sendConfirmationEmail($userId);
					$this->Utility->deleteInvitationCode();
					$this->redirect("confirmation/".$userId);
					return;
				}
				else{
					$this->User->rollback();
					$this->UserRoles->rollback();
					$this->Session->setFlash('Internal Error!', 'error');
					$this->redirect("/");
					return;
				}
			}
		}
	}
/**
 * Display Networker registration view also validate by asking restrict code for signup process.
**/ 

	function networkerSignup() {
		if($this->_getSession()->isLoggedIn()){
			$this->loginSuccess();	
		}
	
		$facebook = $this->facebookObject();
		$this->set("FBLoginUrl",$facebook->getLoginUrl(array('scope' => 'email,read_stream')));
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		$linkedin->getRequestToken();
		$this->Session->write('requestToken',serialize($linkedin->request_token));
		$this->set("LILoginUrl",$linkedin->generateAuthorizeUrl() );
		$universities = $this->University->find('list');
		$this->set("universities",$universities);

		$graduateDegrees = $this->GraduateDegree->find('list',array('fields'=>'id, degree'));	
		$this->set("graduateDegrees",$graduateDegrees);

		/***	manage facebook user after success callback ***/
		if(isset($this->params['url']['state']) && isset($this->params['url']['state'])){			
			$FBUserId = $facebook->getUser();
			if($FBUserId){
				$this->manageFBUser();
			}
		}

		/***	manage facebook user after cancel callback(denied permission from FB-App) ***/		
		if(isset($this->params['url']['error_reason'])){
			$this->Session->setFlash('you can signup by email!', 'warning');
		}
		$jobId=null;
		$codeFlag=true;
		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
			    unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
                return;
			}
			/*	Validating Restrict_Code	*/
			if( ( $this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')== null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null ) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null )){
				if(!$this->validateCode()){
					return;
				}
			}else{ 
				
				$codeFlag=false;
				$jobId=$this->Utility->getJobIdFromCode(NULL, $this->Session->read('intermediateCode'));
			}

			if( isset($this->data['Networker']['university']) && $this->data['Networker']['university'] == null){
			 	unset($this->data["User"]["password"]);
   	            unset($this->data["User"]["repeat_password"]);
				$this->set('uniErrors', "This is Required");
				return;
			}
			  
			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
   	            unset($this->data["User"]["repeat_password"]);
			    $this->set('tcErrors', "You must agree to the Terms and Conditions");
				return;
			}			
	
			if($userId = $this->saveUser($this->data['User']) ){
				$userRoleId = NETWORKER;
				$this->saveUserRoles($userId,$userRoleId);
				if(!is_null($jobId))
					if(!$this->ReceivedJob->save(array('user_id'=>$userId,'job_id'=>$jobId))){
						$this->Session->setFlash('Something went wrong! Your job is not saved!', 'warning');
					}
				$this->data["Networker"]['user_id'] = $userId;
				if($this->Networkers->save($this->data["Networker"],false) ){
					
					$iv1 = array('ic_code'=> null,'status'=>'1');
					$iv2 = array('ic_code =' => $this->Session->read('icc'));
						
					if(! $this->Invitations->updateAll($iv1,$iv2)) {
						$this->Session->setFlash('Internal Error!', 'error');
						return;
					}			
					$this->Session->delete('icc');
					$this->Utility->deleteInvitationCode();
					$this->sendConfirmationEmail($userId);
					if($codeFlag){
						$code = $this->findCodeFor('Networker');
						$code['remianing_signups']--;
						if(!$this->Code->save($code)){
							$this->Session->setFlash('Internal Error!', 'error');
							$this->redirect("/");return;
						}
						if($code['remianing_signups']<1){
							if(!$this->Code->delete($code)){
								$this->Session->setFlash('Internal Error!', 'error');
								$this->redirect("/");return;
							}
						}
					}
					$this->redirect("confirmation/".$userId);return;
				}
				else{
					$this->Session->setFlash('Internal Error!', 'error');
					$this->redirect("/");
					return;
				}
			}
		}
	}
	
/**
 * Display Jobseeker registration view also validate by asking restrict code for signup process.
 * Save Jobseeker info.
**/ 
	function jobseekerSignup(){
		$this->layout = "home" ;
		if($this->_getSession()->isLoggedIn()){
			$this->loginSuccess();	
		}
		
		if(!$this->validateIcCode()){
			$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');
			$this->redirect("/");
			return;
		}
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		$linkedin->getRequestToken();
		$this->Session->write('requestToken',serialize($linkedin->request_token));
		$this->set("LILoginUrl",$linkedin->generateAuthorizeUrl() );
		
		$facebook = $this->facebookObject();
		$this->set('FBLoginUrl',$facebook->getLoginUrl(array('scope' => 'email,read_stream')));
		/***	manage facebook user after success callback ***/
		if(isset($this->params['url']['state']) && isset($this->params['url']['state'])){
			$facebook = $this->facebookObject();
			$FBUserId = $facebook->getUser();
			if($FBUserId){
				$this->manageFBUser();
			}
		}

		/***	manage facebook user after cancel callback(denied permission from FB-App) ***/		
		if(isset($this->params['url']['error_reason'])){
			$this->Session->setFlash('you can signup by email!', 'warning');
		}
		$jobId=null;	
		$codeFlag=true;
		$transaction_validity=false;

		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
                unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
   			    $this->render("jobseeker_signup");
				return;
			}
			/*	Validating Restrict_Code	*/
			if( ( $this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')== null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null ) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null )){
				if(!$this->validateCode()){
					return;
				}
			}else{ 
				$codeFlag=false;
				$jobId=$this->Utility->getJobIdFromCode(NULL, $this->Session->read('intermediateCode'));
			}

			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("jobseeker_signup");
				return;
			}
			if($userId = $this->saveUser($this->data['User']) ){
				$userRoleId = JOBSEEKER;
				if(!$this->saveUserRoles($userId,$userRoleId))
				{
					$this->Session->setFlash('Internal Error!', 'error');
					return;
				}
				if(! $this->Invitations->updateAll(
								   array('ic_code'=> null,'status'=>'1'),
									array('ic_code =' => $this->Session->read('icc') )
								)) {
					$this->Session->setFlash('Internal Error!', 'error');
					return;
				}
				if(!is_null($jobId))
					if(!$this->ReceivedJob->save(array('user_id'=>$userId,'job_id'=>$jobId))){
						$this->Session->setFlash('Something went wrong! Your job is not saved!', 'warning');
					}
				$jobseeker = array();
				$jobseeker['user_id'] = $userId;
				if($this->Jobseekers->save($jobseeker,false)){
					$this->sendConfirmationEmail($userId);
					$this->Utility->deleteInvitationCode();
					if($codeFlag){
						$code = $this->findCodeFor('Jobseeker');
						$code['remianing_signups']--;
						if(!$this->Code->save($code)){
							$this->Session->setFlash('Internal Error!', 'error');
							return;
						}
						if($code['remianing_signups']<1){
							if(!$this->Code->delete($code)){
								$this->Session->setFlash('Internal Error!', 'error');
								return;
							}
						}	
					}
					$this->redirect("confirmation/".$userId);
				}
				else{
					$this->Session->setFlash('Internal Error!', 'error');
					$this->redirect("/");
					return;
				}
			}
		}
	}
	
/**
 * validating signup restriction code
 * @return boolean True on validate success, false on failure(code not found)
 * @access private
 */	
	private function validateCode(){
		if(empty($this->data['Code']['code']) ){
			unset($this->data["User"]["password"]);
       	    unset($this->data["User"]["repeat_password"]);
       	    $this->set('codeErrors', "This field is required.");
			return false;
		}
		if($this->action=="networkerSignup"){
			$user_type = 'Networker';
		}
		if($this->action=="jobseekerSignup"){
			$user_type = 'Jobseeker';
		}
		$code = $this->findCodeFor($user_type);
		if(!isset($code))
		{	
			unset($this->data["User"]["password"]);
            unset($this->data["User"]["repeat_password"]);
			$this->set('codeErrors', "This Code is Expired or invalid...");
			return false;
		}
		return true;
	}
/**
 * find signup restriction code
 * @return boolean True on validate success, false on failure(code not found)
 * @access private
 */		
	private function findCodeFor($user_type){
		$code = $this->Code->find('first',array('conditions'=>array(
																'Code.code'=>$this->data['Code']['code'],
																'Code.user_type'=>$user_type,
																'Code.remianing_signups >'=>0
																)
												)
								);
		return $code['Code'];
	}	

/**
 * save User with generating md5 password.
 * @return user's id
 * @access private
 */
 	private function saveUser($userData){
		$userData['confirm_code'] = md5(uniqid(rand())); 
		$userData['group_id'] = 0;
        if($parent = $this->Utility->getRecentUserIdFromCode()){
            $userData['parent_user_id'] = $parent;
		}
		
		if(!$this->User->save($userData)){
			$this->Session->setFlash('Internal Error1!', 'error');
			$this->redirect("/");
			return;
		}
		//$this->Session->delete('intermediateCode');
	    return $this->User->id;
	}
/**
 * save User's Role like company/recruiter, jobseeker OR nerworker.
 * @return user's id
 * @access private
 */
	private function saveUserRoles($userId,$userRoleId){
		$roles = array();
		$roles['user_id'] = $userId;			
		$roles['role_id'] = $userRoleId;
		$roles['permission'] = "allow";
		if(!$this->UserRoles->save($roles)){
			$this->Session->setFlash('Internal Error!', 'error');
			$this->redirect("/");
			return false;
		}
		return true;
	}
/**
 * send comfirmation email for acivating account.
 * e-mail contains account confirmation link.
 * @access private
 */

	private function sendConfirmationEmail($userId){
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));	
		$userRole = $this->Utility->getUserRole($userId);
		switch($userRole['id']){
			case COMPANY:
				$template = 'company_user_registration';
				break;			
			default:
				$template = 'user_account_confirmation';			
		}
		$to = $user['User']['account_email'];
		$subject = 'Hire Routes : Account Confirmation';
		$message =  $user['User'];
		$code=$this->Session->read('intermediateCode');
		if(!empty($code))
			$message['intermediateCode'] =  '?intermediateCode='.$code;
		$this->sendEmail($to,$subject,$template,$message);
	}
	
	private function fbNewAccountEmail($fbData){
		$template = 'fb_user_registration';
		$to = $fbData['account_email'];
		$subject = 'Hire Routes : Account Confirmation';
		$message =  $fbData;
		$this->sendEmail($to,$subject,$template,$message);
	}
	
/**
 * Display account confirmaiton message after sigining-up.
**/    
	function confirmation(){
		$id = isset($this->params['id'])?$this->params['id']:"";
		if(!isset($id)){
			$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');
			$this->redirect("/");
			return;
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		if($user){
			if(!$user['User']['is_active']){
				$this->set('confirmation_email', $user['User']['account_email']);
				$userRole = $this->Utility->getUserRole($id);
				if($userRole['id']==COMPANY){
					$this->set('roleId',COMPANY);
					$this->Session->setFlash('Your Account created successfully.', 'success');		
				}
				else{
					$this->Session->setFlash('Account confirmation is required. Please, check your email for the confirmation link.', 'success');		
				}
			}
			else{
				$this->redirect("/users/firstTime");				
			}
		}
		else{
			$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');
			$this->redirect("/");
			return;
		}
	}

/**
 * after account confirmation redirect user to "first-time" page.
 */
	function accountConfirmation(){
		$userId = $this->params['id'];
		$confirmCode = $this->params['code'];
		$this->confirmAccount($userId,$confirmCode);
		$this->redirect("firstTime");
	}
/**
 * after click on confirmation link display intermediate view performing some account handling after account confirmation.
 */
	function account() {
		$userId = isset($this->params['id'])?$this->params['id']:null;
		$confirmCode =isset($this->params['code'])?$this->params['code']:null;
		if($userId!=null && $confirmCode!= null ){
			$this->set('userId', $userId);
			$this->set('confirmCode', $confirmCode);
		}else{
			$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');	
			$this->redirect("/users/login");
		}
	}
/**
 * after click on confirmation link match confirm code and activate user.
 */
	function confirmAccount($userId,$confirmCode){
		$user = $this->User->find('first',array('conditions'=>array(
																	array('User.id'=>$userId,
																	      'User.confirm_code'=>$confirmCode,
																   ))));
		if(isset($user) && $user!= null){
			if($user['User']['is_active']!=2 && $user['User']['is_active']==0){
				$user['User']['is_active'] = '1';
				$user['User']['confirm_code']="";
				$this->Utility->setNetworkerPoints($user);
				
				$aros = $this->Aros->find('first',array('conditions'=>array('Aros.foreign_key'=>$userId)));
				$arosAcosData['aro_id'] = $aros['Aros']['id'];
				$arosAcosData['aco_id'] = 47;
				$arosAcosData['_create'] = 1;
				$arosAcosData['_read'] = 1;
				$arosAcosData['_update'] = 1;
				$arosAcosData['_delete'] = 1;	
				if($this->ArosAcos->save($arosAcosData)){
					if($this->User->save($user['User'])){
						$this->setUserAsLoggedIn($user['User']);
					}
				}
				else{
					$this->Session->setFlash('Internal Error!', 'error');
					$this->redirect("/");
					return;
				}
			}else{
				$this->Session->setFlash('You maybe clicked on old link or entered menualy.', 'error');		
			}
		}else{
			$this->Session->setFlash('Your account is confirmed and activated. Please login!', 'warning');
			$this->redirect("login");		
		}
	}
		
/**
 * after click on confirmation link  authenticate user and set as logged-in.
 */
 
	function setUserAsLoggedIn($user){
		if(isset($user)){
			
			$data = array('User' => array('account_email' => $user['account_email'],
										  'password' => $user['password']
										  ));
			$this->Auth->fields = array(
				'username' => 'account_email',
				'password' => 'password'
			);
			
			if($this->Auth->login($data,false)){
				$this->_getSession()->start();
			}
		}	
	}	
/**
 * display first time page when user click on confirmation link.
 * redirect users to respective setting pages if they setting up their account.
 */
	function firstTime() {
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/users/login");
		}
		$session->start();
		$id = $session->getUserId();
		switch($session->getUserRole()){
			case COMPANY:
						$this->redirect("/companies/newJob");
					break;	
			case JOBSEEKER:
					$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('user_id'=>$id)));
					if($jobseekerData){
						$this->redirect("/jobseekers/newJob");						
					}
					break;			
			case NETWORKER:
					$networkerData = $this->NetworkerSettings->find('first',array('conditions'=>array('user_id'=>$id)));
					if($networkerData){
						$this->redirect("/networkers/newJob");						
					}
					break;		
			case ADMIN:
					$this->redirect("/admin");
					break;	
			default:
					$this->redirect('/');					
		}
		if($this->userRole==NETWORKER){
			if($this->Session->check('intermediateCode')){
				$intermediateCode=$this->Session->read('intermediateCode');
				$jobId=$this->Utility->getJobIdFromCode('',$intermediateCode);
				$this->set('jobUrl','/jobs/jobDetail/'.$jobId.'?intermediateCode='.$intermediateCode);
			}
		}
		$this->set('role', $this->userRole);
	}
/**
 * create facebook object.
 * @return an array of facebook object 
 */	
	private function facebookObject() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
		));
		return $facebook;
	}
	
/**	
 * Tracking facebook users, whether he/she is first-time or existing user.... 
 */ 
 	private function manageFBUser(){
		$facebook = $this->facebookObject();
		$fbUserProfile = $facebook->api('/me');
		$FBUserId = $facebook->getUser();
		if($FBUserId){
			$FBUser = $this->User->find('first',array('conditions'=>array('User.fb_user_id'=>$FBUserId)));
			if(!$FBUser){
				if($this->Session->check('intermediateCode') || ( $this->Session->read('invitationCode')!='' || $this->Session->read('invitationCode')!= null )){
					$fbUserMail = isset($fbUserProfile['email'])?$fbUserProfile['email']:'';// Retrieve mail from FB
					$getUser = $this->User->find('first',array(	
												'conditions'=>array('User.account_email'=>$fbUserMail), 
												'fields'=>'User.account_email,User.password'	
												)
												);
					if($getUser['User']){			
						$userData['id'] = $getUser['User']['id'];
						$userData['fb_user_id'] = $fbUserProfile['id'];
						$userData['facebook_token'] = $facebook->getAccessToken();
						if($this->User->save($userData)){
							$setUserAsLoggedIn['account_email'] = $getUser['User']['account_email'];
							$setUserAsLoggedIn['password'] = $getUser['User']['password'];
							$this->setUserAsLoggedIn($setUserAsLoggedIn);
							$this->redirect("/users/firstTime");
							return;
						}		
					}
					else{
						$this->redirect("/users/facebookUserSelection");
					}
				}else{
					$this->Session->setFlash("Please make vreification from HR user to sign up with face book.","error");
					$this->redirect("/");
				}
					
			}
			if($FBUser){
				$this->setUserAsLoggedIn($FBUser['User']);
				$this->redirect("/users/loginSuccess");
			}
		}
	}
/**	
 * save FB-User if not exist.....
 * first ask to become Networker or Jobseeker.
 */
	function saveFacebookUser(){
		$facebook = $this->facebookObject();
		$fb_user_profile = $facebook->api('/me');
		$userData = array();
		$userData['fb_user_id'] = $fb_user_profile['id'];
		$userData['facebook_token'] = $facebook->getAccessToken();
	
		$userData['account_email'] = isset($fb_user_profile['email'])?$fb_user_profile['email']:$fb_user_profile['id']."_fbuser@dummy.mail";
		$userData['password'] = 'NULL';			
		if($this->params['userType'] ==3 ){
			if(isset($this->data['Networkers']) && $this->data['Networkers']['university']!= null ){
				$user['graduate_degree_id'] = $this->data['Networkers']['graduate_degree_id'];
				$user['graduate_university_id'] = $this->data['Networkers']['graduate_university_id'];
				$user['university'] = $this->data['Networkers']['university'];
			}else{
				$this->Session->setFlash("Please fill correct information.","error");
				$this->redirect("/users/facebookUserSelection");
			}
		}
		if($userId = $this->saveUser($userData)){
			$userRole = $this->params['userType']; // 2=>JOBSEEKER,3=>NETWORKER
			$this->saveUserRoles($userId,$userRole);
			
			$userCCode = $this->User->find('first',array(	
															'conditions'=>array('User.id'=>$userId), 
															'fields'=>'User.confirm_code'));
			
			$userData['confirm_code'] = $userCCode['User']['confirm_code'];
			$user['user_id'] = $userId;
			$user['contact_name'] = $fb_user_profile['name'];
			
			$fbData['contact_name']=$fb_user_profile['name'];
			$fbData['account_email']=$userData['account_email'];
			switch($userRole){
				case JOBSEEKER:
								if($this->Jobseekers->save($user,false) ){
									$this->confirmAccount($userId,$userData['confirm_code']);
									$this->Utility->deleteInvitationCode();
									$fbData['userRole']='Jobseeker';
									$this->fbNewAccountEmail($fbData);
									$this->redirect("/users/firstTime");
								}
								break;
				case NETWORKER:
								if($this->Networkers->save($user,false) ){	
									$this->confirmAccount($userId,$userData['confirm_code']);
									$this->Utility->deleteInvitationCode();
									$fbData['userRole']='Networker';									
									$this->fbNewAccountEmail($fbData);									
									$this->redirect("/users/firstTime");
								}
								break;					
			}	
		}	
	}		


/**
 * Log-in a user with the given parameter account_email and password
 * use AuthComponent to authenticate...
 * @return boolean True on login success, false on failure
 * @access public
 */
	function login() {
		$this->layout = "home" ;
		$session = $this->_getSession();
		if($session->isLoggedIn()){
			$this->redirect('loginSuccess');
		}
		
		
		if(isset($this->data['User'])){
			$username = trim($this->data['User']['username']);
			$password = trim($this->data['User']['password']);

			$data = array('User' => array('account_email' => $username,
										  'password' => Security::hash(Configure::read('Security.salt') .$password)
										  ));

			/** check if user is activated **/
			$active_user = $this->User->find('first',array('conditions'=>array(
																		'account_email'=>$username,
																		'is_active'=>array(0,1),
																		)
															));								
			$this->beforeLoggedIn($active_user);
			/**	@user not registered account(OR for company user ==>> declined by admin)	**/			
			
			$this->Auth->fields = array(
				'username' => 'account_email',
				'password' => 'password'
			);
			
			if(!$this->Auth->login($data)){
				$this->Session->setFlash('Username or password not matched.', 'error');				
			}else{
				$session->start();
				$referer = $session->getBeforeAuthUrl(); 
				if(isset($referer) && !empty($referer) && $session->getUserRole()!=ADMIN){
					$this->redirect("/$referer");
				}
				$this->redirect('loginSuccess');
			}
		}
		//$session->setBeforeAuthUrl($this->referer());		
	}

/**
 * Logs a user out, with removing saved session and returns the home page to redirect to.
 * @access public
 */	
	function logout() {
		$data['User']['id']=$this->_getSession()->getUserId();
		if(isset($data['User']['id'])){
			$data['User']['last_logout']=date('Y-m-d H:i:s'); 
			$this->User->save($data);
		}
		$this->Auth->logout();
		$this->_getSession()->logout();
        $this->Session->delete('intermediateCode');
		$this->Session->delete('welcomeUserName');
		$this->Session->delete('userRole');
		$this->Session->delete('Twitter');
		$this->redirect("/users/login");		
	}	
/**
 * Ask facebook user to become Jobseeker OR Networker
 * @access public
 */	
	function facebookUserSelection(){
		$graduateDegrees = $this->GraduateDegree->find('list',array('fields'=>'id, degree'));	
		$this->set("graduateDegrees",$graduateDegrees);
		$facebook = $this->facebookObject();
		$FBUserId = $facebook->getUser();
		if(!$FBUserId){
			$this->redirect('/users');
		}
	}
	
	function facebookUser(){
		
		/***	manage facebook user after cancel callback(denied permission from FB-App) ***/		
		if(isset($this->params['url']['error_reason'])){
			$this->Session->setFlash('you have declined the request from Facebook!', 'warning');
			$this->redirect('/users');
		}
		
		/***	manage facebook user after success callback ***/
		if(isset($this->params['url']['state']) && isset($this->params['url']['state'])){
			$facebook = $this->facebookObject();
			$FBUserId = $facebook->getUser();
			if($FBUserId){
				$this->manageFBUser();
			}
		}
	
	}

/**
 * Display setting page when user clicks on My Account link 
 */
 	public function myAccount()
 	{
 		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/users/login");
		}
		switch($session->getUserRole()){
			case COMPANY:
					$this->redirect(array('controller'=>'Companies','action'=>'accountProfile'));
					break;	
			case JOBSEEKER:
					$this->redirect(array('controller'=>'jobseekers'));
					break;
			case NETWORKER:
					$this->redirect(array('controller'=>'networkers'));
					break;
			case ADMIN:
					$this->redirect(array('controller'=>'admin'));
					break;
			default:
					$this->redirect('/');
		}
 	}

/**
 * To change users account password
 */

	public function changePassword(){
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/users/login");
		}
		$facebookUser=$this->User->find('first',array('conditions'=>
													array('id'=>$session->getUserId(),
													'password'=>'NULL'),
													'fields'=>'password,id,fb_user_id,',
													)
										);
		$facebookUserData=null;
		if(isset($facebookUser) && $facebookUser['User']['fb_user_id']!=0){
			$facebookUserData = $facebookUser['User']['fb_user_id'];
		}		
		$this->set('facebookUserData',$facebookUserData);
		if(isset($this->data['User'])){

			//check for blank or empty field
			if(empty($this->data['User']['oldPassword']) && $facebookUserData==null){
				$this->set("old_password_error","Old Password Required");
				if($session->getUserRole() == ADMIN){
					$this->render("change_password","admin");
				}
				return;
			}
			
			// Password hashing
			$this->data['User']['id'] = $session->getUserId();
			if(empty($this->data['User']['oldPassword']) && isset($facebookUser) ){
				$this->data['User']['oldPassword']='NULL';
			}else{
				$this->data['User']['oldPassword']=$this->Auth->password($this->data['User']['oldPassword']);
			}
			$this->data['User']['password']=$this->Auth->password($this->data['User']['password']);			
								
			//Check old password match
			$userData= $this->User->find('first',array('conditions'=>array('id'=>$this->data['User']['id'], 
																	'password'=>$this->data['User']['oldPassword'])));
			
			//set User data
			$this->User->set($this->data['User']);
			
			//Validate user data
			if($this->User->validates(array('fieldList'=>array('password','repeat_password')))){
			
				if(!isset($userData['User'])){	
					unset($this->data['User']);
					$this->Session->setFlash("Old password not matched!.","error");
					if($session->getUserRole() == ADMIN){
						$this->render("change_password","admin");
					}
					return;
				}			
			
				if(isset($userData['User']['password']) && $userData['User']['password']==$this->data['User']['password']){
				$this->Session->setFlash("Old password and new password are same. Please try with different password","error");
				unset($this->data['User']);
				if($session->getUserRole() == ADMIN){
					$this->render("change_password","admin");
				}
				return;			
				}
			
			
			
				$this->User->updateAll(array('password'=>"'".$this->data['User']['password']."'"),array('id'=>$this->data['User']['id'], 'password'=>$this->data['User']['oldPassword']));
				
				//check row update or not
				if(mysql_affected_rows()>0){
					unset($this->data['User']);
					$this->Session->setFlash("Password changed successfully.","success");
					switch($session->getUserRole()){
						case COMPANY:
								$this->redirect(array('controller'=>'Companies','action'=>'accountProfile'));
								break;	
						case JOBSEEKER:
								$this->redirect(array('controller'=>'jobseekers'));
								break;
						case NETWORKER:
								$this->redirect(array('controller'=>'networkers'));
								break;
						case ADMIN:
								$this->redirect(array('controller'=>'admin'));
								break;
						default:
								$this->Session->SetFlash('Internal Error!','error');
								$this->redirect('/');
					}
				}
				elseif(mysql_affected_rows()==0){
					unset($this->data['User']);
					$this->Session->setFlash("Change password process failed, Try again!.","error");
					if($session->getUserRole()==ADMIN){
						$this->render("change_password","admin");
					}
					return;
				}elseif(mysql_affected_rows()<0){	//check for server problem
					unset($this->data['User']);
					$this->Session->setFlash("Server problem!","error");
					if($session->getUserRole()==ADMIN){
						$this->render("change_password","admin");
					}
					return;
				}
			}else{
				unset($this->data['User']);
				if($session->getUserRole()==ADMIN){
					$this->render("change_password","admin");
				return;
				}
			}
		}
		
		if($session->getUserRole()==ADMIN){
			unset($this->data['User']);
			$this->render("change_password","admin");
		}
	}

	function forgotPassword(){
		
		$session = $this->_getSession();
		if($session->isLoggedIn()){
			$this->redirect('loginSuccess');
		}

		if(isset($this->data['User'])){
			$userEmail = trim($this->data['User']['user_email']);
			$user = $this->User->find('first',array('conditions'=>array('account_email'=>$userEmail)));
			if(!$user['User'] && !isset($user['User'])){
				$this->Session->SetFlash('Not a valid email , Please try again .!','error');
				return;
			}
			if($user['User']['is_active']==1 && $user['User']['is_active']){
				$newPassword = substr(md5(uniqid(mt_rand(), true)), 0, 6);
				$user['User']['password'] =$this->Auth->password($newPassword);
				$to =$userEmail;
				$subject = 'Hire-Routes :: Account Password';
				$template = 'forgot_password';
					
				if($this->User->save($user['User'])){
					$user['User']['password'] = $newPassword;
					if($this->sendEmail($to,$subject,$template,$user['User'])){
						$this->Session->setFlash('Your password is send to your email address','success');
						$this->redirect('/users/login');		
					}
				}else{
					$this->Session->SetFlash('Internal Error!','error');
				}
			}
			if($user['User']['is_active']==0 && $user['User']['confirm_code']=="" ){
				$this->Session->setFlash('You are not activated, Please contact your system administrator', 'warning');
			}
			if($user['User']['is_active']==0 && $user['User']['confirm_code']!="" ){
				$this->Session->setFlash('Your account is not activated/confirmed, please check your email for confirmation link!', 'warning');
			}
		}
	}
		
	function loginSuccess(){
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/users/login");
		}
		$data['User']['id']= $session->getUserId();
		$data['User']['last_login']=date('Y-m-d H:i:s'); 
		$this->User->save($data);
		$userRole = $this->_getSession()->getUserRole();
		switch($userRole){
			case COMPANY:
					$this->redirect("/companies/newJob");
					break;	
			case JOBSEEKER:
					$this->redirect("/jobseekers/newJob");						
					break;			
			case NETWORKER:
					$this->redirect("/networkers/newJob");						
					break;		
			case ADMIN:
					$this->redirect("/admin");
					break;	
			default:
				$this->redirect("/");	
		}
	}
	
	function beforeLoggedIn($active_user){
		if(!$active_user ){
			$this->Session->setFlash('Username or password not matched.', 'error');	
			$this->redirect("/users/login");
		}
				
		/**	@user not acitvated (AND deactivated by Admin)	**/			
		if($active_user['User']['is_active']==0 && $active_user['User']['confirm_code']=="" ){
			$this->Session->setFlash('You are not activated, Please contact your system administrator', 'error');
			$this->redirect("/users/login");
		}
	
		/**	@user not acitvated (AND not confirmed account by clicking on link in email)	**/
		if($active_user['User']['is_active']==0 && $active_user['User']['confirm_code']!="" ){
			$this->sendConfirmationEmail($active_user['User']['id']);
			$this->Session->setFlash('Your account is not activated/confirmed, we have sent an email, please check your email for confirmation link!', 'warning');
			$this->redirect("/users/login");
		}
	
		/**	@user not acitvated	**/			
		if($active_user['User']['is_active']==0){
			$this->Session->setFlash('Username or password not matched.', 'error');	
			$this->redirect("/users/login");
		}
	
	}
	
	function validateIcCode(){
		$ic_code = $this->Session->read('icc');
		if( isset($ic_code) && $ic_code  != '' ){
			$invitationDetail =$this->Invitations->find('first', array('conditions'=>array('ic_code'=>$ic_code)));
			if(isset ($invitationDetail ) && $invitationDetail != null)
				return true;
			else{
				$this->Session->delete('icc');
				$this->Session->delete('intermediateCode');
				return false;
			}
		}else{
			return true;
		 }
	}
	
	public function invitations() {
 	 	$session = $this->_getSession();
		if($this->RequestHandler->isAjax()){
			$this->autoRender =false;
			if(!$session->isLoggedIn() && $this->params['form']['source'] == 1){
				$this->Session->write('inviteFlag',1);
				$this->Session->setFlash('Please loign to send invitation.', 'error');				
				return json_encode(array("status"=>"0"));
			}else{
				if($session->isLoggedIn() && $this->params['form']['source'] == 1){
					return json_encode(array("status"=>"3"));
				}
				if($this->Session->read('inviteFlag') == 1 && $session->isLoggedIn() ){
					$this->Session->delete('inviteFlag',0);
					return json_encode(array("status"=>"1"));
				}else{
					return json_encode(array("status"=>"2"));
				}
			}
		}
 	 	if(!$session->isLoggedIn()){
 	 		$userId = $session->getUserId();
			switch($session->getUserRole()){		
				case COMPANY:
						$this->redirect("/companies/invitations");
						break;
				case JOBSEEKER:
						$this->redirect("/jobseekers/invitations");
						break;
				case NETWORKER:
						$this->redirect("/networkers/invitations");
						break;		
			}
        }
	 }
	 
	 function saveLinkedinUser(){
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
    	$linkedin->request_token = unserialize($this->Session->read("requestToken"));
        $verifier = unserialize($this->Session->read("verifier"));
        $linkedin->oauth_verifier = $verifier;
        //$linkedin->getAccessToken($verifier);
    	$linkedin->access_token = unserialize($this->Session->read("accessToken"));
    	$xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url)");
    	$response=simplexml_load_string($xml_response);
    	$firstName = "first-name";
    	if( isset($response->id) ){
			$userData = array();
			$userData['account_email'] =  $response->$firstName.rand(10,100)."@linkedin.com";
			$userData['linkedin_token'] = serialize($linkedin->access_token);
			$userData['password'] = 'NULL';
			if($this->params['userType'] ==3 ){
				if(isset($this->data['Networkers']) && $this->data['Networkers']['university']!= null ){
					$user['graduate_degree_id'] = $this->data['Networkers']['graduate_degree_id'];
					$user['graduate_university_id'] = $this->data['Networkers']['graduate_university_id'];
					$user['university'] = $this->data['Networkers']['university'];
				}else{
					$this->Session->setFlash("Please fill correct information.","error");
					$this->redirect("/users/facebookUserSelection");
				}
			}
			if($userId = $this->saveUser($userData)){
				$userRole = $this->params['userType']; // 2=>JOBSEEKER,3=>NETWORKER
				$this->saveUserRoles($userId,$userRole);
				$userCCode = $this->User->find('first',array(	
																'conditions'=>array('User.id'=>$userId), 
																'fields'=>'User.confirm_code'));
			
				$userData['confirm_code'] = $userCCode['User']['confirm_code'];
				$user['user_id'] = $userId;
				$user['contact_name'] = $response->$firstName;
				switch($userRole){
					case JOBSEEKER:
						if($this->Jobseekers->save($user,false) ){
							$this->Utility->deleteInvitationCode();
							$this->confirmAccount($userId,$userData['confirm_code']);
							$this->Session->delete('requestToken');
							$this->Session->delete("accessToken");
							$this->redirect("/users/firstTime");
						}
						break;
					case NETWORKER:
						if($this->Networkers->save($user,false) ){	
							$this->Utility->deleteInvitationCode();
							$this->confirmAccount($userId,$userData['confirm_code']);
							$this->Session->delete('requestToken');										
							$this->Session->delete("accessToken");										
							$this->redirect("/users/firstTime");
						}
						break;					
				}	
			}
		}else{
			$this->Session->setFlash('Some thing is going wrong .Please try again later.', 'error');	
			$this->redirect("/users/login");
		}
	 }
	 
	 function linkedinUserSelection(){
	 	$session = $this->_getSession();
		if($session->isLoggedIn()){
			$this->redirect('loginSuccess');
		}
		$graduateDegrees = $this->GraduateDegree->find('list',array('fields'=>'id, degree'));	
		$this->set("graduateDegrees",$graduateDegrees);
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
    	$linkedin->request_token = unserialize($this->Session->read("requestToken"));
        $verifier = unserialize($this->Session->read("verifier"));
        $linkedin->oauth_verifier = $verifier;
        $linkedin->getAccessToken($verifier);
		if( isset( $linkedin->access_token)){
	        $this->Session->write('accessToken', serialize($linkedin->access_token));
	        
			$liData = $this->User->find('first',array('conditions'=>array('User.linkedin_token'=>serialize($linkedin->access_token) ),'fields'=>'User.*'));
			if( isset($liData) && $liData != null ){
				$this->setUserAsLoggedIn($liData['User']);
				$this->Session->delete('requestToken');
				$this->redirect("/users/loginSuccess");
			}else{
			
			}
		}else{
			$this->Session->setFlash('Some thing is going wrong .Please try again later.', 'error');	
			$this->redirect("/users/login");
		}
	 }
	 


}

?>
