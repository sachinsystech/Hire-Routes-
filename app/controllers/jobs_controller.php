<?php
class JobsController extends AppController {
    var $uses = array('Company','Job','Industry','State','Specification','UserRoles','Companies','City');
	var $helpers = array('Form','Paginator');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('index');
	}
	
	function index(){
		//echo "<pre>"; print_r($this->data);
		$shortByItem = 'id';
        $salaryFrom = null;
        $salaryTo = null;
        if(isset($this->params['named']['display'])){
	        $displayPageNo = $this->params['named']['display'];
	        $this->set('displayPageNo',$displayPageNo);
		}
		if(isset($this->params['named']['shortby'])){
	        $shortBy = $this->params['named']['shortby'];
	        $this->set('shortBy',$shortBy);
	        switch($shortBy){
	        	case 'date-added':
	        				$shortByItem = 'created'; 
	        				break;	
	        	case 'company-name':
	        				$shortByItem = 'company_name'; 
	        				break;
	        	case 'industry':
	        				$shortByItem = 'industry'; 
	        				break;
	        	case 'salary':
	        				$shortByItem = 'salary_from'; 
	        				break;
	        	default:
	        			$this->redirect("/jobs");	        		        	
	        }
		}
		$narrowByItems = $this->narrowByItems($this->data); 
		$this->paginate = array(
            'limit' => isset($displayPageNo)?$displayPageNo:5,
            'order' => array(
                             "Job.$shortByItem" => 'asc',
                            ),
			'conditions'=>$narrowByItems

        );
        foreach($narrowByItems as $key=>$value){
	        if(strstr($key,"salary_from")){
		       $salaryFrom = $value/1000;
		    }
   	        if(strstr($key,"salary_to")){
		       $salaryTo = $value/1000;
		    }
        }
        $this->set('salaryFrom',isset($salaryFrom)?$salaryFrom:1);      
        $this->set('salaryTo',isset($salaryTo)?$salaryTo:150);      
		$jobs = $this->paginate('Job');
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		$industries = $this->Industry->find('all');
		$industries_array = array();
		foreach($industries as $industry){
			$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
		}
		$this->set('industries',$industries_array);

		$cities = $this->City->find('all',array('conditions'=>array('City.state_code'=>'AK')));
		$cities_array = array();
		foreach($cities as $city){
			$cities_array[$city['City']['city']] =  $city['City']['city'];
		}
		$this->set('cities',$cities_array);
		
		$states = $this->State->find('all');
		$state_array = array();
		foreach($states as $state){
			$state_array[$state['State']['state']] =  $state['State']['state'];
		}
		$this->set('states',$state_array);

		$specifications = $this->Specification->find('all');
		$specification_array = array();
		foreach($specifications as $specification){
			$specification_array[$specification['Specification']['id']] =  $specification['Specification']['name'];
		}
		$this->set('specifications',$specification_array);

        $urls = $this->Companies->find('all');
		$url_array = array();
		foreach($urls as $url){
			$url_array[$url['Companies']['id']] =  $url['Companies']['company_url'];
		}
		$this->set('urls',$url_array);
		
		$companies = $this->Companies->find('all');
		$companies_array = array();
		foreach($companies as $company){
			$companies_array[$company['Companies']['user_id']] =  $company['Companies']['company_name'];
		}
		$this->set('companies',$companies_array);
		
		if(isset($this->params['id'])){
			$id = $this->params['id'];
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			if($job['Job']){
				$this->set('job',$job['Job']);
			}
			else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/');
			}	
		}		
	}

     
      

	function narrowByItems($filterParams){
		$params_array = array();
		$flag = false;
		foreach($filterParams as $FPKey=>$FPValue){
			if($FPKey == '_Token'){
				continue;
			}
			$temp_array = array();
			foreach($FPValue as $key=>$value){
				if($value){
					if($key=='amount'){
					
						$temp_array = intval($value)*1000;
					}
					else{
						$temp_array[]= $key;
					}
					$flag = true;
				}
			}
			if(!$flag){
				continue;
			}
			if($FPKey == "salary_from")
			{
				$params_array[$FPKey." >= "] = $temp_array;
			}elseif($FPKey == "salary_to")
			{
				$params_array[$FPKey." <= "] = $temp_array;
			}  else {
			$params_array[$FPKey] = $temp_array;
			}
			$temp_array = null;
			$flag = false;
		}
	
	//echo "<pre>"; print_r($params_array); exit;
		return $params_array;
	}
}
?>
