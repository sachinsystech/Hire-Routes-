<?php 
/**
 * Top menu
 */
?>
<?php 
	if($this->Session->check('user_role')) :
		$user_role=$this->Session->read('user_role');
		
		/****	Adding top menu for Company User	****/
		if(isset($user_role) && $user_role['role_id']==COMPANY):

			if($this->action=='newJob'||$this->action=='showArchiveJobs'||$this->action=='companyData')
			{
		?>
			<ul>
				<li <?php if($this->action=='newJob') echo "class='active'";?>>
					<a class="menu_item" href="/companies/newJob">
						Jobs - <?php echo $activejobCount;?>					
					</a>
				</li>
				<li <?php if($this->action=='showArchiveJobs') echo "class='active'";?>>
					<a class="menu_item" href="/companies/showArchiveJobs">
						Archive - <?php echo $archJobCount; ?>
					</a>
				</li>
				<li <?php if($this->action=='companyData') echo "class='active'";?>>
					<a class="menu_item" href="/companies/companyData">
					Data
					</a>
				</li>
			</ul>
			<?php
			}elseif($this->action=='index'||$this->action=='accountProfile'||$this->action=='paymentInfo'||$this->action=='paymentHistory'||$this->action=='paymentHistoryInfo'||$this->action=='editProfile'||$this->action=='changePassword')
			{
			?>
				<ul style="float:left">
					<li <?php if($this->action=='accountProfile'||$this->action=='editProfile') echo "class='active'";?>>
						<a class="menu_item" href="/companies">Profile</a>
					</li>
					<li <?php if($this->action=='paymentInfo') echo "class='active'";?>>
						<a class="menu_item" href="/companies/paymentInfo">Payment Info</a>
					</li>
					<li <?php if($this->action=='paymentHistory'||$this->action=='paymentHistoryInfo') echo "class='active'";?>>
						<a class="menu_item" href="/companies/paymentHistory">Payment History</a>
					</li>
					<li <?php if($this->action=='changePassword') echo "class='active'";?>>
						<a class="menu_item" href="/users/changePassword">Change Password</a>
					</li>
				</ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;">
						<a class="menu_item" href="/companies/editProfile">Edit Profile</a>
					</li>
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
                	<li <?php if($this->action=='editJob') echo "class='active'";?>>
                		<a class="menu_item" href="/companies/editJob/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>"> Edit </a>
                		</li>
					<li <?php if($this->action=='showApplicant') echo "class='active'";?>>
						<a class="menu_item" href="/companies/showApplicant/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>">Applicants - <?php echo $NoOfApplicants;?></a>
					</li>
					<li <?php if($this->action=='jobStats') echo "class='active'";?>>
						<a class="menu_item" href="/companies/jobStats/<?php if(isset($jobId)) echo $jobId; elseif(isset($job['id'])) echo $job['id'];?>"> Data </a>
					</li>
				</ul>
			<?php
			}
			?>
		<?php 
			endif;
			/****	ends of top menu for Company User	****/		
		?>
			
