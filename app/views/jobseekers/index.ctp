<?php 
/*

*/
?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu'); ?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                <div class="setting_profile">
					<?php if(isset($jobseeker['contact_name'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Name:</div>
						<div class="setting_profile_value"><?php echo $jobseeker['contact_name'];?></div>
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
					
					<div class="setting_profile_row">
						<div class="setting_profile_field">Email:</div>
						<div class="setting_profile_value"><?php echo $user['UserList']['account_email'];?></div>
					</div>
					<?php if(isset($jobseeker['university_id']) && $jobseeker['university_id'] != 0 ): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">University:</div>
						<div class="setting_profile_value"><?php echo $user['Universities']['name'];?></div>
					</div>
					<?php endif;?>
					
					<?php if(isset($jobseeker['graduate_degree_id']) && $jobseeker['graduate_degree_id'] != null ): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Graduate Degree:</div>
						<div class="setting_profile_value"><?php echo $user['GraduateDegrees']['degree'];?></div>
					</div>
					<?php endif;?>
					
					<?php if(isset($user['GUB']['graduate_college']) && $user['GUB'] != null): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Graduate College:</div>
						<div class="setting_profile_value"><?php echo $user['GUB']['graduate_college'];?></div>
					</div>
					<?php endif;?>
				</div>
			</div>
			
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->


</div>
