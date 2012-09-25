<?php
class NetworkersController extends AppController {
	var $name = 'Networkers';
	var $uses = array(	'GraduateUniversityBreakdown',
						'Networkers',
						'NetworkerContact', 
						'NetworkerCsvcontact', 
						'NetworkerSettings',
						'PaymentHistory',
						'JobseekerApply',
						'University',
						'SharedJob',
						'User',
						'Job',
						'ReceivedJob',
						'JobViews',
						'Invitation',
						'PointLabels',
					);
	var $components = array('Email','Session','TrackUser','Utility');	
	var $helpers = array('Time','Form');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
		if($this->userRole!=NETWORKER){
			$this->redirect("/users/loginSuccess");
		}
		$this->Auth->allow("getGmailContacts");
		$this->Auth->allow("jobCounts");
		$this->Auth->allow("getNetworkerSettings");
		$this->Auth->allow("editContact");
		$this->Auth->allow("invitations");
		$jobCounts=$this->jobCounts();
		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		$this->set('ArchiveJobs',$jobCounts['archivejobs']);
		$this->set('NewJobs',$jobCounts['newJobs']);
	}
	
	/* Delete Subscription */
	function delete(){
		$id = $this->params['id'];
		$this->NetworkerSettings->delete($id);
		$this->Session->setFlash('Your Subscription has been deleted successfuly.', 'success');				
		$this->redirect('/networkers/setting');
	}
		
	/* 	Networker's Account-Profile page*/
	function index(){
		$this->layout = "home";
		$userId = $this->_getSession()->getUserId();		
        if($userId){
        	/* User Info*/			
			$user = $this->UserList->find('first', array('conditions'=>array('UserList.id'=>$userId),
														'recursive'=>"-1",
														'joins'=>array(
														array(
															'table'=>'networkers',
															'alias'=>'Networkers',
															'type'=>'left',
															'conditions'=>'UserList.id = Networkers.user_id',
														),
														array(
															'table'=>'universities',
															'type'=>'left',
															'alias'=>'Universities',
															'conditions'=>'Universities.id=Networkers.university',
														),
														array(
															'table'=>'graduate_degrees',
															'type'=>'left',
															'alias'=>'GraduateDegrees',
															'conditions'=>'GraduateDegrees.id=Networkers.graduate_degree_id',
														),
														array(
															'table'=>'graduate_university_breakdown',
															'type'=>'left',
															'alias'=>'GUB',
															'conditions'=>array(
																		'GUB.id=Networkers.graduate_university_id',
																		'GUB.degree_type=Networkers.graduate_degree_id')
),
														
														),'fields'=>array('Networkers.*,GUB.id,GUB.graduate_college,Universities.id,Universities.name,UserList.*,GraduateDegrees.*'),
														));						

			$networkers['university'] = $user['Universities']['name'];
			if(isset($user['GUB']['graduate_college'])){
				$this->set('graduateUniversity', $user['GUB']['graduate_college']);
			}else{
				$this->set('graduateUniversity', "");
			}
			if(!isset($user['Networkers']['contact_name']) || empty($user['Networkers']['contact_name'])){
				$this->redirect("/Networkers/editProfile");						
			}
			$this->set('user',$user);
		}
		else{		
			$this->Session->setFlash('Internal error has been occured...', 'error');	
			$this->redirect('/');								
		}

	}

	/* save email notifications setting*/
	
	function sendNotifyEmail(){
		$userId = $this->_getSession()->getUserId();
		if(isset($this->data['Networkers'])){
			if($this->Networkers->updateAll($this->data['Networkers'],array('user_id'=>$userId))){
				$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');				
			}
		}else{
			$this->Session->setFlash('Internal error has been occured...', 'error');
		}
		$this->redirect('/networkers/setting');		
	}
	
	/* 	Setting and Subscriptoin page*/
	function setting() {
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();
		
		if(isset($this->data['NetworkerSettings'])){
			$this->data['NetworkerSettings']['user_id'] = $userId;
			$this->NetworkerSettings->set($this->data['NetworkerSettings']);
			if($this->NetworkerSettings->validates()){
				if($this->NetworkerSettings->save($this->data['NetworkerSettings'])){
					$this->Session->setFlash('Your Subscription has been added successfuly.', 'success');
				}else{
					$this->Session->setFlash('Internal Error! try again.', 'error');
				}
			}
		}
		$subscribeData['subscribe_email'] = $this->Networkers->field('subscribe_email',array('user_id'=>$userId));
		if(isset($subscribeData['subscribe_email']) && $subscribeData['subscribe_email'] == null){
			$subscribeData['subscribe_email']=3;
			$this->Networkers->updateAll($subscribeData,array('user_id'=>$userId));
		}
		$networkerData = $this->NetworkerSettings->find('all',array('conditions'=>array('NetworkerSettings.user_id'=>$userId),
												  'joins'=>array(array('table' => 'industry',
										                               'alias' => 'ind',
										             				   'type' => 'LEFT',
										             				   'conditions' => array('NetworkerSettings.industry = ind.id',)),
											   			         array('table' => 'specification',
										             				   'alias' => 'spec',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.specification = spec.id',)),
										                         array('table' => 'states',
										             				   'alias' => 'state',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.state = state.id',)),       
																 array('table' => 'cities',
										             				   'alias' => 'city',
										                               'type' => 'LEFT',
										                               'conditions' => array('NetworkerSettings.city = city.id',))
																 ),
															 'fields'=>array(
															 			'NetworkerSettings.id,
															 			NetworkerSettings.user_id,
															 			ind.name as name,
															 			spec.name as name,
															 			state.state as name,
															 			city.city as name'
															 		),
															 'order'=>array('NetworkerSettings.industry'=>'asc')		
														 		)
												 			);

		$SubscriptionData = $this->Networkers->find('first',array('conditions'=>array('Networkers.user_id'=>$userId)));	
		$this->set('NetworkerData',$networkerData);
		$this->set('SubscriptionData',$SubscriptionData['Networkers']);
		
		$this->set('industries',$this->Utility->getIndustry());
		//$this->set('specifications',$this->Utility->getSpecification());
		$this->set('states',$this->Utility->getState());
		
		if(isset($networker) && $networker['Networkers']){
			$this->set('networker',$networker['Networkers']);
		}
	}
   
	/* 	Edit Networker's Account-Profile*/   
	function editProfile() {
		$this->layout= "home";
		$session = $this->_getSession();
		$userId = $session->getUserId();
		
		if(isset($this->data['User'])){
			$this->data['User']['group_id'] = 0;
			if($this->User->save($this->data['User'])){
				if($this->Networkers->save($this->data['Networkers'])){
					$session->start();
					$this->Session->setFlash('Profile has been updated successfuly.', 'success');
					$this->redirect('/networkers');
				}	
			}
		}
		
		$user = $this->UserList->find('first', array('conditions'=>array('UserList.id'=>$userId),
														'recursive'=>"-1",
														'joins'=>array(
														array(
															'table'=>'networkers',
															'alias'=>'Networkers',
															'type'=>'left',
															'conditions'=>'UserList.id = Networkers.user_id',
														),
														array(
															'table'=>'universities',
															'type'=>'left',
															'alias'=>'Universities',
															'conditions'=>'Universities.id=Networkers.university',
														),
														array(
															'table'=>'graduate_degrees',
															'type'=>'left',
															'alias'=>'GraduateDegrees',
															'conditions'=>'GraduateDegrees.id=Networkers.graduate_degree_id',
														),
														array(
															'table'=>'graduate_university_breakdown',
															'type'=>'left',
															'alias'=>'GUB',
															'conditions'=>array(
																		'GUB.id=Networkers.graduate_university_id',
																		'GUB.degree_type=Networkers.graduate_degree_id')
),
														
														),'fields'=>array('Networkers.*,GUB.id,GUB.graduate_college,Universities.id,Universities.name,UserList.*,GraduateDegrees.*'),
														));	
		$graduateDegrees =$this->Utility->getGraduateDegrees();
		if(isset($graduateUniversity['GraduateUniversityBreakdown'])){
			$this->set('graduateUniversity',$graduateUniversity['GraduateUniversityBreakdown']);
		}
		$this->set('user',$user);
		$this->set('graduateDegrees',$graduateDegrees);
        if(isset($user['Networkers'])){
        	$this->set('networker',$user['Networkers']);
        }
	}
	
	function getNetworkerContacts(){
	
		$userId = $this->_getSession()->getUserId();
		$startWith = isset($this->params['named']['alpha'])?$this->params['named']['alpha']:"";
		$paginateCondition = array(
									'AND' => array(
												array('NetworkerContact.user_id'=>$userId),
												array('NetworkerContact.contact_email LIKE' => "$startWith%")
											)
								);
		
		$this->paginate = array('conditions'=>$paginateCondition,
                                'limit' => 6,
                                'order' => array("NetworkerContact.id" => 'asc',));             
        $contacts = $this->paginate('NetworkerContact');

        $alphabets = array();
        foreach(range('A','Z') AS $alphabet){
        	$contacts_count = $this->NetworkerContact->find('count',array('conditions'=>array('NetworkerContact.user_id'=>$userId,
        																					  'NetworkerContact.contact_email LIKE' => "$alphabet%"
        																					  )
        																  )
        													);
            $alphabets[$alphabet] = $contacts_count; 
        }
		
        $this->set('alphabets',$alphabets);
        $this->set('contacts',$contacts);
        $this->set('contact',null);
        $this->set('startWith',$startWith);

	}
	
	/*	Add contact by single entry	*/
	function addContacts() {
		$this->layout= "home";
			
		if(isset($this->params['url']['error'])){
    		$this->Session->setFlash('You have declined the request!', 'warning');
    		$this->redirect('/networkers/addContacts');
    	}
    	
		if(isset($this->params['url']['code'])){

			$GmailContacts = $this->getGmailContacts($this->params['url']['code']);
			$GmailContactsArray  = array();
			
			foreach($GmailContacts as $GmailContact){
				$email = $GmailContact->attributes()->address;
				$email = (string)$email;
				if(isset($email)){
					$GmailContactsArray[$email] = $email;
				}
			}
			$this->set('GmailContacts',$GmailContactsArray);
		}
		
		if(isset($this->data['gmailContact']['addGmailContact']) && empty($this->data['gmailContact']['addGmailContact'])){
			$this->Session->setFlash('Please select contects.', 'error');	
			$this->redirect('/networkers/addContacts');	
		}	
		if(isset($this->data['gmailContact']['addGmailContact']) && !empty($this->data['gmailContact']['addGmailContact'])){
			$userId = $this->_getSession()->getUserId();
			$this->data['gmailContact'] = $this->Utility->stripTags($this->data['gmailContact']['addGmailContact']);
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			$matchEmail = $this->NetworkerContact->find('all',array('conditions'=>array(
																	'NetworkerContact.user_id'=>$userId,
																	"or"=>array('NetworkerContact.contact_email'=>$this->data['gmailContact']),
														)
														));
			$flag=true;
			$duplicate_count=0;
			$added_count=0;
			$dataArray= array();
			foreach($this->data['gmailContact'] as  $key=>$value){
				foreach ($matchEmail as $item) {
					if($item['NetworkerContact']['contact_email'] == $value){
						$flag=false;
						$duplicate_emails[] = $value;	
						$duplicate_count++;
					}
				}
				if($flag){
					$dataArray[$key]['contact_email'] =$value;
					$dataArray[$key]['user_id'] =$userId;
					$dataArray[$key]['networker_id'] =$user['Networkers'][0]['id'];
					$added_count++;
				}
				$flag=true;
			}
			$added_count_msg = "0 contacts added";
			$duplicate_count_msg = "0 duplicate contacts found";
			if($added_count>0){
				$added_count_msg = " $added_count contacts added.";	
			}
			if($duplicate_count>0){
				$duplicate_count_msg = "$duplicate_count duplicate contacts found.";
			}
			if(!empty($dataArray) && $this->NetworkerContact->saveAll($dataArray)){
				$this->Session->setFlash("Your contacts has been added successfully ".$added_count_msg." ".$duplicate_count_msg, 'success');	
			}else if($duplicate_count == count($this->data['gmailContact'])){
				$this->Session->setFlash("Your contacts has been added successfully ".$added_count_msg." ".$duplicate_count_msg, 'success');	
			}else{
				$this->Session->setFlash("you may be click on old link and enter manually.", 'error');	
			}
			$this->redirect('/networkers/addContacts');			
		}
		
		if(isset($this->data['Contact']['CSVFILE']['tmp_name']) && $this->data['Contact']['CSVFILE']['tmp_name']!= null ){
			$this->importCsv($this->data['Contact']['CSVFILE']['tmp_name']);
			if(isset($this->data['Contact'])){
				if($this->data['Contact']['contact_name']==="Enter Name" && $this->data['Contact']['contact_email']=='Enter E-mail'){
					$this->getNetworkerContacts();
					return;
				}
			}
		}
		
		if(isset($this->data['Contact'])){
			$userId = $this->_getSession()->getUserId();
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			$this->data['Contact']['user_id'] = $userId;
			$this->data['Contact']['networker_id'] = $user['Networkers'][0]['id'];
			if($this->data['Contact']['contact_name']==="Enter Name"){
				unset($this->data['Contact']['contact_name']);// = null;			
			}
			if($this->data['Contact']['contact_email']=='Enter E-mail'){
				$this->data['Contact']['contact_email'] = "";			
			}
			if ($this->NetworkerContact->create($this->data['Contact']) && $this->NetworkerContact->validates()) {
				
				$matchEmail = $this->NetworkerContact->find('first',array('conditions'=>array(
																				'NetworkerContact.user_id'=>$userId,
																				'NetworkerContact.contact_email'=>$this->data['Contact']['contact_email']
																				)
													));
				if(isset($matchEmail['NetworkerContact'])){
					$this->NetworkerContact->validationErrors['contact_email'] = "You have already added contact for this email.";
					$this->set('validationErrors',$this->NetworkerContact->validationErrors);
					$this->set('NetworkerContact',$this->NetworkerContact->data['NetworkerContact']);
					$this->getNetworkerContacts();
					return;
				}									
		        if($this->NetworkerContact->save($this->data['Contact'])){
		        	if(isset($this->data['Contact']['CSVFILE']['tmp_name'])){
						$this->Session->setFlash('Csv and Contact has been added successfully.', 'success');
		        	}else{
			        	$this->Session->setFlash('Contact has been added successfully.', 'success');	
		        	}
					
				}	
			}
			$this->set('validationErrors',$this->NetworkerContact->validationErrors);
			$this->set('NetworkerContact',$this->NetworkerContact->data['NetworkerContact']);
		}
		
		$this->getNetworkerContacts();
	}
	
	private function getGmailContacts($authcode){
		$clientid='79643144563-rck00gk919jbv7enntdj5edin5tdjjbm.apps.googleusercontent.com';
		$clientsecret='djH0P5Zu4CO8YHCgH7KeANsF';
		$redirecturi='http://www.hireroutes.com/networkers/addContacts';
		$fields=array(
			'code'=>  urlencode($authcode),
			'client_id'=>  urlencode($clientid),
			'client_secret'=>  urlencode($clientsecret),
			'redirect_uri'=>  urlencode($redirecturi),
			'grant_type'=>  urlencode('authorization_code')
		);
		//url-ify the data for the POST
		$fields_string='';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string=rtrim($fields_string,'&');
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
		curl_setopt($ch,CURLOPT_POST,5);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		// Set so curl_exec returns the result instead of outputting it.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//to trust any ssl certificates
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		//extracting access_token from response string
		$response=  json_decode($result);
		$accesstoken= $response->access_token;
		if(!isset($accesstoken)){
			$this->Session->setFlash('Token expired from Gmail, please try again!', 'warning');
    		$this->redirect('/networkers/addContacts');
		}
		//passing accesstoken to obtain contact details
		$xmlresponse=  file_get_contents('https://www.google.com/m8/feeds/contacts/default/full?max-results=1000&oauth_token='.$accesstoken);
		//reading xml using SimpleXML
		$xml=  new SimpleXMLElement($xmlresponse);
		$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
		$result = $xml->xpath('//gd:email');
		return $result;
	}

	/*	Edit single contact	*/
	function editContact() {
		if(isset($this->data['editContact'])){
			$userId = $this->_getSession()->getUserId();
			$contactId = $this->data['editContact']['id'];
			$contactEmail = $this->NetworkerContact->find('list', array(
																	 'fields' => array('NetworkerContact.id', 'NetworkerContact.contact_email'),
																	 'conditions' => array('NetworkerContact.id' => $contactId)
																	 ));
			
			$matchEmail = $this->NetworkerContact->find('first',array('conditions'=>
																  array(
																	"NOT"=>array('NetworkerContact.contact_email'=>$contactEmail),
																	"AND"=>array(
																					'NetworkerContact.user_id'=>$userId,
																					'NetworkerContact.contact_email'=>$this->data['editContact']['contact_email'],
																				)									
																	))
													);
			if(isset($matchEmail['NetworkerContact'])){
				$this->Session->setFlash("You have already added contact for the email(<i>".$this->data['editContact']['contact_email']."</i>)",'error');
				$this->redirect('/networkers/editPersonalContact/'.$contactId);
				return;
			}									
		    if($this->NetworkerContact->save($this->data['editContact'])){
				$this->Session->setFlash('Contact has been updated successfully.', 'success');	
			}
			$this->redirect('/networkers/addContacts');
		}else{
			$this->Session->setFlash('Please fill correct information for update emails.', 'error');	
			$this->redirect('/networkers/addContacts');
		}
	}

	/*	displaying all personal contacts	*/
	function personal() {
		$this->layout = "home";
		$userId = $this->_getSession()->getUserId();
		$startWith = isset($this->params['named']['alpha'])?$this->params['named']['alpha']:"";
		$parent_id = null;
		$userId = $this->_getSession()->getUserId();
		$networkerData = $this->getRecursiveData($userId);
		$networkerDataCount = $this->getLevelInformation($userId);
		$networkerDegree = $this->getUserDegree($userId);
		$this->set('networkerData',$networkerData);
		$this->set('networkerDegree',$networkerDegree);
		$this->set('networkerDataCount',$networkerDataCount);
	}
	
	function getUserDegree($userId){
		static $count = 0;
		$cond=array('User.id'=>$userId);
		$joins=array(
					array(
						'table'=>'networkers',
						'alias'=>'Networkers',
						'fields'=>'id',
						'type'=>'inner',
						'conditions'=>'User.id = Networkers.user_id'
					)
				);
		$userId = $this->User->find(
		'list',array('fields'=>'User.parent_user_id', 'joins'=>$joins, 'conditions'=>$cond));
	
		if($userId == null && count($userId)== null){
			return $count;
		}
		else{
			$count = $count+1;
		}
		return ($this->getUserDegree($userId));
	} 
	
	private function getLevelInformation($userId=NULL){
		$cond=array('User.parent_user_id'=>$userId);
		$joins=array(
					array(
						'table'=>'networkers',
						'alias'=>'Networkers',
						'fields'=>'id',
						'type'=>'inner',
						'conditions'=>'User.id = Networkers.user_id'
						)
					);
		$Users = $this->User->find(
			'list',array('fields'=>'User.id', 'joins'=>$joins, 'conditions'=>$cond));
		if(count($Users)== 0){
			return null;
		}
  	    return array_merge(array(count($Users)),(array)$this->getlevelInformation($Users));
	}
	
	/*	show personal contact to Edit..	*/
	function editPersonalContact(){
		$userId = $this->_getSession()->getUserId();
		if(isset($this->params['id'])){
			$contactId =$this->params['id'];
			$contact = $this->NetworkerContact->find('first',array('conditions'=>array('NetworkerContact.id'=>$contactId,
																			'NetworkerContact.user_id'=>$userId,
																			)
													)
										);
			if(!isset($contact['NetworkerContact'])){
				$this->Session->setFlash('You clicked on old link or entered manually.', 'error');	
				$this->redirect('/networkers/personal');
			}							
			$this->set('editContact',$contact['NetworkerContact']);
		}       
	}

	/* to show network statistics*/
	function networkerData(){

		//return $networkerData;
	}
	
	function getRecursiveData($userId){	
		$dataArray = array();
		do{
			$userId   = $this->User->find('list',array('fields'=>'id',
													'recursive'=>-1,
													'joins'=>array(
														array(
															'table'=>'networkers',
															'alias'=>'Networker',
															'type'=>'inner',
															'fields'=>'Networker.contact_name, Networker.user_id',
															'conditions'=>'Networker.user_id = User.id',
														),

												),					
										'conditions'=>array('User.parent_user_id'=>$userId)));
			if(count($userId)== 0 ){
				break;
			}
			$dataArray[] = $this->getNetworkersData($userId);
		}while(count($userId)!= 0);
		return $dataArray;
		//return (array($Users, (array)$this->getRecursiveData($Users)));
  	    //return array_merge(array(count($Users)),(array)$this->getRecursiveData($Users));
	}

	function getNetworkersData($userId){
	
		$dataArray =  $this->User->find('all',array('fields'=>'id,parent_user_id, account_email,Networker.*',
													'recursive'=>-1,
													'recursive'=>-1,
													'joins'=>array(
														array(
															'table'=>'networkers',
															'alias'=>'Networker',
															'type'=>'left',
															'fields'=>'Networker.contact_name, Networker.user_id',
															'conditions'=>'Networker.user_id = User.id',
														),

													),
													'conditions'=>array('User.id'=>$userId)));
		if(isset($dataArray)){
			foreach($dataArray as $key => $value){
				if(isset($value['User']['id']))
 					//$dataArray[$key]['degree'] = $this->
 					$levelInfo = $this->getLevelInformation($value['User']['id']);
 					//pr($levelInfo);
 					//$dataArray[$key]['levelInfo'] =$levelInfo;
 					$dataArray[$key]['networkers'] = isset($levelInfo)?array_sum($levelInfo):0;
 					//$dataArray[$key]['degree'] = count($levelInfo);	
				    $dataArray[$key]['reward'] = $this->getNetworkerReward($value['User']['id']);
			}
		}
		return $dataArray;
	}
	
	function getNetworkerReward($userId){
	
		$reward = $this->User->query("select sum(reward) as reward from (

                           select 
                               payment_history.id,(networker_reward_percent*amount/(100*count(payment_history.id))) as reward
                           from 
                               payment_history 
                           join 
                               rewards_status on payment_history.id = payment_history_id  
                           join 
                               networkers on networkers.user_id = rewards_status.user_id  
                           group by 
                               payment_history.id 
                       ) 
       as new_table join rewards_status on new_table.id = payment_history_id  
where user_id =".$userId."");
			
			if(empty($reward[0][0]['reward'])){
				return 0;
			}else{
				return $reward[0][0]['reward'];
			}
	
	
	}	
	
	/*	Adding contacts by Importing CSV	*/
	function importCsv($fileName) {
		$userId = $this->_getSession()->getUserId();
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		$file = fopen($fileName,'r');
		$values = array();
		$contacts = array();
		try{
			while(! feof($file))
		  	{
				$csvArray = fgetcsv($file);
				$csvExplode = explode(";",$csvArray[0]);
				$fname = isset($csvExplode[0])?$csvExplode[0]:"";
				$mname = isset($csvExplode[1])?$csvExplode[1]:"";
				$lname = isset($csvExplode[2])?$csvExplode[2]:"";
				$email = isset($csvExplode[3])?$csvExplode[3]:"";
				$fname = trim($fname, "\"");
				$mname = trim($mname, "\"");
				$lname = trim($lname, "\"");
				$email = trim($email, "\"");
				$values[] = array($fname,$mname,$lname,$email);//$csvArray[0];
		  	}
			if(isset($values[1][3])){
				
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $values[1][3])){
					$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
					$this->redirect('/networkers/addContacts');
				}
			
				foreach($values as $key=>$val){
					if(isset($val[3]) && $val[3] != null){
						$contacts[$key]['user_id'] = $userId;
						$contacts[$key]['networker_id'] = $user['Networkers'][0]['id'];
						$contacts[$key]['contact_name'] = ucfirst($val[0]).ucfirst($val[1]).ucfirst($val[2]);
						$contacts[$key]['contact_email'] = $val[3];
					}	
				}	
				unset($contacts[0]);
				$duplicate_emails = array();
				$added_count = 0;
				$duplicate_count = 0;
				foreach($contacts as $contact){
					if ($this->NetworkerCsvcontact->create($contact)) {
						$matchEmail = $this->NetworkerCsvcontact->find('first',array('conditions'=>array(
																				'NetworkerCsvcontact.user_id'=>$userId,
																				'NetworkerCsvcontact.contact_email'=>$contact['contact_email']
																				)
													));
						if(isset($matchEmail['NetworkerCsvcontact'])){
							$duplicate_emails[] = $this->NetworkerCsvcontact->data['NetworkerCsvcontact']['contact_email'];	
							++$duplicate_count;
							continue;
						}
						if(!$this->NetworkerCsvcontact->save($contact)){
							$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
							$this->redirect('/networkers/addContacts');
							return;
						}
						++$added_count;
					}
				}
			}
			else{
				$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
				$this->redirect('/networkers/addContacts');
			}
		}catch(Exception $e){
			$this->Session->setFlash('Your CSV is not in proper format.', 'error');	
			$this->redirect('/networkers/addContacts');
		}
		$added_count_msg = "";
		$duplicate_count_msg = "";
		if(count($added_count)>0){
			$added_count_msg = "You CSV have been imported successfully, $added_count contacts added.";	
		}
		if(count($duplicate_count)>0){
			$duplicate_count_msg = "$duplicate_count duplicate contacts found.";
		}
		$this->Session->setFlash($added_count_msg." ".$duplicate_count_msg, 'success');	
		//$this->redirect('/networkers/addContacts');
		return;
	}
	
	/*	delete multiple contacts.....*/
	function deleteContacts() {
		$ids = array();
		if(isset($this->params['id'])){
			$ids[] = $this->params['id'];
		}
		foreach($this->data['deleteContacts'] as $key=>$value){
			if($value){
				$ids[] = $value;
			}	
		}
		if($this->NetworkerContact->delete($ids)){
			$this->Session->setFlash('contact(s) have been deleted successfuly.', 'success');				
		}	
		$this->redirect('/networkers/addContacts');
	}
		  
	function archiveJob(){
		$this->layout = "home";
		$userId = $this->_getSession()->getUserId();		
		    
    	$networker_settings = $this->getNetworkerSettings($userId);
		
        if(count($networker_settings)>0){
			for($n=0;$n<count($networker_settings);$n++){
				$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
				$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
				$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
				$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

				$tempCond = array();
				if($industry[$n]>1){
					$tempCond[] = array('Job.industry' => $industry[$n]);
				
				}
				if($specification[$n])
						$tempCond[] = array('Job.specification' => $specification[$n]);
				if($city[$n])
					$tempCond[] = array('Job.city ' => $city[$n]);
		        if($state[$n])
		        	$tempCond[] = array('Job.state' => $state[$n]);
				  
			
				if(!$tempCond){
					$tempCond = array(1);
				}
				$job_cond[$n] =  array('AND' =>$tempCond);
			
			}
		
			$shortByItem = array('Job.created'=> 'desc');
		    
		    if(isset($this->params['named']['display'])){
			    $displayPageNo = $this->params['named']['display'];
			    $this->set('displayPageNo',$displayPageNo);
			}
			if(isset($this->params['named']['shortby'])){
			    $shortBy = $this->params['named']['shortby'];
			    $this->set('shortBy',$shortBy);
			    switch($shortBy){
			    	case 'date-added':
	        				$shortByItem = array('Job.created'=> 'desc'); 
	        				break;	
			    	case 'company-name':
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
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

			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 0))); 

			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:6,
									'joins'=>array(array('table' => 'industry',
												         'alias' => 'ind',
												         'type' => 'LEFT',
												         'conditions' => array('Job.industry = ind.id',)
											        ),
												   array('table' => 'specification',
												         'alias' => 'spec',
												         'type' => 'LEFT',
												         'conditions' => array('Job.specification = spec.id',)
											        ),
												   array('table' => 'cities',
												         'alias' => 'city',
												         'type' => 'LEFT',
												         'conditions' => array('Job.city = city.id',)
											        ),
                                                    array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('Job.company_id = comp.id',)),
												   array('table' => 'states',
												         'alias' => 'state',
												         'type' => 'LEFT',
												         'conditions' => array('Job.state = state.id',)
											        )),
		                            'order' => $shortByItem,
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');
		    $this->set('jobs',$jobs);
		}
		$jobCounts=$this->jobCounts();
		$this->set('SharedJobs',$jobCounts['sharedJobs']);
		$this->set('ArchiveJobs',$jobCounts['archivejobs']);
		$this->set('NewJobs',$jobCounts['newJobs']);
	}

	function newJob(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();	
		
		$receivedJobs=$this->ReceivedJob->find('list',array('conditions'=>array('user_id'=>$userId),'fields'=>'job_id'));
		        
    	$networker_settings = $this->getNetworkerSettings($userId);
    	
    	$shared_job = $this->SharedJob->find('all',array('conditions'=>array('user_id'=>$userId),
															   'fields'=>'SharedJob.job_id',
															   'group'=>array('SharedJob.job_id')
															   )
															);
		$jobIds = array();
		for($a=0;$a<count($shared_job);$a++){
			$jobIds[$a] = $shared_job[$a]['SharedJob']['job_id'];
		}
		
        if(count($networker_settings)>0||count($receivedJobs)>0){
        	$job_cond=null;
        	if(count($networker_settings)>0){
				for($n=0;$n<count($networker_settings);$n++){
					$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
					$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
					$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
					$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

					$tempCond = array();
					if($industry[$n]>1){
						$tempCond[] = array('Job.industry' => $industry[$n]);
				
					}
					if($specification[$n])
							$tempCond[] = array('Job.specification' => $specification[$n]);
					if($city[$n])
						$tempCond[] = array('Job.city ' => $city[$n]);
				    if($state[$n])
				    	$tempCond[] = array('Job.state' => $state[$n]);
			
					if(!$tempCond){
						$tempCond = array(1);
					}
					$job_cond[$n] =  array('AND' =>$tempCond);
			
				}
			}
			
			$job_cond[]=array('Job.id'=>$receivedJobs);
			
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
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
			    				break;
			    	case 'industry':
			    				$shortByItem = array('ind.name'=> 'asc');  
			    				break;
			    	case 'salary':
			    				$shortByItem = array('Job.salary_from'=> 'asc'); 
			    				break;
			    	default:
			    				$this->redirect('/networkers/newJob');        		        	
			    }
			}
			$cond = array('OR' => $job_cond,
						   'AND' => array(array('is_active' => 1),'NOT'=>array(array('Job.id'=> $jobIds))),
						 ); 

			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:6,
									'joins'=>array(array('table' => 'industry',
												         'alias' => 'ind',
												         'type' => 'LEFT',
												         'conditions' => array('Job.industry = ind.id',)
											        ),
												   array('table' => 'specification',
												         'alias' => 'spec',
												         'type' => 'LEFT',
												         'conditions' => array('Job.specification = spec.id',)
											        ),
												   array('table' => 'cities',
												         'alias' => 'city',
												         'type' => 'LEFT',
												         'conditions' => array('Job.city = city.id',)
											        ),
                                                    array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('Job.company_id = comp.id',)),
												   array('table' => 'states',
												         'alias' => 'state',
												         'type' => 'LEFT',
												         'conditions' => array('Job.state = state.id',)
											        )),
		                            'order' => $shortByItem,
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('Job');
			$this->set('jobs',$jobs);	
		}
		
	}

	function jobData(){
		$this->layout ="home";
		$userId = $this->_getSession()->getUserId();		
							 
		$data = $this->User->query("select sum(reward) as reward from (

                           select 
                               payment_history.id,(networker_reward_percent*amount/(100*count(payment_history.id))) as reward
                           from 
                               payment_history 
                           join 
                               rewards_status on payment_history.id = payment_history_id  
                           join 
                               networkers on networkers.user_id = rewards_status.user_id  
                           group by 
                               payment_history.id 
                       ) 
       as new_table join rewards_status on new_table.id = payment_history_id  
where user_id =".$userId."");
							 
		if($data[0][0]['reward']!=""){
			$total_reward = $data[0][0]['reward'];
		}else{
			$total_reward = 0;
		}
		$this->set('TotalReward',$total_reward);
		$jobCounts=$this->jobCounts();

	}
	
	/**
	 *	shared Job
	 */
	 function sharedJob(){
	 	$this->layout ="home";
		$userId = $this->_getSession()->getUserId();	
		        	
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
			    				$shortByItem = array('comp.company_name'=> 'asc'); 
			    				break;
			    	case 'industry':
			    				$shortByItem = array('ind.name'=> 'asc');  
			    				break;
			    	case 'salary':
			    				$shortByItem = array('Job.salary_from'=> 'asc'); 
			    				break;
			    	default:
			    				$this->redirect('/networkers/sharedJob');        		        	
			    }
			}
			$jobCounts = $this->jobCounts();
			$cond = array('SharedJob.user_id'=>$userId); 
			$this->paginate = array('conditions'=>$cond,
		                            'limit' => isset($displayPageNo)?$displayPageNo:6,
									'joins'=>array(array('table' => 'jobs',
												         'alias' => 'Job',
												         'type' => 'LEFT',
												         'conditions' => array('Job.id = SharedJob.job_id')
											        ),
											        array('table' => 'industry',
												         'alias' => 'ind',
												         'type' => 'LEFT',
												         'conditions' => array('Job.industry = ind.id',)
											        ),
												   array('table' => 'specification',
												         'alias' => 'spec',
												         'type' => 'LEFT',
												         'conditions' => array('Job.specification = spec.id',)
											        ),
												   array('table' => 'cities',
												         'alias' => 'city',
												         'type' => 'LEFT',
												         'conditions' => array('Job.city = city.id',)
											        ),
                                                    array('table' => 'companies',
						             				   'alias' => 'comp',
						                               'type' => 'LEFT',
    				                               'conditions' => array('Job.company_id = comp.id',)),
												   array('table' => 'states',
												         'alias' => 'state',
												         'type' => 'LEFT',
												         'conditions' => array('Job.state = state.id',)
											        )),
		                            'order' => $shortByItem,
		                            'group'=>array('SharedJob.job_id'),
		                            'myCount'=>$jobCounts['sharedJobs'],
									'fields'=>array('Job.id ,Job.user_id,Job.title,comp.company_name,city.city,state.state,Job.job_type,Job.short_description, Job.reward, Job.created, Job.is_active, ind.name as industry_name, spec.name as specification_name'),);
		    
		    $jobs = $this->paginate('SharedJob');	
			$this->set('jobs',$jobs);			
	}

	/*
	 * To find job counts
	 *
	 */
	public function jobCounts(){
		$userId = $this->_getSession()->getUserId();		
		
		$receivedJobs=$this->ReceivedJob->find('list',array('conditions'=>array('user_id'=>$userId),'fields'=>'job_id'));
		        
    	$networker_settings = $this->getNetworkerSettings($userId);
    	if(!(count($networker_settings)>0))
    		$this->Session->setFlash('Please fill your settings in order to get jobs matching your profile.', 'warning');
    	
    	$shared_job = $this->SharedJob->find('all',array('conditions'=>array('user_id'=>$userId),
															   'fields'=>'SharedJob.job_id',
															   'group'=>'SharedJob.job_id'
															   )
															);
		$jobIds = array();
		for($a=0;$a<count($shared_job);$a++){
			$jobIds[$a] = $shared_job[$a]['SharedJob']['job_id'];
		}
		
        if(count($networker_settings)>0||count($receivedJobs)>0){
        	$job_cond=null;
        	if(count($networker_settings)>0){
				for($n=0;$n<count($networker_settings);$n++){
					$industry[$n]		= $networker_settings[$n]['NetworkerSettings']['industry'];
					$specification[$n]  = $networker_settings[$n]['NetworkerSettings']['specification'];
					$city[$n]			= $networker_settings[$n]['NetworkerSettings']['city'];
					$state[$n] 			= $networker_settings[$n]['NetworkerSettings']['state'];

					$tempCond = array();
					if($industry[$n]>1){
						$tempCond[] = array('Job.industry' => $industry[$n]);
			
					}
					if($specification[$n])
							$tempCond[] = array('Job.specification' => $specification[$n]);
					if($city[$n])
						$tempCond[] = array('Job.city ' => $city[$n]);
					if($state[$n])
						$tempCond[] = array('Job.state' => $state[$n]);
					  
		
					if(!$tempCond){
						$tempCond = array(1);
					}
					$job_cond[$n] =  array('AND' =>$tempCond);
				}
			}
			$job_cond[]=array('Job.id'=>$receivedJobs);
			$jobCounts['newJobs']= $this->Job->find('count',array(
												'conditions'=>array(
													'OR' => $job_cond,
						   							'AND' => array(
						   								array('is_active' => 1),
						   								'NOT'=>array(array('Job.id'=> $jobIds))
						   								)
						   							)
						   						)
						   					);
			$jobCounts['archivejobs']= $this->Job->find('count',array('conditions'=>array('OR' => $job_cond,
						   									'AND' => array('is_active' => 0))));
		}else{
			$jobCounts['newJobs']=0;
			$jobCounts['archivejobs']=0;
		}
		$jobCounts['sharedJobs']= $this->SharedJob->find('count',array('joins'=>array(
													array(
														'table'=>'jobs',
														'alias'=>'Job',
														'type'=>'left',
														'fields'=>'Job.is_active',
														'conditions'=>'Job.id=SharedJob.job_id AND Job.is_active = 1'
													),
												),
												'fields'=>'distinct SharedJob.job_id',
												'conditions'=>array(
													'SharedJob.user_id'=>$userId
												)
											)
										);
		return $jobCounts;
	}
	/**
	 * To get Networker Settings
	 */
	 public function getNetworkerSettings($userId){
	 	return $this->NetworkerSettings->find('all',array('conditions'=>array('user_id'=>$userId)));
	 }
	 
	 function invites(){
	 	$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
	
		$userId = $session->getUserId();
		$traceId = -1;
		/*** code for networker trac **/
        if($userId){
            if($this->userRole == NETWORKER){
            	$code=$this->Utility->getCode($traceId,$userId);
                $this->set('intermediateCode',$code);
            }
            if(isset($code)&&!empty($code)){
            	//$inviteUrl=Configure::read('httpRootURL').'?intermediateCode='.$code;
		       	$this->set('invitationCode',$code);
		    }   	
        }
        /**** end code ***/		
	 }
	 
	 function invitations() {
 	 	$this->layout = false;
 	 	$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
		$userId = $session->getUserId();
		$this->paginate = array('conditions'=>array('Invitation.user_id'=>$userId),
                                'limit' => 8,
                                'order' => array("Invitation.id" => 'asc',));  
		 	 	
        $Invitations = $this->paginate('Invitation');
		$this->set("invitations", $Invitations);  
		/*
		$userId = $session->getUserId();
		$traceId = -1*(time()%10000000);
		if($userId){
            if($this->userRole == NETWORKER){
            	$code=$this->Utility->getCode($traceId,$userId);
                $this->set('intermediateCode',$code);
            }
            if(isset($code)&&!empty($code)){
            	//$inviteUrl=Configure::read('httpRootURL').'?intermediateCode='.$code;
		       	$this->set('invitationCode',$code);
		    }   	
        }
        
 	 	
		$startWith = isset($this->params['named']['alpha'])?$this->params['named']['alpha']:"";
	
		$paginateCondition = array(
									'AND' => array(
												array('Invitation.user_id'=>$userId),
												array('Invitation.name_email  LIKE' => "$startWith%")
											)
								);
		$this->paginate = array('conditions'=>$paginateCondition,
                                'limit' => 10,
                                'order' => array("Invitation.id" => 'asc',));  
		 	 	
		$invitationArray =	$this->Invitation->find('all' ,array('conditions'=>array('user_id'=>$userId))) ;
        $Invitations = $this->paginate('Invitation');
	
	    $alphabets = array();
        foreach(range('A','Z') AS $alphabet){
        	$contacts_count = $this->Invitation->find('count',array('conditions'=>array('Invitation.user_id'=>$userId,
        																			 	'Invitation.name_email LIKE' => "$alphabet%"
        																					  )
        																  )
        													);
            $alphabets[$alphabet] = $contacts_count; 
        }
		
        $this->set('alphabets',$alphabets);
		$this->set("invitations", $Invitations);        
        $this->set('contact',null);
        $this->set('startWith',$startWith);
        */
 
	 }
	 
	 function networkerPoints(){
	 	$this->layout ="home";
 	 	$session = $this->_getSession();
		if(!$session->isLoggedIn()){
			$this->redirect("/login");
		}
	
		$userId = $session->getUserId();

		$user = $this->Networkers->find('first', array('conditions' => array('Networkers.user_id' => $userId) ));
		 
		$pointLables = $this->PointLabels->find('first' ,array('conditions'=>array("point_from <=".$user['Networkers']['points']." and point_to >=".$user['Networkers']['points'])));
		
		$boardData = $this->UserList->find('all', 
		 						array('joins'=>array(array('table' => 'networkers',
												         'alias' => 'Networker',
												         'type' => 'inner',
												         'conditions' => array('Networker.user_id = UserList.id'),
											        )),
		 								'limit'=>5 ,
		 								'conditions'=> array('NOT'=>array('UserList.id'=>array(1,2)),
		 													'UserList.is_active'=>array(1)),
		 								'recursive'=>'-1',
		 								'order' => array("Networker.points" => 'desc'),
		 								'fields' =>array('UserList.account_email, UserList.id ,Networker.contact_name,Networker.points' )));
			 
		$networkerBonus =	$this->Networkers->find('first',array(
			'fields'=>'sum(((PaymentHistory.amount*PaymentHistory.networker_reward_percent )/100)*PointLabels.bonus/100) as nr_bonus',
			'recursive'=>'-1',
			'joins'=>array(
				array(
					'table'=>'rewards_status',
					'alias'=>'RewardsStatus',
					'type'=>'left',
					'conditions'=>'RewardsStatus.user_id = Networkers.user_id '
				),
				array(
					'table'=>'payment_history',
					'alias'=>'PaymentHistory',
					'type'=>'left',
					'conditions'=>'PaymentHistory.id = RewardsStatus.payment_history_id'
				),
				array(
					'table'=>'point_labels',
					'alias'=>'PointLabels',
					'type'=>'left',
					'conditions'=>'PointLabels.point_from <= Networkers.points and PointLabels.point_to >= Networkers.points'
				),
				array(
					'table'=>'networkers',
					'alias'=>'Networker',
					'type'=>'left',
					'conditions'=>'Networker.user_id = RewardsStatus.user_id '
				)
				
			),
			'conditions'=>array('Networker.user_id'=>$userId),
			'group'=> 'RewardsStatus.user_id',
		));
		
		$userRank = $this->Networkers->find('all',array(
														'joins' =>array(
														array(
															'table'=>'rewards_status',
															'alias'=>'RewardsStatus',
															'type'=>'left',
															'conditions'=>'RewardsStatus.user_id = Networkers.user_id '
														),
														array(
															'table'=>'payment_history',
															'alias'=>'PaymentHistory',
															'type'=>'left',
															'conditions'=>'PaymentHistory.id = RewardsStatus.payment_history_id'
														)),
														'order' => array("points" => 'desc',
																		"amount" =>'desc',
																		"Networkers.user_id" ),
														'fields' => array('Networkers.user_id ')));
											
		$totalNr = count( $userRank);
		$rank = $totalNr;

		//echo array_search($userId ,$userRank);exit;
		foreach($userRank as $key =>$data ){
			if($data['Networkers']['user_id'] == $userId){
				$rank = $key+1;
				break;
			}
		}
		$this->set("userRank" ,array("rank" =>$rank ,"totalNr"=>$totalNr ));
		$this->set('boardData',$boardData);
		$this->set('pointLables',$pointLables);
		$this->set('user',$user);
		$this->set("networkerBonus",$networkerBonus);
	 }
	 
	 
	 
}
?>
