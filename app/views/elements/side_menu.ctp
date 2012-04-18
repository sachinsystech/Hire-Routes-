<?php
	if($this->Session->check('userRole'))
	{
		$userRoleId=$this->Session->read('userRole.id');
		if(isset($userRoleId) && $userRoleId==COMPANY)
		{
			$my_jobs_actions=array('newJob','postJob','jobDetail','applyJob','showArchiveJobs','editJob','showApplicant','checkout','jobStats','companyData');
			$my_accounts_actions=array('index','accountProfile','editProfile','paymentInfo','paymentHistory','paymentHistoryInfo','changePassword');
			$my_employees_actions=array('employees','#','#');
?>
			<ul>
				<li <?php if(in_array($this->action,$my_jobs_actions)) echo "class='active'";?>><a class="menu_item" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li <?php if(in_array($this->action,$my_accounts_actions)) echo "class='active'";?>><a class="menu_item" href="/companies">My Account</a></li>
				<li <?php if(in_array($this->action,$my_employees_actions)) echo "class='active'";?>><a class="menu_item" href="/companies/employees">My Employees</a></li>
			</ul>
		<?php 
		}
		elseif(isset($userRoleId) && $userRoleId==JOBSEEKER)
		{
			$my_jobs_actions=array('newJob','appliedJob','jobDetail','applyJob','archivedJob');
			$my_accounts_actions=array('index','editProfile','setting','jobProfile','changePassword');
		?>
			<ul>

				<li <?php if(in_array($this->action,$my_jobs_actions)) echo "class='active'";?>><a class="menu_item" href="/jobseekers/newJob"><span>My Jobs</span></a></li>
 				<li <?php if(in_array($this->action,$my_accounts_actions)) echo "class='active'";?>><span><a class="menu_item" href="/jobseekers">My Account</a></span></li>

			</ul>
		<?php 
		}
		elseif(isset($userRoleId) && $userRoleId==NETWORKER)
		{
			$my_jobs_actions=array('newJob','jobDetail','archiveJob','jobData','sharedJob');
			$my_accounts_actions=array('index','setting','editProfile','changePassword');
			$my_networks_actions=array('personal','addContacts','networkerData');
		?>
			<ul>
				<li <?php if(in_array($this->action,$my_jobs_actions)) echo "class='active'";?>><a class="menu_item" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li <?php if(in_array($this->action,$my_networks_actions)) echo "class='active'";?>><a class="menu_item" href="/networkers/personal"><span>My Network</span></a></li>
				<li <?php if(in_array($this->action,$my_accounts_actions)) echo "class='active'";?>><a class="menu_item" href="/networkers">My Account</a></li>

			</ul>
		<?php
		}
	}
?>
