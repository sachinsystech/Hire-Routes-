<?php
class JobseekersController extends AppController {
	var $name = 'Jobseekers';
	var $uses = array('JobseekerSettings','Jobseeker','User');
	var $components = array('Email','Session');	
	function add() {
		$this->data['Jobseekers']['user_id'] = $this->Session->read('Auth.User.id');
		//echo "<pre>"; print_r(implode(',',$this->data['Jobseekers']['industry_specification_1']));exit;
		$this->data['Jobseekers']['specification_1'] = implode(',',$this->data['Jobseekers']['industry_specification_1']);
		$this->data['Jobseekers']['specification_2'] = implode(',',$this->data['Jobseekers']['industry_specification_2']);
		$this->JobseekerSettings->save($this->data['Jobseekers']);
		$this->Session->setFlash('Your Setting has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}
	
	function sendNotifyEmail(){
		$notifyId = $this->params['id'];
		//$this->Session->setFlash('Your E-mail  Notification has been saved successfuly.', 'success');				
		$this->redirect('/users/jobseekerSetting');
	}

	function index(){
            $userId = $this->Session->read('Auth.User.id');
          if($userId){
			
	    $jobseekers = $this->Jobseeker->find('all',array('conditions'=>array('user_id'=>$userId)));
				
		$jobseekers_array = array();
		foreach($jobseekers as $jobseeker){
			$jobseekers_array[$jobseeker['Jobseeker']['id']] =  $jobseeker['Jobseeker'];
		}
		$this->set('jobseekers',$jobseekers_array);

        $users = $this->User->find('all',array('conditions'=>array('id'=>$userId)));
		$users_array = array();
		foreach($users as $user){
			$users_array[$user['User']['id']] =  $user['User'];
		}
		$this->set('users',$users_array);
        if($user['User']){
             $this->set('user',$user['User']);
          }


        if($jobseeker['Jobseeker']){
				$this->set('jobseeker',$jobseeker['Jobseeker']);
			}
		}
	}
}
?>
