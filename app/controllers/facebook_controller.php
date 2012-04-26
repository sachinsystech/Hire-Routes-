<?php	
	/***	Include facebook api authentication files.	***/

?>


<?php	
	class FacebookController extends AppController {

    var $uses = array('User','SharedJob');
	var $components = array('TrackUser','Utility','RequestHandler');    
	
	function beforeFilter(){
		parent::beforeFilter();	
    	$this->Auth->allow('getFaceBookFriendList');
    	$this->Auth->allow('commentAtFacebook');
	}
	/******	Facebook Handling	******/
	
	private function facebookObject() {
	require_once(APP_DIR.'/vendors/facebook/facebook.php');
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
          'cookie' => true,
		));
		return $facebook;
	}

    function getFaceBookLoginURL(){ 
        $loginUrl = $this->facebookObject()->getLoginUrl(array(
                                                                'canvas' => 1,
                                                                'fbconnect' => 0,
                                                                'scope' => 'offline_access,publish_stream'
                    ));
        return $loginUrl;
    }


    function getFaceBookFriendList(){
        $userId = $this->Session->read('Auth.User.id');

        if(!$this->TrackUser->isUserLoggedIn()){       
        	$this->autoRender = false;
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/users/login'));
        }
      	$facebook=$this->facebookObject();
       	$facebook->setRequestUri('/facebook/getFaceBookFriendList');           

        if(!$this->RequestHandler->isAjax()){ 
            $user = $facebook->getUser();
            if($user){
                
                // save users facebook token
                $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
                $saveUser['User']['facebook_token'] = $facebook->getAccessToken();
                $this->User->save($saveUser);
                $this->set('error',false);
                return;
            }else{
                //this would be call when user decline permission            
            }
        }else{

            $this->autoRender = false;
            $user = $this->User->find('first',array('fields'=>'facebook_token','conditions'=>array('id'=>$userId,'facebook_token !='=>'')));
            //get token from table other wise send for login.
            if($user){
                try{
                    $token =  array(
                                'access_token' =>$user['User']['facebook_token']

                            );
                    $userdata = $facebook->api('/me/friends', 'GET', $token);
                    $users = array();
                    $i =0 ;
                    foreach ($userdata['data'] as $key=>$value){
                            $users[] =array('name'=>$value['name'], 'id'=> $value['id'], 'url' => 'https://graph.facebook.com/'.$value['id'].'/picture');
                            $i++;
                    }
                    return json_encode(array('error'=>0,'data'=>$users));
                }catch(Exception $e){
                    return json_encode(array('error'=>2,'message'=>'Error in facebook connection. Please try after some time.'));
                }
            }else{
                return json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$facebook->getLoginURL(array('canvas' => 1, 'fbconnect' => 0, 'scope' => 'offline_access,publish_stream'))));
            }   
        }
    }


    function commentAtFacebook(){
        $this->autoRender = false;
        if(!$this->TrackUser->isUserLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/users/login'));
        }
        $userIds = $this->params['form']['usersId'];
        $jobId = $this->params['form']['jobId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $userId = $this->Session->read('Auth.User.id');
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        if(!empty($userIds) && $message &&  $User){
            foreach($userIds as $id){
                try{
                    $result = $this->facebookObject()->api("/".$id."/feed",'post',array('message'=>$message,'access_token' =>$User['User']['facebook_token']));
                    $shareJobData['job_id'] = $jobId;
                	$shareJobData['user_id'] = $userId;
                	$this->SharedJob->save($shareJobData);
                	return json_encode(array('error'=>0));
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }
            }
        }
        return json_encode(array('error'=>0));        
    }



}
?>
