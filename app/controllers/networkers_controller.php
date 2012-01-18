<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array('NetworkerSettings');
	var $components = array('Email');
	function add() {
		$this->data['Networkers']['networker_id'] = 9;
		$this->NetworkerSettings->save($this->data['Networkers']);
		$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
	}
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->redirect('/users/networkerSetting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/networkerSetting');
	}
}
?>
