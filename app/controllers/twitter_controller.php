<?php
class TwitterController extends AppController {
	var $uses = array('User','SharedJob','Invitation');
	var $components = array('TrackUser','Utility','RequestHandler');

	function beforeFilter(){
		parent::beforeFilter();
    	$this->Auth->allow('sendMessageToTwitterFollwer');
    	$this->Auth->allow('getTwitterFriendList');
    	$this->Auth->allow('twitterWidget');
    	$this->Auth->allow('sendInvitation');
	}
	
/**		*****	Twitter :: Handling	*****	**/

	private function getTwitterObject(){
		require_once(APP_DIR.'/vendors/twitter/EpiCurl.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiOAuth.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiTwitter.php'); 
		require_once(APP_DIR.'/vendors/twitter/secret.php');
		$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
		return $twitterObj;
	}

	function sendMessageToTwitterFollwer(){
        $this->autoRender = false;

        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();
        $traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($traceId,$userId);
        $userIds = $this->params['form']['usersId'];
        $jobId = $this->params['form']['jobId'];
        $userIds = explode(",", $userIds);
	    $message = $this->params['form']['subject']."\n".$this->params['form']['message'];
        $user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'),'conditions'=>array('id'=>$userId,
																								'twitter_token !='=>'',
																								'twitter_token_secret !='=>'')));

		$twitterObj = $this->getTwitterObject();
		$twitterObj->setToken($user['User']['twitter_token'],$user['User']['twitter_token_secret']);

        if(!empty($userIds) && $message &&  $user){
            foreach($userIds as $useId){
                try{
                	if($session->getUserRole()==JOBSEEKER){
                  		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."?icc=".$icc;
					}else{
                  		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."?intermediateCode=".$invitationCode;

					}
                    $result = $twitterObj->post_direct_messagesNew( array('user' => $useId, 'text' => $message.$invitationUrl));
                    $resp = $result->response;
                    if(isset($resp['recipient'])){
                    	//save here job sharing details..
                    	$shareJobData['job_id'] = $jobId;
                       	$sharedJobExits=$this->SharedJob->find('first',array('conditions'=>array(
    									'job_id'=>$jobId,	
				    					'user_id'=>$userId,	
				    					)
						));
						if(empty($sharedJobExits)){
		            		$shareJobData['user_id'] = $userId;
							$this->SharedJob->save($shareJobData);	
						}
                    	//$shareJobData['user_id'] = $userId;
                    	//$this->SharedJob->save($shareJobData);
                    	
                    }else{
				        if($resp['error'] || !empty($resp['error'])){
				        		$errorMessage = $resp['error'];
					        	return json_encode(array('error'=>2,'message'=>$errorMessage));      
					    }
					}
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }
            }
                        
            return json_encode(array('error'=>0));
        }
        return json_encode(array('error'=>0));

    }

	function sendInvitation(){
        $this->autoRender = false;

        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();
		$fbUsers = json_decode($this->params['form']['user']);
        //$invitationCode = $this->params['form']['invitationCode'];
        $traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($traceId,$userId);
        
        $user = $this->User->find('first', array('fields'=> array('twitter_token','twitter_token_secret'),
        														'conditions'=> array('id'=>$userId,
																'twitter_token !='=>'',
																'twitter_token_secret !='=>'')));

		$twitterObj = $this->getTwitterObject();
		$twitterObj->setToken($user['User']['twitter_token'],$user['User']['twitter_token_secret']);

       if(!empty($fbUsers) &&  $user){
            foreach($fbUsers as $fbuser){
                try{
                	$subject = "Hire Routes Invitation ";
                    $icc = md5(uniqid(rand())); 
                	if($session->getUserRole()==JOBSEEKER){
 	               		$invitationUrl = Configure::read('httpRootURL')."?icc=".$icc;
                	}else{
                		$invitationUrl = Configure::read('httpRootURL').'?intermediateCode='.$invitationCode."&icc=".$icc;	
                	}
                	$message = $this->params['form']['message']." Connect with us >> ".$invitationUrl;
                	
                    $result = $twitterObj->post_direct_messagesNew( array('user' => $fbuser->id, 'text' => $message));
                    $resp = $result->response;
                    if(isset($resp['error'])){
		        		$errorMessage = $resp['error'];
			        	return json_encode(array('error'=>2,'message'=>$errorMessage));      
					}
					/* save invitaion details here*/
                	$inviteData = array();
					$inviteData['name_email'] = $fbuser->name;
					$inviteData['user_id'] = $userId;
					$inviteData['from'] = "Twitter";
					$inviteData['ic_code'] = $icc;
					$inviteData['status '] = 0;
					$inviteData['created'] = date('Y-m-d H:i:s');
					$this->Invitation->create();
					$this->Invitation->save($inviteData);					
					/* End*/
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }
            }
            return json_encode(array('error'=>0));
        }
        else{
        	return json_encode(array('error'=>1));
        }

    }

	private function connectTwitter(){
		$this->redirect($this->getTwitterObject()->getAuthorizationUrl());
	}

	function twitterCallback(){
		if(isset($this->params['url']['denied'])){
			$this->render('denied_twitter');
			return;
		}
	 	$userId = $this->Session->read('Auth.User.id');
		$oauth_token = isset($this->params['url']['oauth_token'])?$this->params['url']['oauth_token']:'';
		if($oauth_token){
			$twitterObj = $this->getTwitterObject();
			$twitterObj->setToken($oauth_token);
			$token = $twitterObj->getAccessToken();			
			
			$currentUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
            $currentUser['User']['twitter_token'] = $token->oauth_token;
            $currentUser['User']['twitter_token_secret'] = $token->oauth_token_secret;
            if($this->User->save($currentUser)){
            	$this->redirect("/twitter/getTwitterFriendList");
            }            
		}
	}	
	
	function postTweet(){
		$user = $user = $this->data['Twitter']['SendTo'];
		$msg = $this->data['Twitter']['msg'];
		
		$twitterObj = $this->getTwitterObject();
		$twitterObj->setToken($this->Session->read('Twitter.twitter_token'),$this->Session->read('Twitter.twitter_token_secret'));
		$myArray = array('user' => $user, 'text' => $msg);
        $resp = $twitterObj->post_direct_messagesNew( $myArray);// change this for tweet
        $temp = $resp->response;
        
		$this->Session->setFlash('Your message has been posted successfuly.', 'success');
		$this->redirect("/twitter/getTwitterFriendList");
	}
	
	function getTwitterFriendList(){
		
		if(isset($this->params['url']['denied'])){
			$this->render('denied_twitter');
			return;
		}
    
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){  
        	$this->autoRender = false;     
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();

		if(!$this->RequestHandler->isAjax()){
            $oauth_token = isset($this->params['url']['oauth_token'])?$this->params['url']['oauth_token']:'';
			if($oauth_token){
				$twitterObj = $this->getTwitterObject();
				$twitterObj->setToken($oauth_token);
				$token = $twitterObj->getAccessToken();			
			
				$currentUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
		        $currentUser['User']['twitter_token'] = $token->oauth_token;
		        $currentUser['User']['twitter_token_secret'] = $token->oauth_token_secret;
		        if($this->User->save($currentUser)){
		        	$this->set('error',false);
		        	return;
		        }            
			}else{
                //this would be call when user decline permission            
            }
        }else{
        	$this->autoRender = false;
            $user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'), 											'conditions'=>array('id'=>$userId,
            												'twitter_token !='=>'',
            												'twitter_token_secret !='=>''
            											)
            										)
            									);
            //get token from table other wise send for login.
            if($user){
                try{
                    $twitterObj = $this->getTwitterObject();
					$twitterObj->setToken($user['User']['twitter_token'],$user['User']['twitter_token_secret']);
					$twitterInfo= $twitterObj->get_accountVerify_credentials();
					$twitterInfo->response;

					$username = $twitterInfo->screen_name;
					$profilepic = $twitterInfo->profile_image_url;
		
					$trends_url = "http://api.twitter.com/1/statuses/followers/$username.json";
					$ch = curl_init(); 
					curl_setopt($ch, CURLOPT_URL, $trends_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$curlout = curl_exec($ch);
					curl_close($ch);
					$response = json_decode($curlout, true);			
					$this->set('url',$twitterObj->getAuthorizationUrl());
					$this->set('username',$username);
					$this->set('profilepic',$profilepic);
					$users = array();
					if(count($response)){
						foreach($response as $person){ 
						    $users[] = array(
						    					'name'=>$person['name'],
						    					'id'=>"".$person['id'],
						    					'url'=>"".$person['profile_image_url']
						    				);                
						}             
					}
                    return json_encode(array('error'=>0,'data'=>$users));
                }catch(Exception $e){
                    return json_encode(array('error'=>2,'message'=>'Error in Twitter connection. Please try after some time.'));
                }
            }else{
            	$this->Session->write('apiSource',$this->params['form']['source']);
                echo json_encode(array('error'=>1,'message'=>'User not authenticate from Twitter.','URL'=>$this->getTwitterObject()->getAuthorizationUrl()));
            }
        }
    }
    
    public function twitterWidget(){
		require_once(APP_DIR.'/vendors/twitter/twitterstatus.php');
		$t = new TwitterStatus('HireRoutes', 3);
		$t->__render();
		echo "===============>  cron run sussessfully . ".date("Y-m-d H:i:s")." <================ \n";
		$this->autoRender =false;
    }
    
   /**		*****	End of Twitter :: Handling	*****	**/  	

}
?>
