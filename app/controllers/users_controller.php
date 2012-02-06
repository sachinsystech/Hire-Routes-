<?php require_once(APP_DIR.'/vendors/facebook/facebook.php'); ?>

<?php
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
					'Industry'
					);
	var $components = array('Email','Session','Bcp.AclCached', 'Auth', 'Security', 'Bcp.DatabaseMenus','Acl');
					
	var $helpers = array('Form');

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
	
	function index(){
		if($this->Session->read('Auth.User.id')==2 || !$this->Session->read('Auth.User.id')){
			$this->redirect("/users/userSelection");
		}
		else{
			$this->redirect("/users/firstTime");				
		}

    }

	function userSelection(){
		if($this->Session->read('Auth.User.id')>2 ){
			$this->redirect("/users/firstTime");	
		}
	}
    
	function confirmation(){
		$id = $this->params['id'];
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		if($user){
			if(!$user['User']['is_active']){
				$this->set('confirmation_email', $user['User']['account_email']);
				$this->Session->setFlash('Account confirmation is required. Please, check your email for the confirmation link.', 'success');		
			}
			else{
				$this->redirect("/users/firstTime");				
			}
		}
		else{
			echo "Sorry User not exist.."; exit;
		}
	}

	function companyRecruiterSignup(){

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
					//$this->sendConfirmationEmail($userId);
					$this->redirect("confirmation/".$userId);
				}
			}
		}
	}

	function networkerSignup() {	
		if($this->Session->read('Auth.User.id') > 2){
			$this->redirect("/users/firstTime");							
		}

		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
			    unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
				$this->render("networker_signup");
				return;
			}
			
			if(!$this->data['User']['agree_condition']){
				unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("networker_signup");
				return;
			}

			if( $userId = $this->saveUser($this->data['User']) ){
				$userRoleId = 3;
				$this->saveUserRoles($userId,$userRoleId);
				$networker = array();
				$networker['user_id'] = $userId;
				if( $this->Networkers->save($networker) ){			
					$this->sendConfirmationEmail($userId);
					$this->redirect("confirmation/".$userId);
				}
			}
		}	
	}

	function jobseekerSignup(){
		if($this->Session->read('Auth.User.id') > 2){
			$this->redirect("/users/firstTime");							
		}
		if(isset($this->data['User'])){
			if(!$this->User->saveAll($this->data,array('validate'=>'only'))){
                unset($this->data["User"]["password"]);
                unset($this->data["User"]["repeat_password"]);
   			    $this->render("jobseeker_signup");
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
					$this->redirect("confirmation/".$userId);
				}
			}
		}	
	}
	
	private function saveUser($userData){
		$userData['confirm_code'] = md5(uniqid(rand())); 
		$userData['group_id'] = 0;
		if($this->User->save($userData)){
		}
		else{    
			die('Error: in saving DB....' . mysql_error()); exit;					
		}
	    return $this->User->id;
	}

	private function saveUserRoles($userId,$userRoleId){
		$roles = array();
		$roles['user_id'] = $userId;			
		$roles['role_id'] = $userRoleId;
		$roles['permission'] = "allow";
		$this->UserRoles->save($roles);
	}
	
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
			echo 'Message: ' .$e->getMessage();
		}		
	}
	
	
	function accountConfirmation(){
		$userId = $this->params['id'];
		$confirmCode = $this->params['code'];
		$this->confirmAccount($userId,$confirmCode);
		$this->redirect("firstTime");				

	}
	
	function account() {
		$userId = $this->params['id'];
		$confirmCode = $this->params['code'];
		$this->set('userId', $userId);
		$this->set('confirmCode', $confirmCode);
		/*		
		$this->confirmAccount($userId,$confirmCode);
		$this->redirect("firstTime");	
		*/			

	}

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
		} 
	}		

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
	
	function firstTime() {
		$id = $this->Session->read('Auth.User.id');
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));		
		$role = $this->getCurrentUserRole();
		switch($role['role_id']){

			case 2:
					$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('JobseekerSettings.user_id'=>$id)));
					if($jobseekerData){
						$this->redirect("/users/jobseekerSetting");						
					}
					break;			
			case 3:
					$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$id)));
					if($networkerData){
						$this->redirect("/users/networkerSetting");						
					}
					break;		
			case 5:
					$this->redirect("/admin");
					break;	
		}
		$this->set('roleName', $role['role_id']);
	}
	
	function facebookObject() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
		));
		return $facebook;
	}

	function facebookUser() {
		$facebook = $this->facebookObject();
		$user = $facebook->getUser();
		if($user){
			try {
					if(!$faceBookUserData = $this->isExistFBUser($user)){
						$this->redirect("/users/facebookUserSelection");
					}
				    // Write a code for login current facebook user.
				    
				    
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
			}
			
		}
		else{ 
			$this->redirect("/");
		}		
	}	
	
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
				$this->confirmAccount($userId,$confirmCode); //this will confirm account and set user as logged-in.
				if($userRoleId== 2){
					$this->redirect("/users/jobseekerSetting");				
					return;
				}
				if($userRoleId== 3){
					$this->redirect("/users/networkerSetting");				
					return;
				}	
			}
			else{
				echo "error in saving db.."; exit;
				return;
			}	
		}		
	}		

	function isExistFBUser($facebookUser){
		$FB_USER = $this->FacebookUsers->find('first',array('conditions'=>array('FacebookUsers.facebook_id'=>$facebookUser)));
		return $FB_USER;
	}
	
	function getCurrentUserRole(){
		$userId = $this->Session->read('Auth.User.id');			
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleName  = null;
		switch($userRole['UserRoles']['role_id']){
			case 1:
					$roleName = 'company';
					break;
			case 2:
					$roleName = 'jobseeker';	
					break;			
			case 3:
					$roleName = 'networker';		
					break;			
		}
		$currentUserRole = array('role_id'=>$userRole['UserRoles']['role_id'],'role'=>$roleName);
		return $currentUserRole;
	}
		
	function networkerSetting() {
		$userId = $this->Session->read('Auth.User.id');		
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=3){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$userId)));
			$this->set('NetworkerData',$networkerData);
			
			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
			$cities = $this->City->find('all');
			$city_array = array();
			foreach($cities as $city){
				$city_array[$city['City']['city']] =  $city['City']['city'];
			}
			$this->set('cities',$city_array);
			
			$states = $this->State->find('all');
			$state_array = array();
			foreach($states as $state){
				$state_array[$state['State']['state']] =  $state['State']['state'];
			}
			$this->set('states',$state_array);

			$specifications = $this->Specification->find('all');
			$specification_array = array();
			foreach($specifications as $specification){
				$specification_array[$specification['Specification']['id']] =  $specification['Specification']['name'];
			}
			$this->set('specifications',$specification_array);			
		}
	}

	function jobseekerSetting() {
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=2){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('JobseekerSettings.user_id'=>$userId)));
			$this->set('jobseekerData',$jobseekerData['JobseekerSettings']);
			
			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
			/*$cities = $this->City->find('all');
			$city_array = array();
			foreach($cities as $city){
				$city_array[$city['City']['city']] =  $city['City']['city'];
			}
			$this->set('cities',$city_array);
			*/
			$states = $this->State->find('all');
			$state_array = array();
			foreach($states as $state){
				$state_array[$state['State']['state']] =  $state['State']['state'];
			}
			$this->set('states',$state_array);

			$specifications = $this->Specification->find('all');
			$specification_array = array();
			foreach($specifications as $specification){
				$specification_array[$specification['Specification']['id']] =  $specification['Specification']['name'];
			}
			$this->set('specifications',$specification_array);

		}	
	}
	
	function login() {
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
	
	function logout() {
		$this->Auth->logout();
		$this->redirect("/home/index");		
	}
	
	function isLoggedIn(){
			
	}

	function facebookUserSelection(){
		
	}
	
}
?>
