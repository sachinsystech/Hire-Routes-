<?php

	if($this->Session->check('UserRole'))
	{
		$class= " class='job_submenu_active'";
		$plusIconClass= "class='HrMenu plus_icon'";
		$minusIconClass = "class='HrMenu minus_icon'";
		$menu_show = "id='menu_show'";
		$display = 'style="display:none;"';
		$userRoleId=$this->Session->read('UserRole');
		$passwordLable='Change password';
		if(isset($facebookUserData)){		
			$passwordLable= ($facebookUserData!=null)?"Set password":"Change password";
		}
		if(isset($userRoleId) && $userRoleId==COMPANY)
		{
			$my_jobs_actions=array('newJob','postJob','jobDetail','applyJob','showArchiveJobs','editJob','showApplicant','checkout','jobStats','companyData');
			$my_accounts_actions=array('index','accountProfile','editProfile','paymentInfo','paymentHistory','paymentHistoryInfo','changePassword');
			$my_employees_actions=array('employees','#','#');
			$my_invitations_actions = array('invitations');
?>
	
		<div class="job_left_bar">
			    <div class="job_left_menu">
                    <ul>
                         <li><a <? if(!in_array($this->action,$my_jobs_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass ?> href="#">My Jobs</a>
                            <div <? if(!in_array($this->action,$my_jobs_actions)){ echo $display;}?> class="job_menus_submenu">
                                <ul>
                                    <li><a href="/companies/newJob" <?php if($this->action=='newJob')echo $class;?> >Jobs - <?php echo $activejobCount;?></a></li>
                                    <li><a href="/companies/showArchiveJobs" <?php if($this->action=='showArchiveJobs')echo $class;?> >Archive - <?php echo $archJobCount; ?></a></li>
                                    <li><a href="/companies/postJob" <?php if($this->action=='postJob')echo $class;?>>Post Job</a></li> 
                                    <li><a href="/companies/companyData" <?php if($this->action=='companyData')echo $class;?>>Data</a></li> 
                                </ul>
                            </div>
                        </li>
                        
                     
                        
                        <li><a <? if(!in_array($this->action,$my_accounts_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?> href="#">My Account</a>
                        	<div <? if(!in_array($this->action,$my_accounts_actions)){ echo $display;}?> class="job_menus_submenu">
                        		<ul>
                                    <li><a href="/companies"  <?php if($this->action=='accountProfile')echo $class;?>>Personal</a></li>
									<li><a href="/companies/paymentInfo" <?php if($this->action=='paymentInfo')echo $class;?>>Payment Info</a></li>
                                    <li><a href="/companies/paymentHistory" <?php if($this->action=='paymentHistory')echo $class;?>>Payment History</a></li>
									<li><a href="/users/changePassword" <?php if($this->action=='changePassword')echo $class;?>><?php echo $passwordLable; ?></a></li>
                            	</ul>
                             </div>
                         </li>
                         
                        <li><a <? if(!in_array($this->action,$my_employees_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?> href="#">My Employees</a>
                        	<div <? if(!in_array($this->action,$my_employees_actions)){ echo $display;}?> class="job_menus_submenu job_menus_last">
                        		<ul>
                                    <li><a href="/companies/employees" <?php if($this->action=='employees')echo $class;?>>Employees</a></li>
                                </ul>
                             </div>
                        </li>
                        
                    </ul>
                </div>
        
		</div>
	
			
		<?php 
		}
		elseif(isset($userRoleId) && $userRoleId==JOBSEEKER)
		{
			$my_jobs_actions=array('newJob','appliedJob','jobDetail','applyJob','archivedJob');
			$my_accounts_actions=array('index','editProfile','setting','jobProfile','changePassword');
			$my_invitations_actions = array('invitations');
		?>
			 <div class="job_left_bar">
                <div class="job_left_menu">
                    <ul>
                        <li><a <? if(!in_array($this->action,$my_jobs_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?>  href="#">My Jobs</a>

                            <div <? if(!in_array($this->action,$my_jobs_actions)){ echo $display;}?> class="job_menus_submenu">
                                <ul>
                                    <li><a href="/jobseekers/newJob" <?php if($this->action=='newJob')echo $class;?>>Inbox - <?php echo $NewJobs;?></a></li>
                                    <li>
                                    	<a href='/jobseekers/appliedJob' <?php if($this->action=='appliedJob')echo $class;?>>Applied - <?php echo $AppliedJobs;?></a>
                                    </li>	
                                    <li >
                                    	<a href="/jobseekers/archivedJob" <?php if($this->action=='archivedJob')echo $class;?>>Archive - <?php echo $Archivedjobs;?></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li><a <? if(!in_array($this->action,$my_accounts_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?> href="#">My Account</a>

                        	<div <? if(!in_array($this->action,$my_accounts_actions)){ echo $display;}?>class="job_menus_submenu job_menus_last">

                        		<ul>
	                        		<li><a href="/jobseekers/jobProfile"" <?php if($this->action=='jobProfile')echo $class;?>>Job Profile</a></li>
                                    <li><a href="/jobseekers/setting" <?php if($this->action=='setting')echo $class;?>>Settings/Subscription</a></li>
									<li><a href="/jobseekers"  <?php if($this->action=='index'||$this->action=='editProfile') echo $class;?>>Profile</a></li>
                                    <li><a href="/users/changePassword" <?php if($this->action=='changePassword') echo $class;?>><?php echo $passwordLable; ?></a></li>
                                </ul>
                             </div>
                        </li>
                    </ul>
                </div>
            </div>
		<?php 
		}
		elseif(isset($userRoleId) && $userRoleId==NETWORKER)
		{
			$my_jobs_actions=array('newJob','jobDetail','archiveJob','jobData','sharedJob');
			$my_accounts_actions=array('index','setting','editProfile','changePassword');
			$my_networks_actions=array('networkerPoints','personal','addContacts','networkerData','invitations');
		?>
		<div class="job_left_bar">
                <div class="job_left_menu">
                    <ul>
                         <li><a <? if(!in_array($this->action,$my_jobs_actions)){ echo $menu_show; echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?>  class="HrMenu plus_icon" href="#">My Jobs</a>

                            <div <? if(!in_array($this->action,$my_jobs_actions)){ echo $display;}?> class="job_menus_submenu">
                                <ul>
                                    <li>
                                    	<a href="/networkers/newJob" <?php if($this->action=='newJob'|| $this->action=='#') echo $class;?>>Inbox - <?php echo $NewJobs;?></a>
                                    </li>
                                    <li><a href="/networkers/sharedJob" <?php if($this->action=='sharedJob') echo $class;?> >Shared - <?php echo $SharedJobs;?></a></li>
                                    <li><a href="/networkers/archiveJob"  <?php if($this->action=='archiveJob') echo $class;?> >Archive -  <?php echo $ArchiveJobs;?></a></li>
                                    <li><a href="/networkers/jobData" <?php if($this->action=='jobData') echo $class;?> >Data</a></li> 
                                </ul>
                            </div>
                        </li>
 
                        <li><a  <? if(!in_array($this->action,$my_networks_actions)){ echo $menu_show;echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?> href="#">My Network</a>
                        	<div <? if(!in_array($this->action,$my_networks_actions)){ echo $display;}?> class="job_menus_submenu">
                        		<ul>
                                    <li >
                                    	<a href="/networkers/personal" <?php if($this->action=='personal') echo $class;?>>Personal</a>
                                    </li>
									<li >
										<a href="/networkers/networkerPoints"<?php if($this->action=='networkerPoints')echo $class;?>>Points</a>
									</li>
                                    <li >
                                    	<a href="/networkers/addContacts" <?php if($this->action=='addContacts') echo $class;?>>Add Contact(s)</a>
                                    </li>
                            	</ul>
                             </div>
                         </li>
                         
                        <li><a <? if(!in_array($this->action,$my_accounts_actions)){ echo $menu_show; echo $plusIconClass;}else echo $minusIconClass?> href="#">My Account</a>
                        	<div <? if(!in_array($this->action,$my_accounts_actions)){ echo $display;}?> class="job_menus_submenu job_menus_last">
                        		<ul>
                                    <li><a href="/networkers/setting" <?php if($this->action=='setting') echo $class;?>>Settings/Subscription</a></li>
									<li><a href="/networkers" <?php if($this->action=='index' || $this->action=='editProfile') echo $class;?>>Profile</a></li>
                                    <li><a href="/users/changePassword" <?php if($this->action=='changePassword') echo $class;?>><?php echo $passwordLable; ?></a></li>

                                </ul>
                             </div>
                        </li>
                        
                    </ul>
                </div>
            </div>
		<?php
		}
	}
?>

<script>
$(".HrMenu").click(function(){
	$(".HrMenu").removeClass("minus_icon").addClass("plus_icon").next().slideUp();
	$(this).removeClass("plus_icon").addClass("minus_icon").next().slideDown();
});
</script>
