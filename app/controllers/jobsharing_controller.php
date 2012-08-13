<?php
class JobsharingController extends AppController {

	var $uses = array('User','Companies','Job','SharedJob','Invitation');
	var $components = array('TrackUser','Utility','RequestHandler');
	
	function beforeFilter(){
		parent::beforeFilter();
    	$this->Auth->allow('shareJobByEmail');
    	$this->Auth->allow('sendEmailInvitaion');
	}
	
	function shareJobByEmail(){
		$this->autoRender= false;
		$session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/users/login'));
        }
        $userId = $session->getUserId();

		if(isset($this->params['form']['toEmail'])){
			$jobId=trim($this->params['form']['jobId']);
			$to=trim($this->params['form']['toEmail']);
			$subject=$this->params['form']['subject'];
			$jobUrl=$this->params['form']['jobUrl'];
			$template = 'shared_job_details';
			$job = $this->Utility->getJob($jobId);
			if(!$job || empty($job)){
				return json_encode(array('error'=>1,'message'=>'Job not specified.'));
			}
			$messageBody = $job;
			$messageBody['jobUrl'] = $jobUrl; 
			$messageBody['message'] = $this->params['form']['message'];
			isset($this->params['form']['code'])?$messageBody['code'] = $this->params['form']['code']:"";			

			if($this->sendEmail($to,$subject,$template,$messageBody)){
				$shareJobData['job_id'] = $jobId;
               	$shareJobData['user_id'] = $userId;
               	$sharedJobExits=$this->SharedJob->find('first',array('conditions'=>array(
    									'job_id'=>$jobId,	
				    					'user_id'=>$userId,	
				    					)
						));	
				
				if(empty($sharedJobExits)){
					$this->SharedJob->save($shareJobData);	
				}
               	return json_encode(array('error'=>0));
			}else{
				return json_encode(array('error'=>2,'message'=>'Something went wrong. Please try after some time OR conntact to site admin.'));
			}
		}
		else{
			return json_encode(array('error'=>2,'message'=>'Email address not specified!'));
		}
	}
	
	function sendEmailInvitaion(){
		$this->autoRender= false;
		$session = $this->_getSession();
        if(!$session->isLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/users/login'));
        }
        $userId = $session->getUserId();

		if(isset($this->params['form']['toEmail'])){

			//$invitationCode = $this->params['form']['invitationCode'];
			$traceId = -1*(time()%10000000);
        	$invitationCode = $this->Utility->getCode($traceId,$userId);
			$template = 'invitation';
			$subject = "Hire-Routes Invitation";
			$tos = explode(",", trim($this->params['form']['toEmail']));
			
			foreach($tos As $to){
				$icc = md5(uniqid(rand()));
				if($session->getUserRole()==JOBSEEKER){
 	            	$invitationUrl = Configure::read('httpRootURL')."?icc=".$icc;
                }else{
                	$invitationUrl = Configure::read('httpRootURL').'?intermediateCode='.$invitationCode."&icc=".$icc;	
                } 
                //$invitationUrl = Configure::read('httpRootURL').'?intermediateCode='.$invitationCode."&icc=".$icc;
                $messageBody['message'] = $this->params['form']['message'];
                $messageBody['invitationUrl'] = $invitationUrl;
				if($this->sendEmail($to,$subject,$template,$messageBody)){
					$inviteData = array();
					$inviteData['name_email'] = $to;
					$inviteData['user_id'] = $userId;
					$inviteData['from'] = "E-Mail";
					$inviteData['ic_code'] = $icc;
					$inviteData['created'] = date('Y-m-d H:i:s');
					$inviteData['status '] = 0;
					$this->Invitation->create();
					$this->Invitation->save($inviteData);						
				}else{
					return json_encode(array('error'=>2,'message'=>'Something went wrong. Please try after some time OR conntact to site admin.'));
				}
			}
			return json_encode(array('error'=>0));
		}
		else{
			return json_encode(array('error'=>2,'message'=>'Email address not specified!'));
		}
	}	
	
}
?>
