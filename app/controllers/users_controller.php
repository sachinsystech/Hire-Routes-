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
    var $uses = array(
					'User',
					'Companies',
					'UserRoles',
					'Networkers',
					'Jobseekers',
					'FacebookUsers',
					'NetworkerSettings',
					'JobseekerSettings',
					'Acos',
					'Aros',
					'ArosAcos',
					'Specification',
					'State',
					'City',
					'Industry',
					'Code'
					);
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','Acl','TrackUser','Utility');
					
	var $helpers = array('Form');

/**
 * Called before the UserController action.
**/
	public function beforeFilter(){
		parent::beforeFilter();
		//Configure AuthComponent
		$this->Auth->authorize = 'actions';
		//$this->Auth->authError = __('You do not have permission to access the page you just selected.', true);
		$this->Auth->loginAction = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('plugin' => '', 'controller' => 'pages', 'action' => 'index');
		$this->Auth->autoRedirect = false; // Set to false in order to save last_login time
		$this->Auth->allow('logout'); // Allow logout to everybody
		$this->Auth->allow('login');
		$this->Auth->allow('index');

		$this->Auth->allow('jobseekerSignup');		
		$this->Auth->allow('networkerSignup');		
		$this->Auth->allow('companyRecruiterSignup');
		$this->Auth->allow('userSelection');
		$this->Auth->allow('account');		
		$this->Auth->allow('confirmation');		
		$this->Auth->allow('saveFacebookUser');
		$this->Auth->allow('facebookUser');
		$this->Auth->allow('facebookUserSelection');
		$this->Auth->allow('accountConfirmation');		
		//$this->Auth->allow('jobseekerSetting');						
		//$this->Auth->allow('changePassword'); // if the user is anonymous he should not be allowed to change password
	}

/**
 * Called as default action for UserController.
**/	
	function index(){
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");				
			
		}
		else{
			$this->redirect("/users/userSelection");
		}
    }
/**
 * Displays a view to choose which type of user you want to register if user is not logged-in, 
 * Redirecting respactive my-account page otherwise(If user logged-in). 
**/
	function userSelection(){
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");	
		}
	}

