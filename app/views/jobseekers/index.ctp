<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>New Jobs</span></a></li>
                <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/appliedJob"><span>Applied Jobs</span></a></li>
				<li><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href=""><span>My Network</span></li>
				<li class="active"><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
                <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/jobProfile">Job Profile</a></li>	
	            <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/setting">Settings/Subscription</a></li>	
                <li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">Profile</a></li>
			</ul>
            <ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                <div class="setting_profile">

					<?php if(isset($fbinfo['first_name']) && isset($fbinfo['last_name'])): ?>
					<div class="etting_profile_row">
						<div class="setting_profile_field">Name:</div>
						<div class="setting_profile_value"><?php  echo ucfirst($fbinfo['first_name'])." ".ucfirst($fbinfo['last_name']);  ?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['account_email'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Email:</div>
						<div class="setting_profile_value"><?php echo $user['account_email'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($jobseeker['address'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Address:</div>
						<div class="setting_profile_value"><?php echo $jobseeker['address'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($jobseeker['city'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">City:</div>
						<div class="setting_profile_value"><?php echo $jobseeker['city'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($jobseeker['state'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">State:</div>
						<div class="setting_profile_value"><?php echo $jobseeker['state'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($jobseeker['contact_phone'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Phone:</div>
						<div class="setting_profile_value"><?php echo $jobseeker['contact_phone'];?></div>
					</div>
					<?php endif;?>
				</div>
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
