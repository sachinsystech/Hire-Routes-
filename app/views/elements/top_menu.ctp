<?php 
/**
 * Top menu
 */
?>
<?php
	if($this->Session->check('user_role'))
	{
		$user_role=$this->Session->read('user_role');
		//For Companies
		if(isset($user_role) && $user_role['role_id']==1)
		{
?>
		<?php
			if($this->action=='newJob'||$this->action=='showArchiveJobs'||$this->action=='companyData')
			{
		?>
			<ul>
				<li <?php if($this->action=='newJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob">Jobs - <?php if($this->action=='newJob'){ echo count($jobs);}else{echo $activejobCount;}?></a></li>
				<li <?php if($this->action=='showArchiveJobs') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/showArchiveJobs">Archive - <?php if($this->action=='showArchiveJobs'){echo count($jobs);}else{echo $archJobCount;}?></a></li>
				<li <?php if($this->action=='companyData') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="companyData">Data</a></li>
			</ul>
			<?php
			}elseif($this->action=='index'||$this->action=='accountProfile'||$this->action=='paymentInfo'||$this->action=='paymentHistory'||$this->action=='paymentHistoryInfo'||$this->action=='editProfile')
			{
			?>
				<ul style="float:left">
					<li <?php if($this->action=='accountProfile'||$this->action=='editProfile') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">Profile</a></li>
					<li <?php if($this->action=='paymentInfo') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentInfo">Payment Info</a></li>
					<li <?php if($this->action=='paymentHistory'||$this->action=='paymentHistoryInfo') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentHistory">Payment History</span></a></li>
				</ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editProfile"><span>Edit Profile</span></a></li>
				</ul>
			<?php
			}elseif($this->action=='checkout')
			{
			?>
				<ul style="float:left">
					<li class="active">Checkout</li>
				</ul>
			<?php
			}elseif($this->action=='employees')
			{
			?>
				<ul style="float:left">
					<li class="active">Employees</li>
				</ul>
			<?php
			}elseif($this->action=='editJob'||$this->action=='showApplicant'||$this->action=='jobStats')
			{
			?>
				<ul style="float:left">
                	<li <?php if($this->action=='editJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editJob/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>"> Edit </a></li>
					<li <?php if($this->action=='showApplicant') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/showApplicant/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>">Applicants - <?php if(isset($NoOfApplicants)) echo $NoOfApplicants;?></a></li>
					<li <?php if($this->action=='jobStats') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/jobStats/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>"> Data </a></li>
				</ul>
			<?php
			}
			?>
		<?php
		}
		
		//For Job Seeker
		if(isset($user_role) && $user_role['role_id']==2)
		{
?>
		<?php
			if($this->action=='newJob'||$this->action=='appliedJob'||$this->action=='archivedJob')
			{
		?>
			<ul style="float:left">
				<li <?php if($this->action=='newJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;"  href="/jobseekers/newJob">Inbox - <?php echo $NewJobs;?></a></li>	
				<li <?php if($this->action=='appliedJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href='/jobseekers/appliedJob'>Applied - <?php echo $AppliedJobs;?></a></li>	
                <li <?php if($this->action=='archivedJob') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="archivedJob">Archive - <?php echo $Archivedjobs;?></a></li>
			</ul>
			<?php
			}elseif($this->action=='index'||$this->action=='jobProfile'||$this->action=='setting'||$this->action=='editProfile')
			{
			?>
				<ul style="float:left">
					<li <?php if($this->action=='jobProfile') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/jobProfile">Job Profile</a></li>	
					<li <?php if($this->action=='setting') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/setting">Settings/Subscription</a></li>	
                	<li <?php if($this->action=='index'||$this->action=='editProfile') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">Profile</a></li>
				</ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/editProfile"><span>Edit Profile</span></a></li>
				</ul>
			<?php
			}
			?>
		<?php
		}	
		
		//For Networker
		if(isset($user_role) && $user_role['role_id']==3)
		{
?>
		<?php
			if($this->action=='newJob'||$this->action=='#'||$this->action=='archiveJob'||$this->action=='jobData')
			{
		?>
				<ul>
					<li <?php if($this->action=='newJob'||$this->action=='#') echo "class='active'";  ?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="newJob">Inbox - <?php if(isset($NewJobs)) echo $NewJobs;?></a></li>	
					<li <?php if($this->action=='#') echo "class='active'";  ?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="#">Shared - 10</a></li>
					<li <?php if($this->action=='archiveJob') echo "class='active'";  ?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="archiveJob">Archive - <?php if(isset($ArchiveJobs)) echo $ArchiveJobs;?></a></li>
					<li <?php if($this->action=='jobData') echo "class='active'";  ?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="jobData"> Data </a></li>			
            </ul>
			<?php
			}elseif($this->action=='index'||$this->action=='setting'||$this->action=='editProfile')
			{
			?>
				<ul>
					<li <?php if($this->action=='setting') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/setting">Settings/Subscription</a></li>	
					<li <?php if($this->action=='index'||$this->action=='editProfile') echo "class='active'";  ?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers">Profile</a></li>			
                </ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/editProfile"><span>Edit Profile</span></a></li>
				</ul>
			<?php
			}elseif($this->action=='personal'||$this->action=='addContacts'||$this->action=='networkerData')
			{
			?>
				<ul style="float:left">
					<li <?php if($this->action=='personal') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>Personal</span></a></li>
					<li <?php if($this->action=='addContacts') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/addContacts"><span>Add Contact(s)</span></a></li>
					<li <?php if($this->action=='networkerData') echo "class='active'";?>><a style="color: #000000;text-decoration: none;font-weight: normal;" href='/networkers/networkerData'>Data</a></li>
				</ul>
			<?php
			}
			?>
		<?php
		}	
		?>
<?php
}	
?>
