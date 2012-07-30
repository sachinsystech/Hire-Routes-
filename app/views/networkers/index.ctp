<?php ?><div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
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
					<?php if(isset($user['networkers']['contact_name'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Name:</div>
						<div class="setting_profile_value"><?php echo ucfirst($user['networkers']['contact_name']);?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['networkers']['address'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Address:</div>
						<div class="setting_profile_value"><?php echo $user['networkers']['address'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['networkers']['city'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">City:</div>
						<div class="setting_profile_value"><?php echo $user['networkers']['city'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['networkers']['state'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">State:</div>
						<div class="setting_profile_value"><?php echo $user['networkers']['state'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['networkers']['contact_phone'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Phone:</div>
						<div class="setting_profile_value"><?php echo $user['networkers']['contact_phone'];?></div>
					</div>
					<?php endif;?>
					
					<?php if(isset($user['universities']['name'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">University:</div>
						<div class="setting_profile_value"><?php echo $user['universities']['name'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($user['graduate_degrees']['degree'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Graduate Degree:</div>
						<div class="setting_profile_value"><?php echo $user['graduate_degrees']['degree'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($graduateUniversity) && $graduateUniversity != "" ): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Graduate University:</div>
						<div class="setting_profile_value"><?php echo $graduateUniversity;?></div>
					</div>
					<?php endif;?>
					
					<div class="setting_profile_row">
						<div class="setting_profile_field">Email:</div>
						<div class="setting_profile_value"><?php echo $user['UserList']['account_email'];?></div>
					</div>
				</div>
			</div>	
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->

</div>
