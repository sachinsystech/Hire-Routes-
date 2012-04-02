<?php
	if($this->Session->check('user_role'))
	{
		$user_role=$this->Session->read('user_role');
		if(isset($user_role) && $user_role['role_id']==1)
		{
?>
			<ul>
				<li <?php if($this->action=='newJob'||$this->action=='postJob'||$this->action=='jobDetail'||$this->action=='applyJob'||$this->action=='showArchiveJobs'||$this->action=='editJob'||$this->action=='showApplicant'||$this->action=='checkout'||$this->action=='jobStats'||$this->action=='companyData') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li <?php if($this->action=='index'||$this->action=='accountProfile'||$this->action=='editProfile'||$this->action=='paymentInfo'||$this->action=='paymentHistory'||$this->action=='paymentHistoryInfo') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>
				<li <?php if($this->action=='#'||$this->action=='#'||$this->action=='#') echo "class='active'";?>>My Employees</li>
			</ul>
		<?php 
		}
		elseif(isset($user_role) && $user_role['role_id']==2)
		{
		?>
			<ul>
				<li <?php if($this->action=='newJob'||$this->action=='appliedJob'||$this->action=='jobDetail'||$this->action=='applyJob'||$this->action=='archivedJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>My Jobs</span></a></li>
 				<li <?php if($this->action=='index'||$this->action=='editProfile'||$this->action=='setting'||$this->action=='jobProfile') echo "class='active'";?>><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
			</ul>
		<?php 
		}
		elseif(isset($user_role) && $user_role['role_id']==3)
		{
		?>
			<ul>
				<li <?php if($this->action=='newJob'||$this->action=='jobDetail'||$this->action=='archiveJob'||$this->action=='jobData'||$this->action=='#') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li <?php if($this->action=='personal'||$this->action=='addContacts'||$this->action=='networkerData') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li <?php if($this->action=='index'||$this->action=='setting'||$this->action=='editProfile') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers">My Account</a></li>

			</ul>
		<?php
		}
	}
?>
