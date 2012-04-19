<?php
class JobsharingController extends AppController {

	var $uses = array('User','Companies','Company','Job','SharedJob');
	var $components = array('TrackUser','Utility','RequestHandler');
	
	function beforeFilter(){
		parent::beforeFilter();
    	$this->Auth->allow('shareJobByEmail');
	}
	
	function shareJobByEmail(){
		$this->autoRender= false;
        if(!$this->TrackUser->isUserLoggedIn()){       
        	return json_encode(array('error'=>3,'message'=>'You are not logged-in','URL'=>'/users/login'));
        }		
		$userId = $this->Session->read('Auth.User.id');
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
			if($this->sendEmail($to,$subject,$template,$messageBody)){
				$shareJobData['job_id'] = $jobId;
               	$shareJobData['user_id'] = $userId;
               	$this->SharedJob->save($shareJobData);
				return json_encode(array('error'=>0));
			}else{
				return json_encode(array('error'=>2,'message'=>'Something went wrong. Please try after some time OR conntact ot site admin.'));
			}
		}
		else{
			return json_encode(array('error'=>2,'message'=>'Email address not specified!'));
		}
	}
}
?>
