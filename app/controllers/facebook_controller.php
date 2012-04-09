<?php

	require_once(APP_DIR.'/vendors/facebook/facebook.php');
	class FacebookController extends AppController {

    var $uses = array('User');
    
	private function facebookObject() {
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
        if(!$this->RequestHandler->isAjax()){
            $user = $this->facebookObject()->getUser();
            if($user){
                
                // save users facebook token
                $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
                $saveUser['User']['facebook_token'] = $this->facebookObject()->getAccessToken();
                $this->User->save($saveUser);
                $this->set('error',false);
                
            }else{
                //this would be call when user decline permission            
            }
        }else{

            $this->autoRender = false;
            $user = $this->User->find('first',array('fields'=>'facebook_token','conditions'=>array('id'=>$userId,'facebook_token !='=>'NULL')));
            //get token from table other wise send for login.
            if($user){
                try{
                    $token =  array(
                                'access_token' =>$user['User']['facebook_token']

                            );
                    $userdata = $this->facebookObject()->api('/me/friends', 'GET', $token);
                    $users = array();
                    $i =0 ;
                    foreach ($userdata as $key=>$value) {
                        foreach ($value as $fkey=>$fvalue) {
                            $users[$i]['name'] = $fvalue['name'] ;
                            $users[$i]['id'] = $fvalue['id'];
                            $users[$i]['url'] = 'https://graph.facebook.com/'.$fvalue['id'].'/picture';
                            $i++;
                        }
                    }
                    
                    return json_encode(array('error'=>0,'data'=>$users));
                }catch(Exception $e){
                    return json_encode(array('error'=>2,'message'=>'Error in facebook connection.Please try after some time.'));
                }
            }else{
                echo json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$this->getFaceBookLoginURL()));
            }   
        }
    }

    function commentAtFacebook(){
        $this->autoRender = false;
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $userId = $this->Session->read('Auth.User.id');
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        if(!empty($userIds) && $message &&  $User){
            foreach($userIds as $id){
                try{

                    $result = $this->facebookObject()->api("/".$id."/feed",'post',array('message'=>$message,'access_token' =>$User['User']['facebook_token']));
                    
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }

            }
        }
        return json_encode(array('error'=>0));

    }


}
?>
