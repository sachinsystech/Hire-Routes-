<?php
class HomeController extends AppController {
    var $uses = array('Home');
				
	var $helpers = array('Form');
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index');
		$this->Auth->allow('companyInformation');
		$this->Auth->allow('networkerInformation');
		$this->Auth->allow('jobseekerInformation');
	}
	function index(){
		
	}

	function companyInformation(){
		
	}

	function networkerInformation(){
		
	}

	function jobseekerInformation(){
		
	}
		
}
?>
