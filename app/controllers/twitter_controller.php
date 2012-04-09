<?php
class TwitterController extends AppController {
	//var $name = 'Twitter';
    var $uses = array('User');

	/**		*****	Twitter :: Handling	*****	**/

	private function getTwitterObject(){
		require_once(APP_DIR.'/vendors/twitter/EpiCurl.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiOAuth.php'); 
		require_once(APP_DIR.'/vendors/twitter/EpiTwitter.php'); 
		require_once(APP_DIR.'/vendors/twitter/secret.php');
		$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
		return $twitterObj;
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
        $resp = $twitterObj->post_direct_messagesNew( $myArray);
        $temp = $resp->response;
		$this->Session->setFlash('Your message has been posted successfuly.', 'success');
		$this->redirect("/twitter/getTwitterFriendList");
	}
	
	function getTwitterFriendList(){
        $userId = $this->Session->read('Auth.User.id');
		$user = $this->User->find('first',array('fields'=>array('twitter_token','twitter_token_secret'),'conditions'=>array('id'=>$userId,
																								'twitter_token !='=>'',
																								'twitter_token_secret !='=>'')));
		
		if(!$user){			//Token not found so redirecting for twitter login authentication

			$twitterLoginUrl = $this->getTwitterObject()->getAuthorizationUrl();
			$this->redirect($twitterLoginUrl);
			
			/**	**	**	 returning json response	**	**	** /
			echo json_encode(array('error'=>1,'message'=>'User not authenticate from Twitter.','URL'=>$twitterLoginUrl));
			/**	**	**	**	**	**/
		}
		else{
			$twitterObj = $this->getTwitterObject();
			
			$this->Session->write('Twitter.twitter_token',$user['User']['twitter_token']);
			$this->Session->write('Twitter.twitter_token_secret',$user['User']['twitter_token_secret']);
			
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
			$this->set('response',$response);
			
			/***********	Encode in json	********** /
			 $users = array();
             foreach ($response as $key=>$value) {
                $users[$key]['name'] = $value['name'] ;
                $users[$key]['id'] = $value['id'];
                $users[$key]['url'] = $value['profile_image_url'];
             }
             $users = json_encode(array('error'=>0,'data'=>$users));
            /**  **  **  **  **  **  **  **  **  **  ** ** **/			
			
		}		
    }
   /**		*****	End of Twitter :: Handling	*****	**/  

}
?>
