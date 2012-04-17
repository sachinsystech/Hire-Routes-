<?php
class HomeController extends AppController {
    var $uses = array('Home','Job');
				

	var $helpers = array('Form','Paginator');
	
	public function beforeFilter(){
		$this->Auth->allow('index');
		$this->Auth->allow('contactUs');
		$this->Auth->allow('howItWorks');
		$this->Auth->allow('jobseekerInformation');
		$this->Auth->allow('networkerInformation');
		$this->Auth->allow('companyInformation');
	}

	function index(){
		$jobs = $this->Job->find('all',	array('limit'=>3,
											 'joins'=>array(
														array('table' => 'industry',
										                      'alias' => 'ind',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.industry = ind.id',)),
										            	array('table' => 'cities',
															   'alias' => 'city',
															   'type' => 'INNER',
															   'conditions' => array('Job.city = city.id',)),
														array('table' => 'states',
															   'alias' => 'state',
															   'type' => 'INNER',
															   'conditions' => array('Job.state = state.id',)),
														array('table' => 'specification',
											 				   'alias' => 'spec',
															   'type' => 'INNER',
															   'conditions' => array('Job.specification = spec.id',)),	   
										            	array('table' => 'companies',
										                      'alias' => 'companies',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.company_id = companies.id',)),	  
											),
										 'order' => array("Job.created" => 'desc'),
										 'conditions'=>array('Job.is_active'=>1),
										'fields'=>array('Job.id,Job.title,Job.reward, companies.company_name, state.state  as name,city.city as name,ind.name, spec.name'),));
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

}
?>
