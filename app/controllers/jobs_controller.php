<?php
class JobsController extends AppController {

    var $uses = array('Company','Companies','Job','JobseekerApply','JobseekerProfile','JobViews','Jobseeker','University');
	var $helpers = array('Form','Paginator','Time','Number');
	var $components = array('Session','TrackUser','Utility');
        
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('index');
		$this->Auth->allow('searchJob');
		$this->Auth->allow('apply');
		$this->Auth->allow('applyJob');
		$this->Auth->allow('jobDetail');
		$this->Auth->allow('viewResume');
		$this->Auth->allow('shareJob');
		$session = $this->_getSession();
		if($this->params['action']!= "index" && $session->getUserRole()==NETWORKER){
			$jobCounts = $this->requestAction("/Networkers/jobCounts");
			$this->set('SharedJobs',$jobCounts['sharedJobs']);
			$this->set('ArchiveJobs',$jobCounts['archivejobs']);
			$this->set('NewJobs',$jobCounts['newJobs']);	
		}
		if($this->params['action']!= "index" && $session->getUserRole()==JOBSEEKER){
			$jobCounts = $this->requestAction("/Jobseekers/jobCounts");
			$this->set('AppliedJobs',$jobCounts['appliedJob']);
			$this->set('NewJobs',$jobCounts['newJob']);
			$this->set('Archivedjobs',$jobCounts['archiveJob']);
		}
		if($this->params['action']!= "index" && $session->getUserRole()==COMPANY){
			$this->set('activejobCount', $this->requestAction("/Companies/getCompanyActiveJobsCount"));
			$this->set('archJobCount',   $this->requestAction("/Companies/getCompanyArchiveJobsCount"));
		}
     }
	
	function index(){
        $this->layout = "home";
        $conditions = array();
        $salaryFrom = null;
        $salaryTo = null;
        if( (isset($this->params['form']['search']) && $this->params['form']['search'] =="FIND" ) || $this->Session->read("FilterJob")){
            if(!isset($this->data['FilterJob'])){
                $this->data['FilterJob'] = $this->Session->read("FilterJob");
            }else{
                $this->Session->write("FilterJob",$this->data['FilterJob']);
            }
            $what = $this->data['FilterJob']['what']; 
            $this->set('what',$what);
            
            if($this->data['FilterJob']['what']!=""){
                           
                $conditions[] = array('OR'=>array(
                                                     'Job.title LIKE'=>"%$what%",
                                                     'company.company_name LIKE'=>"%$what%",
                                                     'spec.name LIKE'=>"%$what%",
                                                     'ind.name LIKE'=>"%$what%",
                                                  )
                                        );
            }
            $where  = $this->data['FilterJob']['where'];
            $this->set('where',$where);
            if($this->data['FilterJob']['where']!=""){
                $conditions[] = array( 
                                        'OR'=> array(
                                                            'city.city LIKE'=>"%$where%",
                                                            'state.state LIKE'=>"%$where%",
                                                            'ind.name LIKE'=>"%$where%",
                                                    )
                                    );       

            }
        }
        if((isset($this->params['form']['save']) && $this->params['form']['save'] =="Reset Settings")){
        	unset($this->data['NarrowJob']);
        	if($this->Session->check('NarrowJob')){
        		$this->Session->delete('NarrowJob');
        	}
			
        }elseif((isset($this->params['form']['save']) && $this->params['form']['save'] =="SEARCH" ) || $this->Session->read("NarrowJob")){
            if(!isset($this->data['NarrowJob'])){
                $this->data['NarrowJob'] = $this->Session->read("NarrowJob");
            }else{
                $this->Session->write("NarrowJob",$this->data['NarrowJob']);
            }
            if(!empty($this->data['NarrowJob']['industry']) && $this->data['NarrowJob']['industry'] && !in_array(1,$this->data['NarrowJob']['industry'])){
                $industry = $this->data['NarrowJob']['industry'];
                $conditions[] =array('industry'=>$industry);
                $this->set('industry',$industry);
            }
            if(!empty($this->data['NarrowJob']['state'])&&$this->data['NarrowJob']['state']){
                $location = $this->data['NarrowJob']['state'];
                $conditions[] = array('state.id'=>$location);
                $this->set('location',$location);
            }
            if(isset($this->data['NarrowJob']['job_type'])&&$this->data['NarrowJob']['job_type']){
                $job_type = $this->data['NarrowJob']['job_type'];
                $conditions[] = array('job_type'=>$job_type);
                $this->set('job_type',$job_type);
            }
            if(isset($this->data['NarrowJob']['salary_from'])){
                $salaryFrom = $this->data['NarrowJob']['salary_from'];
                $salaryFrom = str_replace("K", "", $salaryFrom);
                $conditions[] = array('salary_from >='=>($salaryFrom*1000));
            }
            if(isset($this->data['NarrowJob']['salary_to'])){
                $salaryTo = $this->data['NarrowJob']['salary_to'];
                $salaryTo = str_replace("K", "", $salaryTo);
                $conditions[] = array('salary_to <='=>($salaryTo*1000));
            }
            
            if(!empty($this->data['NarrowJob']['company_name']) && $this->data['NarrowJob']['company_name']){
                $company_name = $this->data['NarrowJob']['company_name'];
                $conditions[] = array('company.id'=>$company_name);
                $this->set('company_name',$company_name);
            }
        }

        $conditions[] = array('Job.is_active'=>1);

    	if(isset($this->params['named']['display'])){
	        $displayPageNo = $this->params['named']['display'];
	        $this->set('displayPageNo',$displayPageNo);
		}
		
		$shortByItem = array('Job.created'=> 'desc');
		if(isset($this->params['named']['shortby'])){
	        $shortBy = $this->params['named']['shortby'];
	        $this->set('shortBy',$shortBy);
	        switch($shortBy){
	        	case 'date-added':
	        				$shortByItem = array('Job.created'=> 'desc'); 
	        				break;	
	        	case 'company-name':
	        				$shortByItem = array('company.company_name'=> 'asc'); 
	        				break;
	        	case 'industry':
	        				$shortByItem = array('ind.name'=> 'asc');  
	        				break;
	        	case 'salary':
	        				$shortByItem = array('Job.salary_from'=> 'asc'); 
	        				break;
	        	default:
	        			$this->redirect("/jobs");	        		        	
	        }
		}
        $this->set('salaryFrom',isset($salaryFrom)?$salaryFrom:1);      
        $this->set('salaryTo',isset($salaryFrom)?$salaryTo:500);  
		$this->paginate = array(
				            'conditions' => $conditions,
				"limit"=>isset($displayPageNo)?$displayPageNo:6,
				'joins'=>array(
                                    array('table' => 'companies',
	                                       'alias' => 'company',
	                     				   'type' => 'left',
	                     				   'conditions' => array('Job.company_id = company.id',)),
									 array('table' => 'industry',
	                                       'alias' => 'ind',
	                     				   'type' => 'left',
	                     				   'conditions' => array('Job.industry = ind.id',)),
		           			         array('table' => 'specification',
	                     				   'alias' => 'spec',
	                                       'type' => 'left',
	                                       'conditions' => array('Job.specification = spec.id',)),
							         array('table' => 'cities',
	                    				   'alias' => 'city',
	                                       'type' => 'left',
	                                       'conditions' => array('Job.city = city.id',)),
		                             array('table' => 'states',
	                                       'alias' => 'state',
	                                       'type' => 'left',
	                                       'conditions' => array('Job.state = state.id',))
							),
				    'order' => $shortByItem,
				    'recursive'=>0,
				    'fields'=>array('company.company_name,city.city,state.state,ind.name as industry,spec.name as specification,job_type,short_description,Job.created,Job.title,Job.reward,Job.id')
				    );
        $jobs = $this->paginate('Job');
		$this->set('jobs',$jobs);
		$this->set('industries',$this->Utility->getIndustry());
		$this->set('states',$this->Utility->getState());
		$this->set('companies',$this->Utility->getCompany());
	}

     
