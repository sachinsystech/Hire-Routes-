<?php
class TwitterController extends AppController {
	var $uses = array('User');
	var $components = array('TrackUser','Utility','RequestHandler');
	
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
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $userId = $this->Session->read('Auth.User.id');
        $user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'),'conditions'=>array('id'=>$userId,
																								'twitter_token !='=>'',
																								'twitter_token_secret !='=>'')));

		$twitterObj = $this->getTwitterObject();
		$twitterObj->setToken($user['User']['twitter_token'],$user['User']['twitter_token_secret']);

        if(!empty($userIds) && $message &&  $user){
            foreach($userIds as $useId){
                try{
                    $result = $twitterObj->post_direct_messagesNew( array('user' => $useId, 'text' => $message));
                    $resp = $result->response;
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }
            }
        }
        return json_encode(array('error'=>0));

    }

	private function connectTwitter(){
		$this->redirect($this->getTwitterObject()->getAuthorizationUrl());
	}

	function twitterCallback(){
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
        $userId = $this->Session->read('Auth.User.id');
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
            $user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'),'conditions'=>array('id'=>$userId,
																								'twitter_token !='=>'',
																								'twitter_token_secret !='=>'')));
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
						foreach($response as $person){ //print_r($person->$a);
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
                echo json_encode(array('error'=>1,'message'=>'User not authenticate from Twitter.','URL'=>$this->getTwitterObject()->getAuthorizationUrl()));
            }
        }
    }
    
   /**		*****	End of Twitter :: Handling	*****	**/  	

}
?>