/**
 * Display Company/Recruiter registration view.
**/ 
	function companyRecruiterSignup(){
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");	
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
				$userRoleId = 1;
				$this->saveUserRoles($userId,$userRoleId);				
				$company = array();
				$company = $this->data['Companies'];
				$company['user_id'] = $userId;
				$company['act_as'] = $this->data['Companies']['role'];
				if( $this->Companies->save($company) ){			
					$this->sendCompanyAccountEmail($userId);
					$this->redirect("confirmation/".$userId);
					return;
				}
				else{
					$this->Session->setFlash('Server busy, please try after some Time.', 'error');
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
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");	
		}
		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
			    unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
                return;
			}
			/*	Validating Restrict_Code	*/
			if(!$this->validateCode()){
				return;
			}

			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('tc-errors', "You must agree to the Terms and Conditions");
				return;
			}			

			if( $userId = $this->saveUser($this->data['User']) ){
				$userRoleId = 3;
				$this->saveUserRoles($userId,$userRoleId);
				$networker = array();
				$networker['user_id'] = $userId;
				if( $this->Networkers->save($networker) ){			
					$this->sendConfirmationEmail($userId);
					$code = $this->findCodeFor('Networker');
					$code['remianing_signups']--;
					$this->Code->save($code);
					if($code['remianing_signups']<1){
						$this->Code->delete($code);
					}
					$this->redirect("confirmation/".$userId);
				}
				else{
					$this->Session->setFlash('Server busy, please try after some Time.', 'error');
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
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");	
		}
		
		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
                unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
   			    $this->render("jobseeker_signup");
				return;
			}
			
			/*	Validating Restrict_Code	*/
			if(!$this->validateCode()){
				return;
			}
			
			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("jobseeker_signup");
				return;
			}
			
			if( $userId = $this->saveUser($this->data['User']) ){
				$userRoleId = 2;
				$this->saveUserRoles($userId,$userRoleId);
				$jobseeker = array();
				$jobseeker['user_id'] = $userId;
				if( $this->Jobseekers->save($jobseeker) ){			
					$this->sendConfirmationEmail($userId);
					
					$code = $this->findCodeFor('Jobseeker');
					$code['remianing_signups']--;
					$this->Code->save($code);
					if($code['remianing_signups']<1){
						$this->Code->delete($code);
					}
					$this->redirect("confirmation/".$userId);
				}
				else{
					$this->Session->setFlash('Server busy, please try after some Time.', 'error');
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
		if(empty($this->data['Code']['code'])){
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
        if($parent = $this->Utility->getRecentUserIdFromCode())
            $userData['User']['parent_user_id'] = $parent;
		if(!$this->User->save($userData)){
			$this->Session->setFlash('Server busy, please try after some Time.', 'error');
			$this->redirect("/");
			return;
		}
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
			$this->Session->setFlash('Server busy, please try after some Time.', 'error');
			$this->redirect("/");
			return;
		}
	}
/**
 * send comfirmation email for jobseeker and networker, if signed-up successfully.
 * e-mail contains account confirmation link.
 * @access private
 */
	private function sendConfirmationEmail($id){		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		try{
			$this->Email->to = $user['User']['account_email'];
			$this->Email->subject = 'Hire Routes : Account Confirmation';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'user_account_confirmation';
			$this->Email->sendAs = 'html';
			$this->set('user', $user['User']);
			$this->Email->send();
		}catch(Exception $e){
			//echo 'Message: ' .$e->getMessage();
			$this->Session->setFlash('Server busy, please try after some Time.', 'error');
			$this->redirect("/");
			return;
		}		
	}
/**
 * send comfirmation email for company/recruiter, if signed-up successfully.
 * @access private
 */	
	private function sendCompanyAccountEmail($id){		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		try{
			$this->Email->to = $user['User']['account_email'];
			$this->Email->subject = 'Hire Routes : Account Registration';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'company_user_registration';
			$this->Email->sendAs = 'html';
			$this->set('user', $user['User']);
			$this->Email->send();
		}catch(Exception $e){
			//echo 'Message: ' .$e->getMessage();
			$this->Session->setFlash('Server busy, please try after some Time.', 'error');
			$this->redirect("/");
			return;
		}		
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
				$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$id)));
				if($userRole['UserRoles']['role_id']==1){
					$this->set('roleId',1);
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
		$userId = $this->params['id'];
		$confirmCode = $this->params['code'];
		$this->set('userId', $userId);
		$this->set('confirmCode', $confirmCode);
	}
/**
 * after click on confirmation link match confirm code and activate user.
 */
	function confirmAccount($userId,$confirmCode){
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId,'User.confirm_code'=>$confirmCode)));
		if(isset($user['User']['confirm_code']) && isset($user['User']['id'])){
			$user['User']['is_active'] = '1';
			
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
				$this->Session->setFlash('Server busy, please try after some Time.', 'error');
				$this->redirect("/");
				return;
			}	
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
			$this->Auth->login($data);
		}	
	}	
/**
 * display first time page when user click on confirmation link.
 * redirect users to respective setting pages if they setting up their account.
 */
	function firstTime() {
		$id = $this->TrackUser->getCurrentUserId();
		$role = $this->TrackUser->getCurrentUserRole();
		switch($role['role_id']){
			case 1:
					$this->redirect("/companies");
					break;	
			case 2:
					$jobseekerData = $this->Jobseekers->find('first',array('conditions'=>array('Jobseekers.user_id'=>$id)));
					if(isset($jobseekerData['Jobseekers']['contact_name'])){
						$this->redirect("/jobseekers");						
					}
					break;			
			case 3:
					$networkerData = $this->Networkers->find('first',array('conditions'=>array('Networkers.user_id'=>$id)));
					if(isset($networkerData['Networkers']['contact_name'])){
						$this->redirect("/networkers");						
					}
					break;		
			case 5:
					$this->redirect("/admin");
					break;	
		}
		$this->set('roleName', $role['role_id']);
	}