<!-- ******************************************************************************************* -->
		
		
	<?php		/****	Adding top menu for Jobseeker User	****/
		if(isset($user_role) && $user_role['role_id']==JOBSEEKER):
	?>
		<?php
			if($this->action=='newJob'||$this->action=='appliedJob'||$this->action=='archivedJob')
			{
		?>
			<ul style="float:left">
				<li <?php if($this->action=='newJob') echo "class='active'";?>><a class="menu_item"  href="/jobseekers/newJob">Inbox - <?php echo $NewJobs;?></a></li>	
				<li <?php if($this->action=='appliedJob') echo "class='active'";?>><a class="menu_item" href='/jobseekers/appliedJob'>Applied - <?php echo $AppliedJobs;?></a></li>	
                <li <?php if($this->action=='archivedJob') echo "class='active'";?>><a class="menu_item" href="/jobseekers/archivedJob">Archive - <?php echo $Archivedjobs;?></a></li>
			</ul>
			<?php
			}elseif($this->action=='index'||$this->action=='jobProfile'||$this->action=='setting'||$this->action=='editProfile'||$this->action=='changePassword')
			{
			?>
				<ul style="float:left">
					<li <?php if($this->action=='jobProfile') echo "class='active'";?>>
						<a class="menu_item" href="/jobseekers/jobProfile">Job Profile</a>
					</li>	
					<li <?php if($this->action=='setting') echo "class='active'";?>>
						<a class="menu_item" href="/jobseekers/setting">Settings/Subscription</a>
					</li>	
                	<li <?php if($this->action=='index'||$this->action=='editProfile') echo "class='active'";?>>
                		<a class="menu_item" href="/jobseekers">Profile</a>
                	</li>
                	<li <?php if($this->action=='changePassword') echo "class='active'";?>>
                		<a class="menu_item" href="/users/changePassword">Change Password</a>
                	</li>
				</ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;">
						<a class="menu_item" href="/jobseekers/editProfile">Edit Profile</a>
					</li>
				</ul>
			<?php
			}
			?>
		<?php
			endif;
			/****	ends of top menu for Jobseeker User	****/	
		?>
<!-- ******************************************************************************************* -->
		<?php
		/****	Adding top menu for Networker User	****/	
		if(isset($user_role) && $user_role['role_id']==NETWORKER):
?>
		<?php
			if($this->action=='newJob'||$this->action=='#'||$this->action=='archiveJob'||$this->action=='jobData'){
		?>
				<ul>
					<li <?php if($this->action=='newJob'||$this->action=='#') echo "class='active'";  ?>>
						<a class="menu_item" href="/networkers/newJob">Inbox - <?php echo $NewJobs;?></a>
					</li>	
					<li <?php if($this->action=='#') echo "class='active'";  ?>>
						<a class="menu_item" href="#">Shared - 10</a>
					</li>
					<li <?php if($this->action=='archiveJob') echo "class='active'";  ?>>
						<a class="menu_item" href="/networkers/archiveJob">Archive - <?php echo $ArchiveJobs;?></a>
					</li>
					<li <?php if($this->action=='jobData') echo "class='active'";  ?>>
						<a class="menu_item" href="/networkers/jobData"> Data </a>
					</li>			
            </ul>
			<?php
			}elseif($this->action=='index'||$this->action=='setting'||$this->action=='editProfile'||$this->action=='changePassword'){
			?>
				<ul>
					<li <?php if($this->action=='setting') echo "class='active'";?>>
						<a class="menu_item" href="/networkers/setting">Settings/Subscription</a>
					</li>	
					<li <?php if($this->action=='index'||$this->action=='editProfile') echo "class='active'";  ?>>
						<a class="menu_item" href="/networkers">Profile</a>
					</li>
					<li <?php if($this->action=='changePassword') echo "class='active'";?>>
						<a class="menu_item" href="/users/changePassword">Change Password</a>
					</li>			
                </ul>
				<ul style="float:right">
					<li style="background-color: #3DB517;">
						<a class="menu_item" href="/networkers/editProfile">Edit Profile</a>
					</li>
				</ul>
			<?php
			}elseif($this->action=='personal'||$this->action=='addContacts'||$this->action=='networkerData'){
			?>
				<ul style="float:left">
					<li <?php if($this->action=='personal') echo "class='active'";?>>
						<a class="menu_item" href="/networkers/personal">Personal</a>
					</li>
					<li <?php if($this->action=='addContacts') echo "class='active'";?>>
						<a class="menu_item" href="/networkers/addContacts">Add Contact(s)</a>
					</li>
					<li <?php if($this->action=='networkerData') echo "class='active'";?>>
						<a class="menu_item" href='/networkers/networkerData'>Data</a>
					</li>
				</ul>
			<?php
			}
			?>
		<?php
			endif;	
		?>
<?php endif;?>
