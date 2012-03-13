<?php
require_once(APP_DIR.'/vendors/facebook/facebook.php');
require_once(APP_DIR.'/vendors/linkedin/linkedin.php');
require_once(APP_DIR.'/vendors/linkedin/OAuth.php');
class CompaniesController extends AppController {

	var $name = 'Companies';
   	var $uses = array('User','Company','Companies','Job','Industry','State','Specification','UserRoles','PaymentInfo','JobseekerApply');
	var $components = array('TrackUser','Utility','RequestHandler');
	var $helpers = array('Form','Paginator','Time');
	

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

	function newJob(){
		
		$displayPageNo = isset($this->params['named']['display'])?$this->params['named']['display']:10;
	    $this->set('displayPageNo',$displayPageNo);

		if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
			    				$shortByItem = 'created'; 
			    				break;	
	        	case 'industry':
	        				$shortByItem = 'industry'; 
	        				break;
			    				break;
			    	case 'salary':
			    				$shortByItem = 'salary_from'; 
			    				break;
			    	default:
			    			$this->redirect("/companies/newJob");	        		        	
			    }
		}else{
			$this->set('shortBy',"date-added");
			$shortByItem = 'created'; 
		}
		$userId = $this->Session->read('Auth.User.id');		
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}

		$conditions = array('Job.user_id'=>$userId,"Job.is_active"=>1);
		$this->paginate = array(
				            'conditions' => $conditions,
				"limit"=>$displayPageNo,
				'joins'=>array(
									array('table' => 'jobseeker_apply',
										'alias' => 'ja',
										'type' => 'LEFT',
										'conditions' => array(
													'Job.id = ja.job_id',
										)
									)
							),
				    'order' => array($shortByItem => 'desc'),
				    'recursive'=>0,
				    'fields'=>array('Job.id ,Job.user_id,Job.title,Job.created,COUNT(ja.id) as submissions'),
				    'group'=>array('Job.id'),
				    );
		$jobs = $this->paginate("Job");
		$this->set('jobs',$jobs);
	}

	function save(){
        $userId =  $this->Session->read('Auth.User.id');
		$company = $this->Companies->find('first',array('conditions'=>array('Companies.user_id'=>$userId)));
		$this->data['Job']['user_id']= $userId;
		$this->data['Job']['company_id']= $company['Companies']['id'];
		$this->data['Job']['company_name']= $company['Companies']['company_name'];
		if($this->Job->save($this->data['Job'])){
            switch($this->params['form']['save']){
                case 'Post and Share Job with Network':
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');
                    $this->redirect('/companies/shareJob/'.$this->Job->id);
                    break;
                case 'Save for Later':
                default:
                    $this->Session->setFlash('Job has been saved successfuly.', 'success');	
                    $this->redirect('/companies/editJob/'.$this->Job->id);
                    break;
        
            }
        }else{
            $this->Session->setFlash('Internal error while save job.', 'error');	
            $this->redirect('/companies/newJob/');
        }		
	}
	
	function editJob(){
		$userId = $this->Session->read('Auth.User.id');	
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
				/****************  genrate code for traking user ****************/
					$str = "11:12";
					$temp = base64_encode($str);
					//echo $temp;
					$str = base64_decode("MTE6MTI6Njk=");
					//echo $str;exit;
					$code="";
					if($str != ""){
						$ids = split(":",$str);
						if($ids!=false && count($ids)>0){
							$ids[] = $userId;
							$str = implode(":",$ids);
							$code = base64_encode($str);
						}
					}else{
						$code = base64_encode($userId);				
					}
					$this->set('code',$code);
				/************************** end *********************************/
		
			}	
			else{
				$this->Session->setFlash('You may be clicked on old link.', 'error');				
				$this->redirect('/companies/newJob');
			}
		}
		if(isset($this->data['Job'])){
			$this->data['Job']['user_id'] = $this->Session->read('Auth.User.id');
			$this->Job->save($this->data['Job']);
			$this->Session->setFlash('Job has been updated successfuly.', 'success');				
			$this->redirect('/companies/newJob');
		}
		if(!isset($userId) || !isset($jobId)){
			$this->Session->setFlash('You may be clicked on old link.', 'error');				
			$this->redirect('/companies/newJob');
		}
	}
	
	function accountProfile() {
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function editProfile() {
		$userId = $this->Session->read('Auth.User.id');
		$roleInfo = $this->getCurrentUserRole();
		if($roleInfo['role_id']!=1){
			$this->redirect("/users/firstTime");
		}
		//echo "<pre>"; print_r($this->data['User']);
		//echo "<pre>"; print_r($this->data['Company']); exit;		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			$this->User->save($this->data['User']);
			$this->Companies->save($this->data['Company']);		
			$this->Session->setFlash('Profile has been updated successfuly.', 'success');	
			$this->redirect('/companies');						
		}
		
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$this->set('company',$user['Companies'][0]);
	}

	function paymentInfo() {
		$userId = $this->TrackUser->getCurrentUserId();		
		$userRole = $this->UserRoles->find('first',array('conditions'=>array('UserRoles.user_id'=>$userId)));
		$roleInfo = $this->TrackUser->getCurrentUserRole($userRole);
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$this->set('user',$user['User']);
		$payment = $this->PaymentInfo->find('first',array('conditions'=>array('user_id'=>$userId)));
		$this->set('payment',$payment['PaymentInfo']);
		if(isset($this->data['PaymentInfo'])){
            
			if( !$this->PaymentInfo->save($this->data['PaymentInfo'],array('validate'=>'only')) ){	
				// echo '<pre>';print_r($this->PaymentInfo); exit;	
				$this->render("payment_info");
				return;				
			}else{
				$this->Session->setFlash('Payment Infomation has been updated successfuly.', 'success');	
				$this->redirect('/companies/paymentInfo');
			}		
		}		
	}



	/** move active job to archive(Disable) **/
	function archiveJob(){
		$userId = $this->Session->read('Auth.User.id');
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),"fileds"=>"id"));
			if($jobs['Job']){
				$jobs['Job']["is_active"] = 0 ;
				$this->Job->save($jobs);
				$this->Session->setFlash('Successfully, Job has been archived.', 'success');	
				$this->redirect("/companies/newJob");
			}
		}
		$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it. ', 'error');	
		$this->redirect("/companies/newJob");
	}	



	/** list of Applicant for given job **/
	function showApplicant(){
		$userId = $this->Session->read('Auth.User.id');
		$jobId = $this->params['id'];
		if($userId && $jobId){
			$jobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobId,'Job.user_id'=>$userId,"Job.is_active"=>1),"fileds"=>"id"));
			if($jobs['Job']){
				$conditions = array('JobseekerApply.job_id'=>$jobs['Job']['id'],"JobseekerApply.is_active"=>0);
				$this->paginate = array(
								    'conditions' => $conditions,
						'joins'=>array(
											array('table' => 'jobseekers',
												'alias' => 'jobseekers',
												'type' => 'LEFT',
												'conditions' => array(
															'JobseekerApply.user_id = jobseekers.user_id ',
												)
											)
									),'limit' => 12, // put display fillter here
							'order' => array('JobseekerApply.id' => 'desc'), // put sort fillter here
							'recursive'=>0,
							'fields'=>array('JobseekerApply.*,jobseekers.contact_name'),
							
							);
				$applicants = $this->paginate("JobseekerApply");
				$this->set('applicants',$applicants);
			}
		}else{
			$this->Session->setFlash('May be you click on old link or you are you are not authorize to do it.', 'error');	
			$this->redirect("/companies/newJob");
		}
	}


	function facebookObject() {
		$facebook = new Facebook(array(
		  'appId'  => FB_API_KEY,
		  'secret' => FB_SECRET_KEY,
          'cookie' => true,
		));
		return $facebook;
	}
	
	/****** Delete Job *******/
	function deleteJob(){
		

	}


    function getFaceBookLoginURL(){ 
        $loginUrl = $this->facebookObject()->getLoginUrl(array(
                                                                'canvas' => 1,
                                                                'fbconnect' => 0,
                                                                'scope' => 'offline_access,publish_stream'
                    ));
        return $loginUrl;
    }

    /***** shareJob *********/
    function shareJob(){
        /*$this->getFaceBookLoginURL();
        $user = $this->facebookObject()->getUser();
        if($user){
            echo $this->facebookObject()->getAccessToken();exit;
        }*/
        
      /*  $token =  array(
                        'access_token' => 'AAAE1rdcxV8YBADnh8x5tmdYatIHJ0yJTug10lLYH8PuzCGDOXk174jTH1DbTcL5qAdZAMCUfYAHCHx0lsUcigfILSDMSMDiGS36eDaQZDZD'

                    );
        $userdata = $this->facebookObject()->api('/me/friends', 'GET', $token);
        //print_r($userdata);
        foreach ($userdata as $key=>$value) {
    echo count($value) . ' Friends';
    echo '<hr />';
    echo '<ul id="friends">';
    foreach ($value as $fkey=>$fvalue) {
        echo '<li><img src="https://graph.facebook.com/' . $fvalue['id'] . '/picture" title="' . $fvalue['name'] . '"/>'.$fvalue['name'].'</li>';
    }
    echo '</ul>';} */
    //$result = $this->facebookObject()->api("/me/feed",'post',array('message'=>'Testing','access_token' =>'AAAE1rdcxV8YBADnh8x5tmdYatIHJ0yJTug10lLYH8PuzCGDOXk174jTH1DbTcL5qAdZAMCUfYAHCHx0lsUcigfILSDMSMDiGS36eDaQZDZD'));
    //print_r($result);exit;
    //}
    }

    function getFaceBookFriendList(){
        $userId = $this->Session->read('Auth.User.id');
        if(!$this->RequestHandler->isAjax()){
            $user = $this->facebookObject()->getUser();
            if($user){
                
                // save users facebook token
                $saveUser = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
                $saveUser['User']['facebook_token'] = $this->facebookObject()->getAccessToken();
                $this->User->save($saveUser);
                $this->set('error',false);
                
            }else{
                //this would be call when user decline permission            
            }
        }else{

            $this->autoRender = false;
            $user = $this->User->find('first',array('fields'=>'facebook_token','conditions'=>array('id'=>$userId,'facebook_token !='=>'NULL')));
            //get token from table other wise send for login.
            if($user){
                try{
                    $token =  array(
                                'access_token' =>$user['User']['facebook_token']

                            );
                    $userdata = $this->facebookObject()->api('/me/friends', 'GET', $token);
                    $users = array();
                    $i =0 ;
                    foreach ($userdata as $key=>$value) {
                        foreach ($value as $fkey=>$fvalue) {
                            $users[$i]['name'] = $fvalue['name'] ;
                            $users[$i]['id'] = $fvalue['id'];
                            $i++;
                        }
                    }
                    return json_encode(array('error'=>0,'data'=>$users));
                }catch(Exception $e){
                    return json_encode(array('error'=>2,'message'=>'Error in facebook connection.Please try after some time.'));
                }
            }else{
                echo json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$this->getFaceBookLoginURL()));
            }   
        }
    }


    function commentAtFacebook(){
        $this->autoRender = false;
        $userIds = $this->params['form']['usersId'];
        $userIds = explode(",", $userIds);
        $message = $this->params['form']['message'];
        $userId = $this->Session->read('Auth.User.id');
        $User = $this->User->find('first',array('conditions'=>array('id'=>$userId)));
        if(!empty($userIds) && $message &&  $User){
            foreach($userIds as $id){
                try{

                    $result = $this->facebookObject()->api("/".$id."/feed",'post',array('message'=>$message,'access_token' =>$User['User']['facebook_token']));
                    
                }catch(Exception $e){
                    return json_encode(array('error'=>1));      
                }

            }
        }
        return json_encode(array('error'=>0));

    }


   function getLinkedinFriendList(){
        $config['base_url']             =   'http://thinkdiff.net/demo/linkedin/auth.php';
        $config['callback_url']         =   'http://thinkdiff.net/demo/linkedin/demo.php';
        $config['linkedin_access']      =   '341yzad2xife';
        $config['linkedin_secret']      =   'jN3uF6HePfMLspcb';
        $userId = $this->Session->read('Auth.User.id');
        //$this->autoRender = false;
        $user = $this->User->find('first',array('fields'=>'linkedin_token','conditions'=>array('id'=>$userId,'linkedin_token !='=>'NULL')));
        if(!$user){
            // user token is exits.
            $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
            $linkedin->access_token ="f109977e-2e80-4602-8eab-a02a41fc035d"; $user['User']['linkedin_token'];
            $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url)");
            $response=simplexml_load_string($xml_response);
            if($response->status == '404') echo "Not found11";
            pr($response->status);
                
        }else{
            echo json_encode(array('error'=>1,'message'=>'User not authenticate from facebook.','URL'=>$this->getFaceBookLoginURL()));
        }   
        
       exit;
    }

}
?>