/**
 * create facebook object.
 * @return an array of facebook object 
 */	
	function facebookObject() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
		));
		return $facebook;
	}
/**	
 * Tracking facebook users, whether he/she is first-time or existing user.... 
 */
	function facebookUser() {
		$facebook = $this->facebookObject();
		$user = $facebook->getUser();
		if($user){
			try {
				if(!$faceBookUserData = $this->isExistFBUser($user)){
					$this->redirect("/users/facebookUserSelection");
				}
			    // for login current facebook user.
			    
				$user_account = $this->User->find('first',array('conditions'=>array('User.fb_user_id'=>$user)));
				$this->setUserAsLoggedIn($user_account['User']);
				if($user_account['UserRoles']['0']['role_id']== 2){
					$this->redirect("/users/jobseekerSetting");				
					return;
				}
				if($user_account['UserRoles']['0']['role_id']== 3){
					$this->redirect("/users/networkerSetting");				
					return;
				}				    
				$this->redirect("/users/firstTime");				
				$this->set('FBloginlogoutUrl',$facebook->getLogoutUrl());
				$this->set('fbButtonClass','fb-logout');
				$this->set('faceBookUserData',$faceBookUserData['FacebookUsers']);
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
				$this->redirect("/");
				return;
			}
			
		}
		else{ 
			$this->redirect("/");
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
		$userData['account_email'] = $fb_user_profile['id']."_fbuser@dummy.mail";
		$userData['password'] = $fb_user_profile['id'];	
		$userData['fb_user_id'] = $fb_user_profile['id'];
		if($userId = $this->saveUser($userData)){
			$userRoleId = $this->params['userType']; // 2=>Jobseeker,3=>Networker
			$this->saveUserRoles($userId,$userRoleId);
			$fb_user_profile['facebook_id'] = $fb_user_profile['id'];
			$fb_user_profile['user_id'] = $userId;

			if($this->FacebookUsers->save($fb_user_profile)){
				$user_account = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
				$confirmCode = $user_account['User']['confirm_code'];
				if($this->confirmAccount($userId,$confirmCode)){ //this will confirm account and set user as logged-in.
					if($userRoleId== 2){						//ask to become Networker or Jobseeker.
						$this->redirect("/users/jobseekerSetting");					
						return;
					}
					if($userRoleId== 3){
						$this->redirect("/users/networkerSetting");				
						return;
					}
				}		
			}
			else{
				$this->Session->setFlash('Server busy, please try after some Time.', 'error');
				$this->redirect("/");
				return;
			}	
		}		
	}		
/**	
 * check FB-User exist or not
 * @return FB-User info OR Null
 */
	function isExistFBUser($facebookUser){
		$FB_USER = $this->FacebookUsers->find('first',array('conditions'=>array('FacebookUsers.facebook_id'=>$facebookUser)));
		return $FB_USER;
	}
/**
 * Log-in a user with the given parameter account_email and password
 * use AuthComponent to authenticate...
 * @return boolean True on login success, false on failure
 * @access public
 */
	function login() {
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");				
			
		}

		if(isset($this->data['User'])){
			$data = array('User' => array('account_email' => $this->data['User']['username'],
										  'password' => Security::hash(Configure::read('Security.salt') .$this->data['User']['password'])
										  ));
			$this->Auth->fields = array(
				'username' => 'account_email',
				'password' => 'password'
			);
			if(!$this->Auth->login($data)){
				$this->Session->setFlash('Username or password not matched.', 'error');	
			
			}else{
				$this->redirect("/users/firstTime");		
			}
		}	
	}
/**
 * Logs a user out, and returns the home page to redirect to.
 * @access public
 */	
	function logout() {
		$this->Auth->logout();
        $this->Session->delete('code');
		$this->redirect("/home/index");		
	}	
/**
 * Ask facebook user to become Jobseeker OR Networker
 * @access public
 */	
	function facebookUserSelection(){
		
	}
	
}
?>
