<?php
	if($this->Session->check('user_role'))
	{
		$user_role=$this->Session->read('user_role');
		if(isset($user_role) && $user_role['role_id']==1)
		{
			$my_jobs_actions=array('newJob','postJob','jobDetail','applyJob','showArchiveJobs','editJob','showApplicant','checkout','editJob','jobStats');
			$my_accounts_actions=array('index','accountProfile','editProfile','paymentInfo','paymentHistory','paymentHistoryInfo');
			$my_employees_actions=array('#','#','#');
?>
			<ul>
				<li <?php if($this->action=='newJob'||$this->action=='postJob'||$this->action=='jobDetail'||$this->action=='applyJob'||$this->action=='showArchiveJobs'||$this->action=='editJob'||$this->action=='showApplicant'||$this->action=='checkout'||$this->action=='jobStats'||$this->action=='#') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li <?php if($this->action=='index'||$this->action=='accountProfile'||$this->action=='editProfile'||$this->action=='paymentInfo'||$this->action=='paymentHistory'||$this->action=='paymentHistoryInfo') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>
				<li <?php if($this->action=='employees'||$this->action=='#'||$this->action=='#') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/employees">My Employees</a></li>
			</ul>
		<?php 
		}
		elseif(isset($user_role) && $user_role['role_id']==2)
		{
			$my_jobs_actions=array('newJob','appliedJob','jobDetail','applyJob','#');
			$my_accounts_actions=array('index','editProfile','setting','jobProfile');
		?>
			<ul>
				<li <?php if(in_array($this->action,$my_jobs_actions)) echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>My Jobs</span></a></li>
 				<li <?php if(in_array($this->action,$my_accounts_actions)) echo "class='active'";?>><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
			</ul>
		<?php 
		}
		elseif(isset($user_role) && $user_role['role_id']==3)
		{
			$my_jobs_actions=array('newJob','jobDetail','archiveJob','jobData','#');
			$my_accounts_actions=array('index','setting','editProfile');
			$my_networks_actions=array('personal','addContacts','networkerData');
		?>
			<ul>
				<li <?php if(in_array($this->action,$my_jobs_actions)) echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li <?php if(in_array($this->action,$my_networks_actions)) echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li <?php if(in_array($this->action,$my_accounts_actions)) echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers">My Account</a></li>

			</ul>
		<?php
		}
	}
?>
