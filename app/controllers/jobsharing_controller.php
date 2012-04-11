<?php
class JobsharingController extends AppController {

	var $uses = array('User','Companies','Company','Job');
	var $components = array('TrackUser','Utility','RequestHandler');
	
	function shareJobByEmail(){
		$this->autoRender= false;
		if(isset($this->params['form']['toEmail'])){
			$jobId=trim($this->params['form']['jobId']);
			$to=trim($this->params['form']['toEmail']);
			$subject=$this->params['form']['subject'];
			$job_details=$this->Job->find('first',array('fields'=>array(
														'Job.id','title','reward','Company.company_name','city','state'
														),
														'recursive'=>-1,
														'joins'=>array(
															array(
															'table'=>'companies',
															'alias'=>'Company',
															'type'=>'inner',
															'fields'=>'Company.id,Company.company_name',
															'conditions'=>array(
																'Job.company_id = Company.id'
																)
															)
														),
														'conditions'=>array('Job.id'=>$jobId, 'is_active'=>1)
													)
												);
			$message=$this->params['form']['message'];
			if(empty($job_details))
				return "Email address not found";
			if(isset($job_details)&&!empty($job_details)){
				$job_details['message'] = $message;
				$template = 'shared_job_details';
				if($this->sendEmail($to,$subject,$template,$job_details)){
					return json_encode(array('error'=>0));
				}else{
					return json_encode(array('error'=>1));
				}
			}else{
				return "Job not selected!";
			}	
		}
		else{
			return "Email address not specified!";
		}
	}
}
?>
