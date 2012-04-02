<?php
class HomeController extends AppController {
    var $uses = array('Home','Job');
				

	var $helpers = array('Form','Paginator');

	function index(){
		$jobs = $this->Job->find('all',array('limit'=>3,
											 'joins'=>array(
														array('table' => 'industry',
										                      'alias' => 'ind',
										            		  'type' => 'inner',
										            		  'conditions' => array('Job.industry = ind.id',),),
														array('table' =>'cities',
														      'type'  => 'inner',
															  'conditions' => array('Job.city=cities.id'),
															 ),
														array('table'=>'states',
															'type'=>'inner',
															'conditions'=>array('Job.state=states.id'))
							
															),
							
										'order' => array("Job.created" => 'desc'),
										'fields'=>array('Job.id,Job.title,Job.company_name,Job.reward,ind.name as industry_name, cities.city as city,states.state as state'),));
		$this->set('jobs',$jobs);		
		//echo "<pre>"; print_r($jobs); exit;
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

}
?>
