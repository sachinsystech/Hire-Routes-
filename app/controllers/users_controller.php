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
					'UserRules',
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
	var $components = array('Email','Session','Bcp.AclCached', 'Cookie','Auth', 'Security', 'Bcp.DatabaseMenus','Acl','TrackUser','Utility');
				
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
		$this->Auth->allow('myAccount');	
		$this->Auth->allow('forgotPassword');	
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
 * Redirecting respactive my-account page (If user logged-in). 
**/
	function userSelection(){
		if($this->TrackUser->isUserLoggedIn()){
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
				if($this->Companies->save($company) ){			
					$this->sendConfirmationEmail($userId);
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
		
		$codeFlag=true;
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
			if($this->Session->read('code')=='' || $this->Session->read('code')== null){
				if(!$this->validateCode()){
					return;
				}
			}else{ 
				$codeFlag=false;
			}
			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
   	            unset($this->data["User"]["repeat_password"]);
			    $this->set('tc-errors', "You must agree to the Terms and Conditions");
				return;
			}			
	
			if($userId = $this->saveUser($this->data['User']) ){
				$userRoleId = 3;
				$this->saveUserRoles($userId,$userRoleId);
				$networker = array();
				$networker['user_id'] = $userId;
				if($this->Networkers->save($networker,false) ){			
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
		$codeFlag=true;
		$transaction_validity=false;
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/firstTime");	
		}

		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
                //echo "<pre>"; print_r($this->User);exit;
                unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
   			    $this->render("jobseeker_signup");
				return;
			}
			/*	Validating Restrict_Code	*/
			if($this->Session->read('code')=='' || $this->Session->read('code')== null){
				if(!$this->validateCode()){
					return;
				}
			}else $codeFlag=false;

			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("jobseeker_signup");
				return;
			}
			if($userId = $this->saveUser($this->data['User']) ){
				$userRoleId = 2;
				if(!$this->saveUserRoles($userId,$userRoleId))
				{
					$this->Session->setFlash('Internal Error!', 'error');
					return;
				}
				$jobseeker = array();
				$jobseeker['user_id'] = $userId;
				if($this->Jobseekers->save($jobseeker,false)){
					$this->sendConfirmationEmail($userId);
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
            $userData['User']['parent_user_id'] = $parent;
		}
		if(!$this->User->save($userData)){
			$this->Session->setFlash('Internal Error!', 'error');
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
		$userRole = $user['UserRoles'][0]['role_id'];
		switch($userRole){
			case 1:
				$template = 'company_user_registration';
				break;			
			case 2:
				$template = 'user_account_confirmation';
				break;			
			default:
				$template = 'user_account_confirmation';			
		}
		$to = $user['User']['account_email'];
		$subject = 'Hire Routes : Account Confirmation';
		$message =  $user['User'];
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
			$user['User']['confirm_code']="";
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
			
			if($this->Auth->login($data)){
				$this->Session->write('user_role',$this->TrackUser->getCurrentUserRole());
			}
			
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
					$this->redirect("/companies/newJob");
					break;	
			case 2:
					$jobseekerData = $this->Jobseekers->find('first',array('conditions'=>array('Jobseekers.user_id'=>$id)));
					if(isset($jobseekerData['Jobseekers']['contact_name'])){
						$this->redirect("/jobseekers/newJob");						
					}
					break;			
			case 3:
					$networkerData = $this->Networkers->find('first',array('conditions'=>array('Networkers.user_id'=>$id)));
					if(isset($networkerData['Networkers']['contact_name'])){
						$this->redirect("/networkers/newJob");						
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
				$this->Session->setFlash('An Internal Error has been occured...', 'error');
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
			$this->redirect("/users/myaccount");				
			return;
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
																		'is_active'=>1,
																		)
															)
													);
			if(!$active_user ){
				$this->Session->setFlash('Username or password not matched.', 'error');	
				$this->redirect("/users/login");
			}
			$this->Auth->fields = array(
				'username' => 'account_email',
				'password' => 'password'
			);
	
			if(!$this->Auth->login($data)){
				$this->Session->setFlash('Username or password not matched.', 'error');				
			}else{
				$userData=$this->User->find('first',array('conditions'=>array("id"=>$this->TrackUser->getCurrentUserId())));
				$welcomeUserName = 'User';	
				switch($userData['UserRoles'][0]['role_id']){
					case 1:
							if(isset($userData['Companies'][0]['contact_name']))
								$welcomeUserName = $userData['Companies'][0]['contact_name'];
							break;
					case 2:
							if(isset($userData['Jobseekers'][0]['contact_name']))
								$welcomeUserName = $userData['Jobseekers'][0]['contact_name'];
							break;
					case 3:
							if(isset($userData['Networkers'][0]['contact_name']))
								$welcomeUserName = $userData['Networkers'][0]['contact_name'];
							break;
				}
				$this->Session->write('welcomeUserName',$welcomeUserName);
				$this->Session->write('user_role',$this->TrackUser->getCurrentUserRole());
				$redirectTo=$this->Session->read('redirection_url');
				$this->Session->delete('redirection_url');
				if(isset($redirectTo)&&!empty($redirectTo)){
					$this->redirect($redirectTo);
				}
				$this->redirect("/users/firstTime");
			}
		}
		$this->setRedirectionUrl();
	}

