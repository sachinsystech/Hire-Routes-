<?php
class HomeController extends AppController {
    var $uses = array('Home','Job');
				

	var $helpers = array('Form','Paginator');

	function index(){
		$jobs = $this->Job->find('all',array('limit'=>3,
											 'joins'=>array(
														array('table' => 'industry',
										                      'alias' => 'ind',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.industry = ind.id',)),
											),
										 'order' => array("Job.created" => 'desc'),
										'fields'=>array('Job.id,Job.title,Job.company_name,Job.reward,ind.name as industry_name'),));
		$this->set('jobs',$jobs);		
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
	function howItWorks(){
	
	}


}
?>
