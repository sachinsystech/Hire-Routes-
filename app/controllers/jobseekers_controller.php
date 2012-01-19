<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';
	var $uses = array('JobseekerSettings');
	var $components = array('Email','Session');	
	function add() {
		$this->data['Jobseekers']['jobseeker_id'] = 10;
		$this->JobseekerSettings->save($this->data['Jobseekers']);
		$this->Session->setFlash('Your Setting has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}
	function delete(){
		$id = $this->params['id'];
		$this->JobseekerSettings->delete($id);
		$this->redirect('/users/jobseekerSetting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}
}
?>
