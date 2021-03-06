<?php

	require_once(APP_DIR.'/vendors/linkedin/linkedin.php');
	require_once(APP_DIR.'/vendors/linkedin/OAuth.php');
	
	class LinkedinController extends AppController {

    var $uses = array('User','SharedJob','Invitation');
	var $components = array('TrackUser','Utility','RequestHandler');  

	function beforeFilter(){
		parent::beforeFilter();	
    	$this->Auth->allow(array('getLinkedinFriendList',
    						'sendMessagetoLinkedinUser',
							'getResonse',
							'getLinkedinObject',
							'linkedinCallback',
							'sendInvitation',
							));
    	
	}
    
    function getLinkedinFriendList(){
        $this->autoRender = false;
        $linkedin = $this->getLinkedinObject();
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();
        
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'')));
        if($user){
            
           // $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
            $linkedin->access_token =unserialize($user['User']['linkedin_token']);
            $xml_response = $linkedin->getProfile("~/connections:(headline,first-name,last-name,picture-url,id)");
            //print($xml_response);exit;
            $response=simplexml_load_string($xml_response);
            $users = array();
            if($response->status == '403') 
               return json_encode(array('error'=>2));
            
            if($response->status == '401'){
            
				$linkedin->getRequestToken();
		        if($linkedin->request_token){
		        	$this->Session->write('requestToken',serialize($linkedin->request_token));
		        	$this->Session->write('apiSource',$this->params['form']['source']);
		        	echo json_encode(array('error'=>1,'message'=>'User not authenticate from linkedin.','URL'=>$linkedin->generateAuthorizeUrl()));return;
            }
            }
            if(count($response->person)){
                $firstName = 'first-name';
                $lastName = 'last-name';
                $id = 'id';
                $picURL = 'picture-url';
                foreach($response->person as $person){ 
                	$pictureUrl = isset($person->$picURL)?$person->$picURL:'/images/LinkedIn_default.jpg';
                    $users[] = array('name'=>$person->$firstName." ".$person->$lastName,'id'=>"".$person->$id,'url'=>"".$pictureUrl);                
                }             
            }
            return json_encode(array('error'=>0,'data'=>$users));
            if($response->status == '404') echo "Not found11";
               echo json_encode(array('error'=>1,'message'=>'User id is not valid'));
        }else{
            $linkedin->getRequestToken();
            if($linkedin->request_token){
            	$this->Session->write('requestToken',serialize($linkedin->request_token));
            	$this->Session->write('apiSource',$this->params['form']['source']);
            	echo json_encode(array('error'=>1,'message'=>'User not authenticate from linkedin.','URL'=>$linkedin->generateAuthorizeUrl()));
            }
            else{
            	echo json_encode(array('error'=>2));	
            }
        }
    }
   
    function linkedinCallback(){
        $linkedin = $this->getLinkedinObject();
        $userId = $this->_getSession()->getUserId();
        if( isset( $_REQUEST['oauth_problem'] ) &&  $_REQUEST['oauth_problem'] == "user_refused" && $userId ==null ){
        	$this->Session->setFlash('You have declined the request from Linkedin!', 'warning');
			$this->redirect('/users');
        }
        if (isset($this->params['url']['oauth_verifier'])){
        $this->Session->write("verifier",$this->params['url']['oauth_verifier']);
        $this->Session->write("oauth_verifier",$this->params['url']['oauth_verifier']);
        $linkedin->request_token    =   unserialize($this->Session->read("requestToken"));
        $linkedin->oauth_verifier   =   $this->params['url']['oauth_verifier'];
        $linkedin->getAccessToken($this->params['url']['oauth_verifier']);
        if( !isset($linkedin->access_token) && $linkedin->access_token == null)
        {
	    	$this->Session->setFlash("We are apologies, we couldn't process your request at the moment due to internal error", 'error');	
		    $this->redirect("/login");
        }
        $this->Session->write('oauth_access_token',serialize($linkedin->access_token));
            header("Location: " .LINKEDIN_CALLBACK_URL);
            exit;
        }
        else{
             // Now do whatever you want to do
            //$isSignup = true;

            if(!$userId){
                
                // do signup stuff here
            	if(( $this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')== null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null ) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null )){
                   // echo $this->Session->read('oauth_access_token');exit;
					$response= $this->linkedinUserProfile();
					$emailAddress = "email-address";
                    $userEmail = (String)$response->$emailAddress;
                    $liUser = $this->User->find('first',array('conditions'=>
                    										array('AND'=>
                    											array('User.account_email'=>$userEmail,
                    												'User.linkedin_token'=>$this->Session->read('oauth_access_token')),
                    											'User.is_active'=>array(1))));

                    if($liUser){
                     	$data = array('User' => array('account_email' => $liUser['User']['account_email'],
										  'password' => $liUser['User']['password']
										  ));
			            $this->Auth->fields = array(
				            'username' => 'account_email',
				            'password' => 'password'
			            );
						//$this->saveLinkedinToken($liUser['User']['id']);
			            if($this->Auth->login($data,false)){
				            $this->_getSession()->start();
			            }
                        $this->redirect("/users/loginSuccess");
                    }else{
    				    $this->Session->setFlash("You are not authorised user for Hire routes . Please contact to side administrator for better convenience","error");
	               	 	$this->redirect("/login");        	
                    }
            	}else{
    				$response= $this->linkedinUserProfile();
					$emailAddress = "email-address";
                    $userEmail = (String)$response->$emailAddress;
    				$liUser = $this->User->find('first',array('conditions'=>array('User.account_email'=>$userEmail)));
            		if($liUser){
                     	$data = array('User' => array('account_email' => $liUser['User']['account_email'],
										  'password' => $liUser['User']['password']
										  ));
			            $this->Auth->fields = array(
				            'username' => 'account_email',
				            'password' => 'password'
			            );
						$linkedin->request_token    =   unserialize($this->Session->read('requestToken'));
				        $linkedin->oauth_verifier   =   $this->Session->read('oauth_verifier');
				        $linkedin->access_token     =   unserialize($this->Session->read('oauth_access_token'));
				        //$saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
				        $liUser['User']['linkedin_token'] = serialize($linkedin->access_token);
				        $this->User->save($liUser);
			            if($this->Auth->login($data,false)){
				            $this->_getSession()->start();
			            }
                        $this->redirect("/users/loginSuccess");
                    }
                    $this->redirect("/Users/linkedinUserSelection");
                }

            }else{
                // do login stuff here
                $linkedin->request_token    =   unserialize($this->Session->read('requestToken'));
                $linkedin->oauth_verifier   =   $this->Session->read('oauth_verifier');
                $linkedin->access_token     =   unserialize($this->Session->read('oauth_access_token'));

                $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
                $saveUser['User']['linkedin_token'] = serialize($linkedin->access_token);
                $this->User->save($saveUser);
                $this->set('error',false);
            }

        }
    }
	
	function linkedinUserProfile(){
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		$linkedin->request_token    =   unserialize($this->Session->read('requestToken'));
		$linkedin->oauth_verifier   =   $this->Session->read('oauth_verifier');
		$linkedin->access_token     =   unserialize($this->Session->read('oauth_access_token'));
		$xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url,email-address)");
		return(simplexml_load_string($xml_response));
	}
	
	function saveLinkedinToken($userId){
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		$linkedin->request_token    =   unserialize($this->Session->read('requestToken'));
        $linkedin->oauth_verifier   =   $this->Session->read('oauth_verifier');
        $linkedin->access_token     =   unserialize($this->Session->read('oauth_access_token'));
        $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        $saveUser['User']['linkedin_token'] = serialize($linkedin->access_token);
        $this->User->save($saveUser);
	}
	
