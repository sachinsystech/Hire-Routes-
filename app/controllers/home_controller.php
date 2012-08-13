<?php
class HomeController extends AppController {
    var $uses = array('Home','Job','NetworkersTitle','PointLabels');
				

	var $helpers = array('Form','Paginator');
	
	public function beforeFilter(){

		parent::beforeFilter();	
		$this->Auth->allow('index');
		$this->Auth->allow('contactUs');
		$this->Auth->allow('howItWorks');
		$this->Auth->allow('jobseekerInformation');
		$this->Auth->allow('networkerInformation');
		$this->Auth->allow('companyInformation');
		$this->Auth->allow('companyInformation');		
		$this->Auth->allow('hrInvitationsDetail');
		$this->Auth->allow('networkerPointInfo');
		$this->Auth->allow('about');
	}

	function index(){
		$this->layout ="home";
	}

	function companyInformation(){
		
	}

	function networkerInformation(){
		
	}

	function jobseekerInformation(){
	
	}

	function contactUs(){

	}

	function howItWorks(){
		
	}

	function about(){
		$this->layout ="home";

	}	

	function networkerPointInfo(){
		$pointLables = $this->PointLabels->find('all');
		$this->set('pointLables',$pointLables);
	
	 }
	 
	 function hrInvitationsDetail(){
	 
	 }

}
?>
