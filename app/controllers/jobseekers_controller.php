<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';
	var $uses = array('JobseekerSettings','Jobseeker','User','UserRoles',
'FacebookUsers','Company','Job','Industry','State','Specification','Companies','City','JobseekerApply',
'JobseekerProfile');
	var $components = array('Email','Session','TrackUser','Utility');
	var $helpers = array('Time','Html','Javascript');	

	public function beforeFilter(){
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
		if($roleInfo['role_id']!=2){
			$this->redirect("/users/firstTime");
		}
	}
	
	function add() {
		$userId = $this->TrackUser->getCurrentUserId();
		$this->data['Jobseekers']['user_id'] = $userId;
		$this->data['Jobseekers']['specification_1'] = implode(',',$this->data['Jobseekers']['industry_specification_1']);
		$this->data['Jobseekers']['specification_2'] = implode(',',$this->data['Jobseekers']['industry_specification_2']);		
		$this->JobseekerSettings->save($this->data['Jobseekers']);		
		$this->Session->setFlash('Your Setting has been saved successfuly.', 'success');				
		$this->redirect('/jobseekers/setting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		//$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}

	function send(){
    	// Check the action is being invoked by the cron dispatcher
    	if (!defined('CRON_DISPATCHER')) { $this->redirect('/'); exit(); }

    		$this->layout = null; // turn off the layout
    
    	$userId = $this->TrackUser->getCurrentUserId();
		echo $userId;
	} 

	/* 	Jobseeker's Account-Profile page*/
	function index(){
		$userId = $this->TrackUser->getCurrentUserId();		
        if($userId){
        
        	$jobSeekerData = $this->Jobseeker->find('first',array('conditions'=>array('Jobseeker.user_id'=>$userId)));
			//echo "<pre>"; print_r($jobSeekerData); exit;
			if(!isset($jobSeekerData['Jobseeker']['contact_name'])){
				$this->redirect("/jobseekers/editProfile");						
			}
			/* User Info*/			
			$user = $this->User->find('all',array('conditions'=>array('id'=>$userId)));
			$this->set('user',$user[0]['User']);
			
			/* Jobseeker Info*/
			$jobseeker = $this->Jobseeker->find('all',array('conditions'=>array('user_id'=>$userId)));
			$this->set('jobseeker',$jobseeker[0]['Jobseeker']);
			$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('JobseekerSettings.user_id'=>$userId)));
			$this->set('jobseekerData',$jobseekerData['JobseekerSettings']);
			
			/* FB-User Info*/       		
        	$fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
	    	if(isset($fbinfos[0])){
				$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
	    	}
		}
	}	

	/* 	Setting and Subscriptoin page*/
	function setting() {
		$userId = $this->TrackUser->getCurrentUserId();		

		$jobseekerData = $this->JobseekerSettings->find('first',array('conditions'=>array('JobseekerSettings.user_id'=>$userId)));
		$this->set('jobseekerData',$jobseekerData['JobseekerSettings']);
		
		$industries = $this->Industry->find('all');
		$industry = $this->Utility->objectToKeyValueArray($industries, 'id', 'name', 'Industry');
		$this->set('industries',$industry);
	
		$cities = $this->City->find('all',array('conditions'=>array('City.state_code'=>'PA')));
		$city = $this->Utility->objectToKeyValueArray($cities, 'city', 'city', 'City');
		$this->set('cities',$city);
	
		$states = $this->State->find('all');
		$state = $this->Utility->objectToKeyValueArray($states, 'state', 'state', 'State');
		$this->set('states',$state);

		$specifications = $this->Specification->find('all');			
		$specification = $this->Utility->objectToKeyValueArray($specifications, 'id', 'name', 'Specification');
		$this->set('specifications',$specification);
	}

	/* 	Edit Jobseeker's Account-Profile*/   
    function editProfile() {
		$userId = $this->TrackUser->getCurrentUserId();
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			$this->Jobseeker->save($this->data['Jobseeker']);		
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/jobseekers');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);

        if(isset($user['Jobseekers'][0])){
        	$this->set('jobseeker',$user['Jobseekers'][0]);
        }

        $fbinfos = $this->FacebookUsers->find('all',array('conditions'=>array('user_id'=>$userId)));
        if(isset($fbinfos[0])){
			$this->set('fbinfo',$fbinfos[0]['FacebookUsers']);
        }

	}

      function appliedJob() {

        $userId = $this->TrackUser->getCurrentUserId();	

        $user_jobs = $this->JobseekerApply->find('all',array('conditions'=>array('user_id'=>$userId)));
        
        $n = 0; $job_ids = "";
        foreach($user_jobs as $ujob)
          {
             $job_ids[$n] = $ujob['JobseekerApply']['job_id'];
             $n++;
          } 

        $shortByItem = 'id';
        
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
		
		$this->paginate = array(
            'conditions'=>array('id'=>$job_ids),
            'limit' => isset($displayPageNo)?$displayPageNo:5,
            'order' => array(
                             "Job.$shortByItem" => 'asc',
                            ));
        
           
		$jobs = $this->paginate('Job');
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		$this->set('industries',$this->Utility->getIndustry());	
		$this->set('cities',$this->Utility->getCity());		
		$this->set('states',$this->Utility->getState());
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
		}
            
            // job role
            $userId = $this->Session->read('Auth.User.id');

            //$this->set('userrole',$roleInfo);
     }

	function newJob(){
		$userId = $this->TrackUser->getCurrentUserId();	
	
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        

        $jobseeker_settings = $this->JobseekerSettings->find('first',array('conditions'=>array('user_id'=>$userId)));
        
        $industry1 		= $jobseeker_settings['JobseekerSettings']['industry_1'];
		$industry2 		= $jobseeker_settings['JobseekerSettings']['industry_2'];
        $industry       = array(0=>$industry1, 1=>$industry2);
		$specification1 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_1']);
	    $specification2 = explode(",",$jobseeker_settings['JobseekerSettings']['specification_2']);
		$specification  = array_merge($specification1, $specification2);
	    $city 			= $jobseeker_settings['JobseekerSettings']['city'];
		$state 			= $jobseeker_settings['JobseekerSettings']['state'];
		$salary_range   = $jobseeker_settings['JobseekerSettings']['salary_range'];
        
       
		$shortByItem = 'id';
        
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

		$cond = array('OR' => array(array('industry' => $industry),
                                    array('specification' => $specification),
                                    array('city ' => $city),
                                    array('state' => $state),
                                    array('salary_from <' => $salary_range),
									array('salary_to >' => $salary_range)));		

		$this->paginate = array('conditions'=>$cond,
                                'limit' => isset($displayPageNo)?$displayPageNo:5,
                                'order' => array("Job.$shortByItem" => 'asc',));
        
        $jobs = $this->paginate('Job');
		
		$jobs_array = array();
		foreach($jobs as $job){
			$jobs_array[$job['Job']['id']] =  $job['Job'];
		}
		$this->set('jobs',$jobs_array);
		
		$this->set('industries',$this->Utility->getIndustry());	
		$this->set('cities',$this->Utility->getCity());		
		$this->set('states',$this->Utility->getState());
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
		}
	}
    
   function delete(){
        
        $deleteID = $this->params['id'];
        $userId = $this->TrackUser->getCurrentUserId();

       if($this->params['id']){
            $jobseekerapply = $this->JobseekerApply->find('all',array('conditions' => array('job_id' =>$deleteID,'user_id'=>$userId))); 
            

            foreach($jobseekerapply as $deljob)
              {
                 $oldresume = $deljob['JobseekerApply']['resume'];
                 $oldcoverletter = $deljob['JobseekerApply']['cover_letter'];
                 $this->JobseekerApply->delete($deljob['JobseekerApply']['id']);
                 @unlink(BASEPATH."webroot/files/resume/".$oldresume);
                 @unlink(BASEPATH."webroot/files/cover_letter/".$oldcoverletter);
              }
                $this->Session->setFlash('Job successfully deleted.', 'success'); 
           }
            else{
                $this->Session->setFlash('May be you click on old link or manually enter URL.', 'error'); 
        }	
        $this->redirect('/jobseekers/appliedJob');	  
   }

	function jobProfile(){
		$userId = $this->TrackUser->getCurrentUserId();
		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);

        $jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);

		if(isset($this->data['JobseekerProfile'])){

			if(is_uploaded_file($this->data['JobseekerProfile']['resume']['tmp_name'])){
        		$resume = $this->data['JobseekerProfile']['resume'];                 
            	if($resume['error']!=0 ){
                	$this->Session->setFlash('Uploaded File is corrupted.', 'error');    
                    $this->redirect('/jobs/applyJob/'.$job_id);          
                }
                $type_arr = explode("/",$resume['type']);
                $type = $type_arr[1];
                if($type!= 'pdf' && $type!= 'txt' && $type!= 'doc'){
                	$this->Session->setFlash('File type not supported.', 'error');        
                    $this->redirect('/jobs/applyJob/'.$job_id);
                }
                $randomNumber = rand(1,100000000000);            
                $uploadedFileName=$randomNumber.$resume['name'];
                
                if(move_uploaded_file($resume['tmp_name'],BASEPATH."webroot/files/resume/".$uploadedFileName)){
                	$this->data['JobseekerProfile']['resume'] = $uploadedFileName;
                }
			}else{
				$this->data['JobseekerProfile']['resume'] = $jobprofile['JobseekerProfile']['resume'];
			}

			if(is_uploaded_file($this->data['JobseekerProfile']['cover_letter']['tmp_name'])){
				$cover_letter = $this->data['JobseekerProfile']['cover_letter'];                 
            	if($cover_letter['error']!=0 ){
                	$this->Session->setFlash('Uploaded File is corrupted.', 'error');    
                    $this->redirect('/jobs/applyJob/'.$job_id);          
                }
                $type_arr1 = explode("/",$cover_letter['type']);
                $type1 = $type_arr1[1];
                if($type1!= 'pdf' && $type1!= 'txt' && $type1!= 'doc'){
                	$this->Session->setFlash('File type not supported.', 'error');        
                    $this->redirect('/jobs/applyJob/'.$job_id);
                }
                $randomNumber2 = rand(1,100000000000);            
                $uploadedFileName2=$randomNumber2.$cover_letter['name'];
                
                if(move_uploaded_file($cover_letter['tmp_name'],BASEPATH."webroot/files/cover_letter/".$uploadedFileName2)){
                	$this->data['JobseekerProfile']['cover_letter'] = $uploadedFileName2;
                }
			}else{
				$this->data['JobseekerProfile']['cover_letter']=$jobprofile['JobseekerApply']['cover_letter'];
			}            
			
			$this->JobseekerProfile->save($this->data['JobseekerProfile']);
			$this->Session->setFlash('Profile Infomation has been updated successfuly.', 'success');	
			$this->redirect('jobProfile');					
		}
	}

	function viewResume(){
		$userId = $this->TrackUser->getCurrentUserId();
        		
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);

		
		if(isset($this->params['pass'][1])){
			$id = $this->params['pass'][1];
			$file_type = $this->params['pass'][0];
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
					$this->redirect('/jobs/jobProfile');
				}				
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
				$this->redirect('/jobs/jobProfile');
			}
		}		
	}
}
?>
