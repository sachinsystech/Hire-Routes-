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
		$this->Auth->allow('termsOfUse');
		$this->Auth->allow('privacyPolicy');
	}

	function index(){
		$this->layout ="home";
	}

	function companyInformation(){
		$this->layout ="home";
	}

	function networkerInformation(){
		$this->layout ="home";
	}

	function jobseekerInformation(){
		$this->layout ="home";
	}

	function contactUs(){
		$this->layout ="home";
	}

	function howItWorks(){
		$this->redirect("/networkerInformation");
	}

	function about(){
		$this->layout ="home";

	}	

	function networkerPointInfo(){
		$this->layout ="home";
		$pointLables = $this->PointLabels->find('all');
		$this->set('pointLables',$pointLables);
	 }
	 
	 function hrInvitationsDetail(){
	 
	 }
	 
	 function termsOfUse(){
	 	 $this->layout ="home";
	 }

	function privacyPolicy(){
		$this->layout ="home";	
	}
}
?>
