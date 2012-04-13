<?php

	require_once(APP_DIR.'/vendors/linkedin/linkedin.php');
	require_once(APP_DIR.'/vendors/linkedin/OAuth.php');
	
	class LinkedinController extends AppController {

    var $uses = array('User','SharedJob');
	var $components = array('TrackUser','Utility','RequestHandler');  

       function getLinkedinFriendList(){
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        $this->autoRender = false;
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'')));
        if($user){
            
           // $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
            $linkedin->access_token =unserialize($user['User']['linkedin_token']);
            $xml_response = $linkedin->getProfile("~/connections:(headline,first-name,last-name,picture-url,id)");
            $response=simplexml_load_string($xml_response);
            $users = array();
            
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
            	echo json_encode(array('error'=>1,'message'=>'User not authenticate from linkedin.','URL'=>$linkedin->generateAuthorizeUrl()));
            }
            else{
            	echo json_encode(array('error'=>2));	
            }
        }
    }
   

    function linkedinCallback(){
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        if (isset($_REQUEST['oauth_verifier'])){
            //$_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];
            $linkedin->request_token    =   unserialize($this->Session->read("requestToken"));
            $verifier = $this->params['url']['oauth_verifier'];
            $linkedin->oauth_verifier = $verifier;
            $linkedin->getAccessToken($verifier);
            $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
            $saveUser['User']['linkedin_token'] = serialize($linkedin->access_token);
            $this->User->save($saveUser);
            $this->set('error',false);
        }

    }

//sendMessage($ids,$subject,$message)
    function sendMessagetoLinkedinUser(){
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $jobId = $this->params['form']['jobId'];
        $linkedin = $this->getLinkedinObject();
        $userId = $this->Session->read('Auth.User.id');
        $this->autoRender = false;
        //$this->autoRender = false;
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));


        if(!empty($userIds) && $message &&  $user){
            foreach($userIds as $id){
                try{
                    $linkedin->access_token =unserialize($user['User']['linkedin_token']);
                    $subject = "Hire Routes";
                    $xml_response = $linkedin->sendMessage($id,$subject,$message);
                    $xml_response = simplexml_load_string($xml_response);
                    
                    if($xml_response){
                    	$errorMessage = $xml_response->message;
                    	$errorMessage = convert_uudecode(convert_uuencode($errorMessage));
                    	return json_encode(array('error'=>2,'message'=>$errorMessage));      
                    }
                    //save here job sharing details..
                	$shareJobData['job_id'] = $jobId;
                	$shareJobData['user_id'] = $userId;
                	$this->SharedJob->save($shareJobData);
                	return json_encode(array('error'=>0));					
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }

            }
        }

    }

    private function getLinkedinObject(){
        return  new LinkedIn(LINKEDIN_ACCESS, LINKEDIN_SECRET, LINKEDIN_CALLBACK_URL);    
    } 


}
?>
