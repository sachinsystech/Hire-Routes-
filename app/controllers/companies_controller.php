<?php


class CompaniesController extends AppController {

	var $name = 'Companies';
    var $uses = array('Company','Job','Industry','State','Specification','UserRoles');

	function postJob(){
	
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		if($userId){
			
			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
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
		}	
	
	}
	
	function getCurrentUserRole(){
		$userId = $this->Session->read('Auth.User.id');			
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleName  = null;
		switch($userRole['UserRoles']['role_id']){
			case 1:
					$roleName = 'company';
					break;
			case 2:
					$roleName = 'jobseeker';	
					break;			
			case 3:
					$roleName = 'networker';		
					break;			
		}
		$currentUserRole = array('role_id'=>$userRole['UserRoles']['role_id'],'role'=>$roleName);
		return $currentUserRole;
	}
	function index(){
		$userId = $this->Session->read('Auth.User.id');		
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		$jobs = $this->Job->find('all',array('conditions'=>array('Job.user_id'=>$userId)));
				
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		if($userId){

			$industries = $this->Industry->find('all');
			$industries_array = array();
			foreach($industries as $industry){
				$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
			}
			$this->set('industries',$industries_array);
			
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
		}	
	}

	function save(){
		$this->data['Job']['user_id'] = $this->Session->read('Auth.User.id');
		//echo "<pre>"; print_r($this->data); exit;
		$this->Job->save($this->data['Job']);
		$this->Session->setFlash('Job has been posted successfuly.', 'success');				
		$this->redirect('/companies/');
	}
	
	function editJob(){
		$userId = $this->params['userId'];
		$jobId = $this->params['jobId'];
		if($userId && $jobId){
	
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId)));
			if($jobs['Job']){
				$this->set('job',$jobs['Job']);	
			
				$industries = $this->Industry->find('all');
				$industries_array = array();
				foreach($industries as $industry){
					$industries_array[$industry['Industry']['id']] =  $industry['Industry']['name'];
				}
				$this->set('industries',$industries_array);
			
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
			}	
			else{
				$this->Session->setFlash('You may be clicked on old link.', 'error');				
				$this->redirect('/companies/');
			}
		}
		if(isset($this->data['Job'])){
			$this->data['Job']['user_id'] = $this->Session->read('Auth.User.id');
			$this->Job->save($this->data['Job']);
			$this->Session->setFlash('Job has been updated successfuly.', 'success');				
			$this->redirect('/companies/');
		}
		if(!isset($userId) || !isset($jobId)){
			$this->Session->setFlash('You may be clicked on old link.', 'error');				
			$this->redirect('/companies/');
		}

	}
}
?>