//sendMessage($ids,$subject,$message)
    function sendMessagetoLinkedinUser(){
        $this->autoRender = false;
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $jobId = $this->params['form']['jobId'];
        $linkedin = $this->getLinkedinObject();
       	$traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($jobId,$userId);
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));


        if(!empty($userIds) && $message &&  $user){
            foreach($userIds as $id){
                try{
                    $linkedin->access_token =unserialize($user['User']['linkedin_token']);
                    $subject = "Hire Routes";
                    //echo $message;
                    $icc = md5(uniqid(rand()));
                    if($session->getUserRole()==JOBSEEKER){
 	               		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."/?icc=".$icc;
                	}else{
                		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."?intermediateCode=".$invitationCode;
                	} 
                
                	$message =  $this->params['form']['subject']."\n".$message;
                    $xml_response = $linkedin->sendMessage($id,$subject,$message.$invitationUrl);
                    $xml_response = simplexml_load_string($xml_response);
                    
                    if($xml_response){
                    	$errorMessage = $xml_response->message;
                    	$errorMessage = convert_uudecode(convert_uuencode($errorMessage));
                    	return json_encode(array('error'=>2,'message'=>$errorMessage));      
                    }
                    
                    //save here job sharing details..
                	$shareJobData['job_id'] = $jobId;
                	//$shareJobData['user_id'] = $userId;
            	 	$sharedJobExits=$this->SharedJob->find('first',array('conditions'=>array(
									'job_id'=>$jobId,	
			    					'user_id'=>$userId,	
			    					)
					));
					if(empty($sharedJobExits)){
	            		$shareJobData['user_id'] = $userId;
						$this->SharedJob->save($shareJobData);	
					}
                	                	
                	$this->SharedJob->save($shareJobData);
                	//return json_encode(array('error'=>0));					
                }catch(Exception $e){
                	
                    return json_encode(array('error'=>1));      
                }

            }
            
            return json_encode(array('error'=>0));
        }

    }

    function sendInvitation(){
        $this->autoRender = false;
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $linkedin = $this->getLinkedinObject();
        $userId = $session->getUserId();
		$fbUsers = json_decode($this->params['form']['user']);
        //$invitationCode = isset($this->params['form']['invitationCode'])?$this->params['form']['invitationCode']:"";
        $traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($traceId,$userId);
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));

		if(!empty($fbUsers) &&  $user){
            foreach($fbUsers as $fbuser){
                try{
                    $linkedin->access_token =unserialize($user['User']['linkedin_token']);
                    $subject = "Hire Routes Invitation ";
                    $icc = md5(uniqid(rand())); 
                	if($session->getUserRole()==JOBSEEKER){
 	               		$invitationUrl = Configure::read('httpRootURL')."?icc=".$icc;
 	               		//$inviteData['name_email'] =  $fbuser->name;
						$inviteData['user_id'] = $userId;
						$inviteData['from'] = "Facebook";
						$inviteData['ic_code'] = $icc;
						$inviteData['created'] = date('Y-m-d H:i:s');
						$inviteData['status '] = 0;
						$this->Invitation->create();
						$this->Invitation->save($inviteData);
                	}else{
                		$invitationUrl = Configure::read('httpRootURL').'?intermediateCode='.$invitationCode."%26icc=".$icc;	
                	}
                	$message = $this->params['form']['subject']."\n".$this->params['form']['message']." Connect with us >>".$invitationUrl;
                	$xml_response = $linkedin->sendMessage($fbuser->id,$subject,$message);
                    $xml_response = simplexml_load_string($xml_response);
                    if($xml_response){
                    	$errorMessage = $xml_response->message;
                    	$errorMessage = convert_uudecode(convert_uuencode($errorMessage));
                    	return json_encode(array('error'=>2,'message'=>$errorMessage));      
                    }
                           	
                	/* save invitaion details here*/
                	$inviteData = array();
					$inviteData['name_email'] = $fbuser->name;
					$inviteData['user_id'] = $userId;
					$inviteData['from'] = "Linked-In";
					$inviteData['ic_code'] = $icc;
					$inviteData['status '] = 0;
					$inviteData['created'] = date('Y-m-d H:i:s');
					$this->Invitation->create();
					$this->Invitation->save($inviteData);					
					/* End*/					
                }catch(Exception $e){ echo $e;
                    return json_encode(array('error'=>1));      
                }
            }
            return json_encode(array('error'=>0));
        }
    }

    public function getLinkedinObject(){
        return  new LinkedIn(LINKEDIN_ACCESS, LINKEDIN_SECRET, LINKEDIN_CALLBACK_URL);    
    } 


}
?>