/**
 * Logs a user out, and returns the home page to redirect to.
 * @access public
 */	
	function logout() {
		$this->Auth->logout();

        $this->Session->delete('code');
		$this->Session->delete('welcomeUserName');
		$this->Session->delete('user_role');
		$this->Session->delete('Twitter');

		$this->redirect("/home/index");		
	}	
/**
 * Ask facebook user to become Jobseeker OR Networker
 * @access public
 */	
	function facebookUserSelection(){
		
	}

/**
 * Display setting page when user clicks on My Account link 
 */
 	public function myAccount()
 	{
 		$id = $this->TrackUser->getCurrentUserId();
		$role = $this->TrackUser->getCurrentUserRole();
		switch($role['role_id']){
			case 1:
					$this->redirect(array('controller'=>'Companies','action'=>'accountProfile'));
					break;	
			case 2:
					$this->redirect(array('controller'=>'jobseekers'));
					break;
			case 3:
					$this->redirect(array('controller'=>'networkers'));
					break;
			case 5:
					$this->redirect(array('controller'=>'admin'));
					break;
			default:
					$this->Session->SetFlash('Internal Error!','error');
					$this->redirect('/');
		}
 	}

/**
 * To change users account password
 */

	public function changePassword(){
		$user_role=$this->Session->read('user_role');
		if(isset($this->data['User'])){
			//check for blank or empty field
			if(empty($this->data['User']['oldPassword'])){
				$this->set("old_password_error","Old Password Required");
				if($user_role['role_id']==ADMIN){
					$this->render("change_password","admin");
				}
				return;
			}
			
			// Password hashing
			$this->data['User']['id'] = $this->TrackUser->getCurrentUserId();
			$this->data['User']['password']=$this->Auth->password($this->data['User']['password']);
			$this->data['User']['oldPassword']=$this->Auth->password($this->data['User']['oldPassword']);
			
			
			//Check old password match
			if(!$this->User->find('first',array('conditions'=>array('id'=>$this->data['User']['id'], 'password'=>$this->data['User']['oldPassword'])))){
				unset($this->data['User']);
				$this->Session->setFlash("Old password not matched!.","error");
				if($user_role['role_id']==ADMIN){
					$this->render("change_password","admin");
				}
				return;
			}
			
			//set User data
			$this->User->set($this->data['User']);
			
			//Validate user data
			if($this->User->validates(array('fieldList'=>array('password','repeat_password')))){
				$this->User->updateAll(array('password'=>"'".$this->data['User']['password']."'"),array('id'=>$this->data['User']['id'], 'password'=>$this->data['User']['oldPassword']));
				
				//check row update or not
				if(mysql_affected_rows()>0){
					unset($this->data['User']);
					$this->Session->setFlash("Password changed successfully.","success");
					switch($user_role['role_id']){
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
					if($user_role['role_id']==ADMIN){
						$this->render("change_password","admin");
					}
				}elseif(mysql_affected_rows()<0){	//check for server problem
					unset($this->data['User']);
					$this->Session->setFlash("Server problem!","error");
					if($user_role['role_id']==ADMIN){
						$this->render("change_password","admin");
					}
					return;
				}
			}else{
				unset($this->data['User']);
				if($user_role['role_id']==ADMIN){
					$this->render("change_password","admin");
				return;
				}
			}
		}
		if($user_role['role_id']==ADMIN){
			$this->render("change_password","admin");
		}
	}

/**
 * To store before Authenticate URL
 */	
	private function setRedirectionUrl(){
		$redirect_url=$this->referer();
		if(preg_match('/^\/jobs\/jobDetail\/[0-9]+$/',$redirect_url)){
			$this->Session->write('redirection_url',$redirect_url);
		}
		return true;
	}

	function forgotPassword(){
		
		if($this->TrackUser->isHRUserLoggedIn()){
			$this->redirect("/users/myAccount");				
			return;
		}

		if(isset($this->data['User'])){
			$userEmail = trim($this->data['User']['user_email']);
			$user = $this->User->find('first',array('conditions'=>array('account_email'=>$userEmail)));
			if(!$user['User']){
				$this->Session->SetFlash('Account with this Email is not registered!','error');
				return;
			}
			if($user['User']['is_active']===1 && $user['User']['is_active']){
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
			}else{
				$this->Session->SetFlash('Please contact to side admin!.','error');
			}
			$this->redirect('/users/forgotPassword');
		}
	}

}
?>