/****	Applying job	******/     
	function applyJob(){
		$this->layout= "home";	
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			if( ( $this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')== null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null ) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null )){
				$this->redirect("/login");
			}else{
				$this->redirect("/users/jobseekerSignup");
			}
			
			
		}
		$userId = $session->getUserId();
        $this->set('userRole',$this->userRole);

		// Job information
		if(isset($this->params['jobId'])){
			$id = $this->params['jobId'];
			$jobSeekerApplyCount= $this->JobseekerApply->find('count',array('conditions'=>array('user_id'=>$userId,'job_id'=>$id)));
				
			if($jobSeekerApplyCount>0){
				$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');
				$this->redirect('/jobseekers/newJob');
			}
			$job = $this->Job->find('first',	array('limit'=>3,
											 'joins'=>array(   
										            	array('table' => 'companies',
										                      'alias' => 'comp',
										            		  'type' => 'LEFT',
										            		  'conditions' => array('Job.company_id = comp.id',)),	  
											),
										 'conditions'=>array('Job.id'=>$id),
										'fields'=>array('Job.*, comp.company_name,comp.company_url'),));
			if($job['Job']){
				
				// If user doesnt have filled profile //
				$Userinfo = $this->Jobseeker->find('first',array('conditions'=>array('user_id'=>$userId)));
				if($Userinfo['Jobseeker']['contact_name']==""){				
					$this->_getSession()->setBeforeApplyUrl('/jobs/applyJob/'.$id);
					$this->Session->setFlash('Please fill your contact information first.', 'error');		
					$this->redirect('/jobseekers/editProfile');
				}

				// Jobseeker's profile information
		
				$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
				$universities=$this->University->find('list',array('fields'=>'id,name'));
				$this->set('universities',$universities);
				if($jobprofile){
					$jobprofile['JobseekerProfile']['file_id'] = $jobprofile['JobseekerProfile']['id'];		
					$this->set('jobprofile',$jobprofile['JobseekerProfile']);
					$this->set('is_resume', $jobprofile['JobseekerProfile']['resume']);
					$this->set('is_cover_letter', $jobprofile['JobseekerProfile']['cover_letter']);
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
							$this->set('job',$job['Job']);
							$this->set('jobCompany',$job['comp']['company_name']);
							$this->render("apply_job"); 
							return;          
                		}
                		
                		$type_arr = explode(".",$resume['name']);
                		$type = isset($type_arr[1])?$type_arr[1]:'';
               			if($type!= 'pdf' && $type!= 'txt' && $type!= 'doc' && $type!='docx' && $type!='odt' || $resume['size'] >307251){
							$this->Session->setFlash('Please ensure that you are uploading a supported file format of max size 300 Kb', 'error'); 
                			$this->data['JobseekerApply']['resume'] = ""; 
							$this->set('jobprofile',$this->data['JobseekerApply']);  
							$this->set('job',$job['Job']);
							$this->set('jobCompany',$job['comp']['company_name']);
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
							$this->set('job',$job['Job']);
							$this->set('jobCompany',$job['comp']['company_name']);
							$this->render("apply_job"); 
							return;          
               			}
               		
                		$type_arr1 = explode(".",$cover_letter['name']);
                		$type1 = $type_arr1[1];
                		if($type1!= 'pdf' && $type1!= 'txt' && $type1!= 'doc' && $type1!='docx' && $type1!='odt' ||$cover_letter['size']>307251){
							$this->Session->setFlash('Please ensure that you are uploading a supported file format of max size 300 Kb', 'error'); 
                			$this->data['JobseekerApply']['cover_letter'] = ""; 
							$this->set('jobprofile',$this->data['JobseekerApply']);  
							$this->set('job',$job['Job']);
							$this->set('jobCompany',$job['comp']['company_name']);
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
				$this->set('job',$job['Job']);
				$this->set('jobCompany',$job['comp']);
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');				
				$this->redirect('/jobs/');
			}
		}else{
			$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');				
			$this->redirect('/jobs/');
		}		
	}

	function viewResume(){
		$session = $this->_getSession();
		$userId = $session->getUserId();
        		
		$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('jobprofile',$jobprofile['JobseekerProfile']);

		pr($this->params); exit;
		if(isset($this->params['id'])){

			$job_id = $this->params['jobId'];
			$id = $this->params['id'];
			$file_type = $this->params['filetype'];
			$jobprofile = $this->JobseekerProfile->find('first',array('conditions'=>array('id'=>$id)));
			if($jobprofile['JobseekerProfile']){

				if($file_type=='resume'){
					$file = $jobprofile['JobseekerProfile']['resume'];
					$fl = APP."webroot/files/resume/".$file;
				}
				if($file_type=='cover_letter'){
					$file = $jobprofile['JobseekerProfile']['cover_letter'];
					$fl = APP."webroot/files/cover_letter/".$file;
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
				$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');				
				$this->redirect('/jobs/applyJob/'.$job_id); 
			}
		}echo "here"; exit;		
	} 

	function jobDetail(){
		$this->layout= "home";
		$session = $this->_getSession();
		$userId = $session->getUserId();
		if($this->userRole == ADMIN){
			$this->redirect("/login");
			return;
		}
		if(isset($this->params['jobId'])){

			$id = $this->params['jobId'];
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id,'Job.is_active'=>1),
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
												 'fields'=>array('Job.id ,Job.user_id,Job.title,Job.company_id,comp.company_name,city.city,state.state,Job.job_type,
Job.short_description, Job.reward, Job.created, Job.salary_from, Job.salary_to, Job.description, ind.name as industry_name, spec.name as specification_name, comp.company_url'),));

			if($job){
	
				if($this->userRole!=COMPANY){
				    $this->data['JobViews']['job_id'] = $id;
					if(isset($userId)){
					    $jovViewExits=$this->JobViews->find('first',array('conditions'=>array(
    									'JobViews.job_id'=>$id,	
				    					'JobViews.user_id'=>$userId,	
				    					)
						));
						if(empty($jovViewExits)){
							$this->data['JobViews']['user_id'] = $userId;						
							$this->JobViews->save($this->data['JobViews']);
						}
					}else{
						$this->data['JobViews']['user_id'] = 0;
					    $this->JobViews->save($this->data['JobViews']);						
					}
			   
					//$this->JobViews->save($this->data['JobViews']);
			    }
				$this->set('job',$job);
				$this->set('jobId',$job['Job']['id']);
				$this->set('jobTitle',$job['Job']['title']);
			}else{
				$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');				
				$this->redirect('/jobs/');
			}	

             // job role            
            
            $this->set('userRole',$this->userRole);
			$jobapply = $this->JobseekerApply->find('first',array('conditions'=>array('user_id'=>$userId,'job_id'=>$id)));
			if($jobapply){
    			$this->set('jobapply',$jobapply);
			}
            /*** code for networker trac **/
            if($userId){
                if($this->userRole == NETWORKER||$this->userRole == COMPANY){
                	$code=$this->Utility->getCode($id,$userId);
                    $this->set('intermediateCode',$code);
                }
                if(isset($code)&&!empty($code))
                	$jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$job['Job']['id'].'/?intermediateCode='.$code;
                else
	                $jobUrl=Configure::read('httpRootURL').'jobs/jobDetail/'.$job['Job']['id'].'/';
	  
                $this->set('jobUrl',$jobUrl);
            }
            /**** end code ***/			
		}else{
				$this->Session->setFlash('You may be clicked on old link or entered menually.', 'error');				
				$this->redirect('/jobs/');
		}
		if($session->isLoggedIn()){
			$this->render("/jobs/member_job_detail");
		}else{
			$this->render("/jobs/guest_job_detail");
		}       
                       
	}
	
	function searchJob(){
		$conditions = array();
		if(isset($this->data['SearchJob'])||$this->Session->check('SearchJob')){
			if(!isset($this->data['SearchJob'])){
                $this->data['SearchJob'] = $this->Session->read("SearchJob");
            }else{
                $this->Session->write("SearchJob",$this->data['SearchJob']);
            }
			if($this->data['SearchJob']['what']!=""){
				$whats=explode(' ',$this->data['SearchJob']['what']);
				foreach($whats as $what){
					$whatArray[]="Job.title LIKE '%$what%'";
                    $whatArray[]="company.company_name LIKE '%$what%'";
                    $whatArray[]="spec.name LIKE '%$what%'";
                    $whatArray[]="ind.name LIKE '%$what%'";
                    $whatArray[]="city.city LIKE '%$what%'";
                    $whatArray[]="state.state LIKE '%$what%'";
				}
    	        $conditions[] = array('OR'=>$whatArray);
    		}
    	}
    	$conditions[] = array('Job.is_active'=>1);
		$this->paginate = array(
			'conditions' => $conditions,
			'limit'=>5,
			'joins'=>array(
				array(
					'table' => 'companies',
		         	'alias' => 'company',
		            'type' => 'left',
		            'conditions' => array('Job.company_id = company.id',)),
				array(
					'table' => 'industry',
		            'alias' => 'ind',
		            'type' => 'left',
					'conditions' => array('Job.industry = ind.id',)),
				array(
					'table' => 'specification',
	                'alias' => 'spec',
	                'type' => 'left',
	                'conditions' => array('Job.specification = spec.id',)),
				array(
					'table' => 'cities',
	            	'alias' => 'city',
	                'type' => 'left',
	                'conditions' => array('Job.city = city.id',)),
				array(
					'table' => 'states',
	                'alias' => 'state',
	                'type' => 'left',
	                'conditions' => array('Job.state = state.id',))
			),
			'order' => 'Job.created desc',
			'recursive'=>0,
			'fields'=>array('company.company_name,city.city,state.state,ind.name as industry,spec.name as specification,job_type,short_description,Job.created,Job.title,Job.reward,Job.id')
		);
        $jobs = $this->paginate('Job');
		$this->set('jobs',$jobs);
		$this->set('salaryFrom',isset($salaryFrom)?$salaryFrom:1);      
        $this->set('salaryTo',isset($salaryFrom)?$salaryTo:500);
		$this->set('industries',$this->Utility->getIndustry());
		$this->set('states',$this->Utility->getState());
		$this->set('companies',$this->Utility->getCompany());
		$this->render('/jobs/index');
	}
	
	function shareJob(){
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			//$this->Session->setFlash("please Sign up to share jobs.","warning");
			if( ( $this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')== null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null ) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null )){
				$this->redirect("/login");
			}else{
				$this->redirect("/users/networkerSignup");
			}
			
		}else{
			$this->redirect("/jobs/jobDetail/$this->params['jobId']");
		}
	}

}
?>
