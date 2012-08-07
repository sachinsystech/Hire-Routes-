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
		$facebook = $this->requestAction('/Facebook/facebookObject');
		$this->set("FBLoginUrl",$facebook->getLoginUrl(array('scope' => 'email,read_stream')));
		$linkedin = $this->requestAction('/Linkedin/getLinkedinObject');
		$linkedin->getRequestToken();
		$this->set("LILoginUrl",$linkedin->generateAuthorizeUrl() );	
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
		$networkersTitles = $this->NetworkersTitle->find('list');
		$points = array('0 - 150','151 - 300','301 - 500','501 - 750','751 - 1000',
						'1001 - 1300','1301 - 1700','1701 - 2000','2001 - 2500','2500+');
		$this->set("points",$points);
		$pointLables = $this->PointLabels->find('all');
		$this->set('pointLables',$pointLables);
	
		$this->set('networkersTitles',$networkersTitles);
	 }
	 
	 function hrInvitationsDetail(){
	 
	 }

}
?>
