<?php
class JobsController extends AppController {
    var $uses = array('Company','Job','Industry','State','Specification' , 'UserRoles','Companies','City','JobseekerApply','JobseekerProfile','JobViews');
	var $helpers = array('Form','Paginator','Time');
	var $components = array('Session','TrackUser','Utility');
        
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('index');
		$this->Auth->allow('apply');
		$this->Auth->allow('applyJob');
		$this->Auth->allow('jobDetail');
		$this->Auth->allow('viewResume');
     }
	
	function index(){

		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();

    	$shortByItem = 'created';
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
                             "Job.$shortByItem" => 'desc',
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

         // find section
        $what=""; $whr=""; 
        if(isset($this->data['FilterJob'])){
            
        $what = $this->data['FilterJob']['what'];
        $whr  = $this->data['FilterJob']['where'];
          
        $ind_find = $this->Industry->find('all',array('conditions'=>array('name LIKE'=>"%$what%")));
        $n = 0; $ind_ids = "";
        foreach($ind_find as $ind){
             $ind_ids[$n] = $ind['Industry']['id'];
             $n++;
        }
		  
        $spec_find = $this->Specification->find('all',array('conditions'=>array('name LIKE'=>"%$what%")));
        $t = 0; $spec_ids = "";
        foreach($spec_find as $spec){
             $spec_ids[$t] = $spec['Specification']['id'];
             $t++;
        }         
          
        $cond = array('OR' => array(array('industry' => $ind_ids),
                                    array('specification' => $spec_ids),
                                    array('city ' => $whr),
                                    array('state' => $whr)));
           
        $this->paginate = array('conditions'=>$cond,
                                'limit' => isset($displayPageNo)?$displayPageNo:5,
                                'order' => array("Job.$shortByItem" => 'asc',));             
        } // find ends here   
        
        $jobs = $this->paginate('Job');
        
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		$this->set('industries',$this->Utility->getIndustry());


		$this->set('location',$this->Utility->getState());
		$this->set('companies',$this->Utility->getCompany());
		$this->set('specifications',$this->Utility->getSpecification());        	

       		$this->set('urls',$this->Utility->getCompany('url'));
		
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
             // job role
            $userId = $this->Session->read('Auth.User.id');
            $roleInfo = $this->getCurrentUserRole();
            $this->set('userrole',$roleInfo);
			$jobapply = $this->JobseekerApply->find('first',array('conditions'=>array('user_id'=>$userId,'job_id'=>$id)));
			if($jobapply){
    			$this->set('jobapply',$jobapply);
			}			
		}
 	}



    function getCurrentUserRole(){
		$userId = $this->TrackUser->getCurrentUserId();		
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

    function applyJob(){	

		// Jobseeker's profile information
		$userId = $this->TrackUser->getCurrentUserId();
        $roleInfo = $this->getCurrentUserRole();
        $this->set('userrole',$roleInfo);
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$jobprofile['JobseekerProfile']['file_id'] = $jobprofile['JobseekerProfile']['id'];
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);
		$this->set('is_resume', $jobprofile['JobseekerProfile']['resume']);
		$this->set('is_cover_letter', $jobprofile['JobseekerProfile']['cover_letter']);

		// Job information
		if(isset($this->params['jobId'])){
			$id = $this->params['jobId'];
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			if($job['Job']){
				$this->set('job',$job['Job']);
			}
			else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/');
			}
		}

		//  Apply for this job		
		if (isset($this->data['JobseekerApply'])) {
	    	$job_id = $this->data['JobseekerApply']['job_id'];
			$this->data['JobseekerApply']['file_id'] = $jobprofile['JobseekerProfile']['id'];
			
            
			if(is_uploaded_file($this->data['JobseekerApply']['resume']['tmp_name'])){
        		$resume = $this->data['JobseekerApply']['resume'];                 
            	if($resume['error']!=0 ){
                	$this->Session->setFlash('Uploaded File is corrupted.', 'error');
					$this->data['JobseekerApply']['resume'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerApply']);  
					$this->render("apply_job"); 
					return;          
                }
                $type_arr = explode(".",$resume['name']);
                $type = $type_arr[1];
                if($type!= 'pdf' && $type!= 'txt' && $type!= 'doc'){
					$this->Session->setFlash('File type not supported.', 'error');
                	$this->data['JobseekerApply']['resume'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerApply']);  
					$this->render("apply_job"); 
					return;
                }
                $randomNumber = rand(1,100000000000);            
                $uploadedFileName=$randomNumber.$resume['name'];
                
                if(move_uploaded_file($resume['tmp_name'],WWW_ROOT."files/resume/".$uploadedFileName)){
                	$this->data['JobseekerApply']['resume'] = $uploadedFileName;
                }
			}else{
				$this->data['JobseekerApply']['resume'] = $jobprofile['JobseekerProfile']['resume'];
			}

			if(is_uploaded_file($this->data['JobseekerApply']['cover_letter']['tmp_name'])){
				$cover_letter = $this->data['JobseekerApply']['cover_letter'];                 
            	if($cover_letter['error']!=0 ){
					$this->Session->setFlash('Uploaded File is corrupted.', 'error');   
                	$this->data['JobseekerApply']['cover_letter'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerApply']);  
					$this->render("apply_job"); 
					return;          
                }
                $type_arr1 = explode(".",$cover_letter['name']);
                $type1 = $type_arr1[1];
                if($type1!= 'pdf' && $type1!= 'txt' && $type1!= 'doc'){
					$this->Session->setFlash('File type not supported.', 'error');
                	$this->data['JobseekerApply']['cover_letter'] = ""; 
					$this->set('jobprofile',$this->data['JobseekerApply']);  
					$this->render("apply_job"); 
					return;
                }
                $randomNumber2 = rand(1,100000000000);            
                $uploadedFileName2=$randomNumber2.$cover_letter['name'];
                
                if(move_uploaded_file($cover_letter['tmp_name'],WWW_ROOT."files/cover_letter/".$uploadedFileName2)){
                	$this->data['JobseekerApply']['cover_letter'] = $uploadedFileName2;
                }
			}else{
				$this->data['JobseekerApply']['cover_letter'] = $jobprofile['JobseekerProfile']['cover_letter'];
			}           
                   
		if($intermediateUsers=$this->Utility->getIntermediateUsers($this->params['jobId']))
            $this->data['JobseekerApply']['intermediate_users'] = $intermediateUsers;
		$this->JobseekerApply->save($this->data['JobseekerApply']);
		
		// If user doesnt have a job profile 
		if(!$jobprofile){
			$this->JobseekerProfile->save($this->data['JobseekerApply']);
		}           
        $this->Session->setFlash('You have applied for this job successfully.', 'success');   
        $this->redirect('/jobseekers/appliedJob');     
        }
	}

	function viewResume(){
		$userId = $this->TrackUser->getCurrentUserId();
        		
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);

		
		if(isset($this->params['id'])){

			$job_id = $this->params['jobId'];
			$id = $this->params['id'];
			$file_type = $this->params['filetype'];
			$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('id'=>$id)));
			if($jobprofile['JobseekerProfile']){

				if($file_type=='resume'){
					$file = $jobprofile['JobseekerProfile']['resume'];
					$fl = BASEPATH."webroot/files/resume/".$file;
				}
				if($file_type=='cover_letter'){
					$file = $jobprofile['JobseekerProfile']['cover_letter'];
					$fl = BASEPATH."webroot/files/cover_letter/".$file;
				}				
				
				if (file_exists($fl)){
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename='.basename($fl));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($fl));
					ob_clean();
					flush();
					readfile($fl);
					exit;
				}else{
					$this->Session->setFlash('File does not exist.', 'error');				
					$this->redirect('/jobs/applyJob/'.$job_id); 
				}				
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/applyJob/'.$job_id); 
			}
		}		
	} 

	function jobDetail(){

		$userId = $this->TrackUser->getCurrentUserId();
		$roleInfo = $this->getCurrentUserRole();  
		
		if(isset($this->params['jobId'])){

			$id = $this->params['jobId'];		
			
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id),
												  'joins'=>array(array('table' => 'industry',
										                               'alias' => 'ind',
										             				   'type' => 'LEFT',
										             				   'conditions' => array('Job.industry = ind.id',)),
											   			         array('table' => 'specification',
										             				   'alias' => 'spec',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.specification = spec.id',)),
																 array('table' => 'companies',
										             				   'alias' => 'comp',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.company_id = comp.id',)),
																 array('table' => 'cities',
										            				   'alias' => 'city',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.city = city.id',)),
											                     array('table' => 'states',
										                               'alias' => 'state',
										                               'type' => 'LEFT',
										                               'conditions' => array('Job.state = state.id',))
																),
												 'fields'=>array('Job.id ,Job.user_id,Job.title,Job.company_id,Job.company_name,city.city,state.state,Job.job_type,
Job.short_description, Job.reward, Job.created, Job.salary_from, Job.salary_to, Job.description, ind.name as industry_name, spec.name as specification_name, comp.company_url'),));

			if($job){
	
				if($roleInfo['role_id']!=1){
					$this->data['JobViews']['job_id'] = $id;
					if(isset($userId)){
						$this->data['JobViews']['user_id'] = $userId;
					}else{
						$this->data['JobViews']['user_id'] = 0;
					}
			   
				    $this->JobViews->save($this->data['JobViews']);
			    }
				$this->set('job',$job);
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/');
			}	

             // job role            
            
            $this->set('userrole',$roleInfo);
			$jobapply = $this->JobseekerApply->find('first',array('conditions'=>array('user_id'=>$userId,'job_id'=>$id)));
			if($jobapply){
    			$this->set('jobapply',$jobapply);
			}
            /*** code for networker trac **/
            if($userId ){
                $role = $this->TrackUser->getCurrentUserRole();
                if($role['role_id'] == 3)
                    $this->set('code',$this->Utility->getCode($id,$userId));
            }
            /**** end code ***/			
		}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/');
		}       
                       
	}

}
?>
