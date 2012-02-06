<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';
	var $uses = array('JobseekerSettings');
	var $components = array('Email','Session');	
	function add() {
		$this->data['Jobseekers']['user_id'] = $this->Session->read('Auth.User.id');
		//echo "<pre>"; print_r(implode(',',$this->data['Jobseekers']['industry_specification_1']));exit;
		$this->data['Jobseekers']['specification_1'] = implode(',',$this->data['Jobseekers']['industry_specification_1']);
		$this->data['Jobseekers']['specification_2'] = implode(',',$this->data['Jobseekers']['industry_specification_2']);
		$this->JobseekerSettings->save($this->data['Jobseekers']);
		$this->Session->setFlash('Your Setting has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		//$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}
}
?>
