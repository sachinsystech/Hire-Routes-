<?php require_once(APP_DIR.'/vendors/facebook/facebook.php'); ?>

<?php
class UsersController extends AppController {
    var $uses = array(
					'Users',
					'Companies',
					'UserRoles',
					'Networkers',
					'Jobseekers',
					'FacebookUsers',
					'NetworkerSettings'
					);
	var $components = array('Email','Session');	
					
	var $helpers = array('Form');


	function index(){
		$this->render("user_selection");
    }

	function userSelection(){
	}
    
	function confirmation(){
		$id = $this->params['id'];
		$user = $this->Users->find('first',array('conditions'=>array('Users.id'=>$id)));
		if($user){
			$this->set('confirmation_email', $user['Users']['account_email']);
			$this->Session->setFlash('Account confirmation is required. Please, check your email for the confirmation link.', 'success');		
		}
		else{
			echo "Sorry User not exist.."; exit;
		}
	}

	function companyRecruiterSignup(){
		if(isset($this->data['Users'])){
			
			if(!$this->Users->saveAll($this->data,array('validate'=>'only'))){
				$this->render("company_recruiter_signup");
				return;
			}
			if(!$this->data['Users']['agree_condition']){
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("company_recruiter_signup");
				return;
			}
			
			if( $userId = $this->saveUser($this->data['Users']) ){
				$this->saveUserRoles($userId,$this->data['Users']);
				
				$company = array();
				$company = $this->data['Companies'];
				$company['user_id'] = $userId;
				if( $this->Companies->save($company) ){			
					$this->sendConfirmationEmail($userId);
					$this->redirect("confirmation/".$userId);
				}
			}
		}
	}

	function networkerSignup() {	
		if(isset($this->data['Users'])){
			if(!$this->Users->saveAll($this->data,array('validate'=>'only'))){
				$this->render("networker_signup");
				return;
			}
			
			if(!$this->data['Users']['agree_condition']){
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("networker_signup");
				return;
			}
			
			if( $userId = $this->saveUser($this->data['Users']) ){
				$this->saveUserRoles($userId,$this->data['Users']);
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
		if(isset($this->data['Users'])){
			if(!$this->Users->saveAll($this->data,array('validate'=>'only'))){
				$this->render("jobseeker_signup");
				return;
			}
			
			if(!$this->data['Users']['agree_condition']){
			    $this->set('errors', "You must agree to the Terms and Conditions");
				$this->render("jobseeker_signup");
				return;
			}
			
			if( $userId = $this->saveUser($this->data['Users']) ){
				$this->saveUserRoles($userId,$this->data['Users']);
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
		$this->Users->save($userData);
	    $userId = $this->Users->id;
	    return $userId;
	}

	private function saveUserRoles($userId,$userData){
		$roles = array();
		$roles['user_id'] = $userId;			
		$roles['role_name'] = $userData['role'];
		$roles['permission'] = "allow";
		$this->UserRoles->save($roles);
	}
	
	private function sendConfirmationEmail($id){		
		$user = $this->Users->find('first',array('conditions'=>array('Users.id'=>$id)));
		try{
			$this->Email->to = $user['Users']['account_email'];
			$this->Email->subject = 'Hire Routes : Account Confirmation';
			$this->Email->replyTo = USER_ACCOUNT_REPLY_EMAIL;
			$this->Email->from = 'Hire Routes '.USER_ACCOUNT_SENDER_EMAIL;
			$this->Email->template = 'user_account_confirmation';
			$this->Email->sendAs = 'html';
			$this->set('user', $user);
			$this->set('role_name', $user['UserRoles'][0]['role_name']);
			$this->Email->send();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}		
	}
	
	function account() {
		$userId = $this->params['id'];
		$confirmCode = $this->params['code'];
		$user = $this->Users->find('first',array('conditions'=>array('Users.id'=>$userId,'Users.confirm_code'=>$confirmCode)));
		
		if(isset($user['Users']['confirm_code']) && isset($user['Users']['id'])){
			$user['Users']['is_active'] = '1';
			$roleName = $user['UserRoles'][0]['role_name'];
			$this->Users->save($user['Users']);
			$this->redirect("firstTime/".$roleName);				
		} 
		else{
			echo "Something Wrong...";
		}
		exit;
	}
	
	function firstTime() {
		$roleName = $this->params['role'];
		$this->set('roleName', $roleName);
	}

	function facebookUser() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
		));
		
		$user = $facebook->getUser();
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		
		if($user){
			if($faceBookUserData = $this->isExistFBUser($user)){
			}
			else{
				$faceBookUserData = $this->saveFacebookUser($user_profile);
			}
			$this->set('FBloginlogoutUrl',$facebook->getLogoutUrl());
			$this->set('fbButtonClass','fb-logout');
			$this->set('faceBookUserData',$faceBookUserData['FacebookUsers']);
		}
		else{ 
			$this->redirect("/users");
			$this->set('FBloginlogoutUrl',$facebook->getLoginUrl());		
			$this->set('fbButtonClass','facebook');			
			$this->set('faceBookUserData',null);		
		}		
	}	
	
	function saveFacebookUser($facebookUser){
		$facebookUser['facebook_id'] = $facebookUser['id'];
		if($this->FacebookUsers->save($facebookUser)){
			$FB_USER = $this->isExistFBUser($facebookUser['id']);
			return $FB_USER;	
		}
		else{
			echo "error in saving db.."; exit;
			return;
		}		
	}		

	function isExistFBUser($facebookUser){
		$FB_USER = $this->
		FacebookUsers->
		find('first',array('conditions'=>array('FacebookUsers.facebook_id'=>$facebookUser)));
		return $FB_USER;
	}
	
	
	function networkerSetting() {
		$companies= $this->Companies->find('all');
		$company_names = array();
		foreach($companies as $company){
			$company_names[$company['Companies']['id']] = $company['Companies']['contact_name'];
		}
		$this->set('company_names',$company_names);
		
		$userId = 9;
		$networkers_settings = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.networker_id'=>$userId)));
		
		$networkers_setting_info= array();
		foreach($networkers_settings as $NS){
			$networkers_setting_info[] = $NS['NetworkerSettings'];
		}
		$this->set('networkers_setting_info',$networkers_setting_info);
	}

	function jobseekerSetting() {

	}

}
?>
