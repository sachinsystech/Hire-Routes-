<?php

class UtilityComponent extends Object
{
	var $controller = true;
	var $components = array('Session','Auth','Email');
	var $uses = array('Industry','State','City','Specification','FacebookUsers','UserList','Config','Networkers',
					'University','Companies','UserRoles','Job','GraduateDegree','GraduateUniversityBreakdown',
					'InvitaionCode','Invitations');
	
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
		return $this->Industry->find('list', array('fields' => array('Industry.name'),'order'=>array('id')));
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
    	$userRole=$this->Session->read('userRole');
    	if($userRole!=COMPANY){
	        $saveCode = $this->Session->read('intermediateCode');
    	    if($saveCode){
    	        $str = base64_decode($saveCode);
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
        if($userRole==JOBSEEKER){
        	return null;
        }
        return base64_encode($passJobId."^".$userId);
    }
    /*** end ****/
    
    /** Get jobId from code if valid **/
    function getJobIdFromCode($passJobId=NULL,$code){
    	$str = base64_decode($code);
		$data = explode("^",$str);
    	$jobId = $data[0];
    	if(empty($passJobId)){
    		return $jobId;
    	}
    	if($jobId == $passJobId)
    		return $jobId;
    	return false;
    }
    /*** end ***/

    /** It returns recent user id from Code which is set by URL  **/ 
    function getRecentUserIdFromCode(){
        $saveCode = $this->Session->read('intermediateCode');
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
        $saveCode = $this->Session->read('intermediateCode');
        if($saveCode){
            $str = base64_decode($saveCode);
            $code="";
            $data = explode("^",$str);
             if(count($data)>1){
				if($jobId == $data[0]){
					$ids = split(":",$data[1]);
					$userRole=$this->getUserRole($ids[0]);
					if($userRole['id']==COMPANY){
						$user_ids='';
						for($i=0;$i<count($ids)-1;$i++)
							$user_ids[$i]=$ids[$i+1];
						$ids=$user_ids;
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
		$thisUserRole = array('id'=>$userRole['UserRoles']['role_id'],'name'=>$roleName);
		return $thisUserRole;
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
	
/**
 * To store before Authenticate URL
 */	
	function setRedirectionUrl(){
		$redirect_url=$this->referer();
		if(preg_match('/^\/jobs\/jobDetail\/[0-9]+\/?[.*]?/',$redirect_url)){
			$this->Session->write('redirection_url',$redirect_url);
		}
		return true;
	}	
/**
	Match the format of the date
*/	
	function checkDateFormat($date){
	
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)){
			if(checkdate($parts[2],$parts[3],$parts[1]))
			  return true;
			else
			 return false;
		}
		else
			return false;
	}
	
	function stripTags($stripTagsArray){
		foreach($stripTagsArray as $key =>$value ){
			$stripTagsArray[$key] = htmlentities(strip_tags($value), ENT_QUOTES);
		}
		return $stripTagsArray;
	}
	
	function htmlEntityDecode($DecodeArray){
		foreach($DecodeArray as $key =>$value ){
			$DecodeArray[$key] = html_entity_decode($value);
		}
		return $DecodeArray;
	}
	
	function getGraduateDegrees(){
		$GraduateDegrees=$this->GraduateDegree->find('list',array('fields'=>'id,degree', 'order'=>'id'));
		return $GraduateDegrees;

	}
	
	function getUniversities(){
		$universities=$this->University->find('list',array('fields'=>'id, name', 'order'=>'id'));
		return $universities;
	}
	
	public function setNetworkerPoints($user){
 		
 		if(isset($user) && $user != null){
	 		$parentUserId =$user['User']['parent_user_id'];
			if(isset( $parentUserId) &&  $parentUserId != null){
				$parentData = $this->UserList->find('first', array('conditions'=>array('UserList.id'=>$parentUserId),'fields'=>array('UserList.id,UserRoles.role_id ,Networkers.*')));
				if($user['UserRoles'][0]['role_id'] == JOBSEEKER && $parentData['UserRoles']['role_id'] == NETWORKER){
					$point =  $this->Config->field("value", array("Config.key ='jobseekers_point_number'"));
				}
				if($user['UserRoles'][0]['role_id'] == COMPANY && $parentData['UserRoles']['role_id'] == NETWORKER){
					$point =  $this->Config->field("value", array("Config.key ='company_point_number'"));
				}
				if($user['UserRoles'][0]['role_id'] == NETWORKER && $parentData['UserRoles']['role_id'] == NETWORKER){
					$university = $this->University->find('first',
							array('conditions' =>
								array('id'=>$user['Networkers'][0]['university'])));
					$point = isset($university['University']['points'] )
								? $university['University']['points'] :0;
					$graduateUniversity = $this->GraduateUniversityBreakdown->find('first',
							array( 'conditions'=>
							array('degree_type'=>$user['Networkers'][0]['graduate_degree_id'],
								'id'=>$user['Networkers'][0]['graduate_university_id'])));

					$point +=  isset( $graduateUniversity['GraduateUniversityBreakdown']['points'] )
								?$graduateUniversity['GraduateUniversityBreakdown']['points']: 0;

				}
				if( isset($point) && $point != null){		
					$parentData['Networkers']['points']+= $point;
					if(!$this->Networkers->save($parentData['Networkers'], false)){ 
						$this->Session->setFlash('Internal Error!', 'error');
						$this->redirect("/");
					}
				}
			}
		}
		return true;
 	}
 	
 	function getRecentJobs(){
 		$jobs = $this->Job->find('all',	array('limit'=>2,
											 'joins'=>array(
														array('table' => 'industry',
										                      'alias' => 'ind',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.industry = ind.id',)),
										            	array('table' => 'cities',
															   'alias' => 'city',
															   'type' => 'LEFT',
															   'conditions' => array('Job.city = city.id',)),
														array('table' => 'states',
															   'alias' => 'state',
															   'type' => 'LEFT',
															   'conditions' => array('Job.state = state.id',)),
														array('table' => 'specification',
											 				   'alias' => 'spec',
															   'type' => 'LEFT',
															   'conditions' => array('Job.specification = spec.id',)),	   
										            	array('table' => 'companies',
										                      'alias' => 'companies',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.company_id = companies.id',)),	  
											),
										 'order' => array("Job.created" => 'desc'),
										 'conditions'=>array('Job.is_active'=>1),
										'fields'=>array('Job.id,Job.title,Job.reward, companies.company_name, state.state  as name,city.city as name,ind.name, spec.name'),));
										
			return $jobs;							
 	}
 	
 	function deleteInvitationCode(){
 		$inviteCode = $this->Session->read('invitationCode');
 		$this->InvitaionCode->updateAll(array("status"=>1), array('invitaion_code'=>$inviteCode,
																  'status'=>0,
		));
		
		$this->Session->delete('invitationCode');
 	}
	
	function setIccCode($userId= null){
		$iv1 = array('ic_code'=> null,'status'=>'1');
		$iv2 = array('invited_user_id =' => $userId);
		if(! $userId == null){
			if(! $this->Invitations->updateAll($iv1,$iv2)) {
				$this->Session->setFlash('Internal Error!', 'error');
				return;
			}
		}
		$iv2 = array('ic_code =' => $this->Session->read('icc'));
		if($this->Session->read('icc') != null){
			if(! $this->Invitations->updateAll($iv1,$iv2)) {
				$this->Session->setFlash('Internal Error!', 'error');
				return;
			}
		}
	}
}
?>
