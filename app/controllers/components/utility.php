<?php

class UtilityComponent extends Object
{
	var $controller = true;
	var $components = array('Session','Auth','Email');
	var $uses = array('Industry','State','City','Specification','FacebookUsers','Companies','UserRoles','Job');
	
	function initialize(&$controller) {
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}		
	}

	function startup(&$controller){

	}
	
	function getIndustry(){
		return $this->Industry->find('list', array('fields' => array('Industry.name')));
	}
	
	function getState(){
		return $this->State->find('list', array('fields' => array('State.state')));
	}
	
	function getCity(){
		$params = array(
					   'conditions' => array('City.state_code'=>'DE'), 
					   'fields' => array('City.city','City.city') 
					   );
 
		return $this->City->find('list',$params);
	}

	function getCities(){
		return $this->City->find('list', array('conditions' => array('City.state_code'=>'DE'),'fields' => array('City.city')));
	}
	
	function getSpecification(){
		return $this->Specification->find('list', array('fields' => array('Specification.name')));
	}

	function getCompany($by = null){
		if($by=='url'){
			$by = 'company_url';
			return $this->Companies->find('list', array('fields' => array("Companies.$by")));
		}
		else{
			return $this->Companies->find('list', array('fields' => array("Companies.id","Companies.company_name")));
		}
	}
	
	function objectToKeyValueArray($objectArray, $key, $value, $modelName){
		$object_to_key_value_array = array();
		foreach($objectArray as $ob){
			$object_to_key_value_array[$ob[$modelName][$key]] = $ob[$modelName][$value];
		}		
		return $object_to_key_value_array;
	}

    /** it will return job code for current user **/
    function getCode($passJobId,$userId){
    	$userRole=$this->Session->read('user_role');
    	if($userRole['role_id']!=COMPANY){
	        $saveCode = $this->Session->read('code');
    	    if($saveCode){
    	        $str = base64_decode($saveCode);
		    //echo $str;
    	        $code="";
    	        $data = explode("^",$str);
    	        $jobId = $data[0];
    	        $ids = split(":",$data[1]);
    	        if($jobId == $passJobId && $ids!=false && count($ids)>0){
    	            if(in_array($userId,$ids)){
    	                $code = $saveCode;                    
    	            }else{
		                $ids[] = $userId;
		                $str = implode(":",$ids);
    	                $str = $jobId."^".$str;
		                $code = base64_encode($str);
    	            }
    	            return $code;
            	}
        	}
        }
        return base64_encode($passJobId."^".$userId);
    }
    /*** end ****/
    
    /** Get jobId from code if valid **/
    function validateCode($passJobId,$code){
    	$str = base64_decode($code);
		$data = explode("^",$str);
    	$jobId = $data[0];
    	if($jobId == $passJobId)
    		return $jobId;
    	return false;
    }
    /*** end ***/

    /** It returns recent user id from Code which is set by URL  **/ 
    function getRecentUserIdFromCode(){
        $saveCode = $this->Session->read('code');
        if($saveCode){
            $str = base64_decode($saveCode);
            echo $str;
            $code="";
            $data = explode("^",$str);
            if(count($data)>1){
                $ids = split(":",$data[1]);
                return array_pop($ids);
            }
            
        }
        return null;
    }

    /*** It will return all intermediate users ***/
    function getIntermediateUsers($jobId){
        $saveCode = $this->Session->read('code');
        if($saveCode){
            $str = base64_decode($saveCode);
            $code="";
            $data = explode("^",$str);
             if(count($data)>1){
				if($jobId == $data[0]){
					$ids = split(":",$data[1]);
					$userRole=$this->getUserRole($ids[0]);
					if($userRole['UserRoles']['role_id']==COMPANY){
						unset($ids[0]);
					}
                   return implode(",",$ids);
               }
        	}
        }
        return null;
    }
    
    function getUserRole($userId){
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
		//$currentUserRole = array('role_id'=>$userRole['UserRoles']['role_id'],'role'=>$roleName);
		return $userRole;
	}

/**
 * Retrieves all activated jobs as default OR particular job by given job-id
 * passed $jobId param to get particular job.
 *
 * @param int $jobId : optional
 * @return  job(s) if found, otherwise null
 * @access public
 */	
	function getJob($jobId=null){
		$type = 'all'; 
		$condition = array('Job.is_active'=>1);
		if(isset($jobId)){
			$type = 'first';
			$condition['Job.id'] = $jobId;
		}
		$job = $this->Job->find($type,array('conditions'=>$condition,
			  'joins'=>array(array('table' => 'industry',
	                               'alias' => 'ind',
	             				   'type' => 'LEFT',
	             				   'conditions' => array('Job.industry = ind.id',)),
		   			         array('table' => 'specification',
	             				   'alias' => 'spec',
	                               'type' => 'LEFT',
	                               'conditions' => array('Job.specification = spec.id',)),
							 array('table' => 'cities',
	            				   'alias' => 'city',
	                               'type' => 'LEFT',
	                               'conditions' => array('Job.city = city.id',)),
		                     array('table' => 'states',
	                               'alias' => 'state',
	                               'type' => 'LEFT',
	                               'conditions' => array('Job.state = state.id',)),
		                     array('table' => 'companies',
	                               'alias' => 'comp',
	                               'type' => 'LEFT',
	                               'conditions' => array('Job.company_id = comp.id',)),
	                               
							),
			 'order'=>array('Job.id'=>'asc'),				
			 'fields'=>array('Job.*, ind.name, city.city, state.state, spec.name, comp.company_name' ), ));
		if(!$job){
			return null;
		}
		$job['Job']['industry'] = $job['ind']['name'];
		$job['Job']['specification'] = $job['spec']['name'];
		$job['Job']['city'] = $job['city']['city'];
		$job['Job']['state'] = $job['state']['state'];
		$job['Job']['company_name'] = $job['comp']['company_name'];
		unset($job['ind']);
		unset($job['spec']);
		unset($job['city']);
		unset($job['state']);
		unset($job['comp']);
		return $job;										 
	}
}
?>
