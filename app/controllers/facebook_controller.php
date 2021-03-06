
<?php	
	class FacebookController extends AppController {

    var $uses = array('User','SharedJob','Invitation');
	var $components = array('TrackUser','Utility','RequestHandler');    
	
	function beforeFilter(){
		parent::beforeFilter();	
    	$this->Auth->allow('getFaceBookFriendList');
    	$this->Auth->allow('commentAtFacebook');
    	$this->Auth->allow('facebookObject');
    	$this->Auth->allow('sendInvitation');
	}
	/******	Facebook Handling	******/
	
	public function facebookObject() {
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
      
		$session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	$this->autoRender = false;
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();

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
                	$this->Session->write('apiSource',$this->params['form']['source']);
                	return json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$facebook->getLoginURL(array('canvas' => 1, 'fbconnect' => 0, 'scope' => 'email,offline_access,publish_stream'))));	
                }
            }else{
				$this->Session->write('apiSource',$this->params['form']['source']);
                return json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$facebook->getLoginURL(array('canvas' => 1, 'fbconnect' => 0, 'scope' => 'email,offline_access,publish_stream'))));
            }   
        }
    }


    function commentAtFacebook(){
        $this->autoRender = false;
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	$this->autoRender = false;
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();
        $jobId = $this->params['form']['jobId'];
        $userIds = explode(",", $this->params['form']['usersId']);
        //$traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($jobId,$userId);
        
        $message = $this->params['form']['subject']."\n".$this->params['form']['message'];
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        $config_url = Configure::read('httpRootURL');
        if(!empty($userIds) && $message &&  $User){
            foreach($userIds as $id){
                try{

                	if($session->getUserRole()==JOBSEEKER){
	                	$icc = md5(uniqid(rand())); 
 	               		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."/?icc=".$icc;
 	               		$inviteData = array();
						$inviteData['name_email'] =  "";//$fbuser->name;
						$inviteData['user_id'] = $userId;
						$inviteData['from'] = "Facebook";
						$inviteData['ic_code'] = $icc;
						$inviteData['created'] = date('Y-m-d H:i:s');
						$inviteData['status '] = 0;
						$this->Invitation->create();
						$this->Invitation->save($inviteData);
                	}else{
                		$invitationUrl = Configure::read('httpRootURL')."jobs/jobDetail/".$jobId."?intermediateCode=".$invitationCode;
                	}
                	
                    $result = $this->facebookObject()->api("/".$id."/feed",'post',array(
											'message'=>$message.$invitationUrl,
											'method'=>'send',
											'link'=>$invitationUrl,
											'picture'=>$config_url."/images/hire_route_logo.png",
											'name'=>'Hire Routes',
											'description'=>'A social recruiting website that provides companies and recruiters with a platform that allows them to really harness the power of social networks by posting jobs with cash rewards and sharing those jobs with their own personal and professional networks as well as with new, select and otherwise inaccessible networks being built here at Hire Routes.',
											//'caption'=>'Reference Documentation',
											'picture'=>$config_url."/images/hire_route_logo.png",
											'access_token' =>$User['User']['facebook_token'])
										);
										
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
		           	//$this->SharedJob->save($shareJobData);
                	//return json_encode(array('error'=>0));
                }catch(Exception $e){
                print_r($e);
					exit;
                	return json_encode(array('error'=>1));      
                }
            }
        }        
        return json_encode(array('error'=>0));        
    }


	function sendInvitation(){
        $this->autoRender = false;
        $session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	$this->autoRender = false;
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/login'));
        }
        $userId = $session->getUserId();

		$fbUsers = json_decode($this->params['form']['user']);
		$traceId = -1*(time()%10000000);
        $invitationCode = $this->Utility->getCode($traceId,$userId);
        //$invitationCode = $this->params['form']['invitationCode'];
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        $config_url = Configure::read('httpRootURL');
        if(!empty($fbUsers) &&  $User){
            foreach($fbUsers as $fbuser){
                try{
                	
                	$icc = md5(uniqid(rand())); 
                	if($session->getUserRole()==JOBSEEKER){
 	               		$invitationUrl = Configure::read('httpRootURL')."?icc=".$icc;
                	}else{
                		$invitationUrl = Configure::read('httpRootURL').'?intermediateCode='.$invitationCode."&icc=".$icc;	
                	}
                	$message =  $this->params['form']['subject']."\n".$this->params['form']['message']." Connect with us >> ".$invitationUrl;
                	$result = $this->facebookObject()->api("/".$fbuser->id."/feed",'post',
                											array('message'=>$message,
                												'picture'=>$config_url."/images/hire_route_logo.png",
																'name'=>'Hire Routes',
																'link'=>$invitationUrl,
																'description'=>'A social recruiting website that provides companies and recruiters with a platform that allows them to really harness the power of social networks by posting jobs with cash rewards and sharing those jobs with their own personal and professional networks as well as with new, select and otherwise inaccessible networks being built here at Hire Routes.',
																//'caption'=>'Reference Documentation',
                												'picture'=>$config_url."/images/hire_route_logo.png",
                												'access_token' =>$User['User']['facebook_token']));
					$inviteData = array();                	
					$inviteData['name_email'] = $fbuser->name;
					$inviteData['user_id'] = $userId;
					$inviteData['from'] = "Facebook";
					$inviteData['ic_code'] = $icc;
					$inviteData['status '] = 0;
					$inviteData['created'] = date('Y-m-d H:i:s');
					$this->Invitation->create();
					$this->Invitation->save($inviteData);					
                    
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


}
?>
