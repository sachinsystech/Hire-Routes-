<div class="page">
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

					<?php if(isset($fbinfo['first_name']) && isset($fbinfo['last_name'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Name:</div>
						<div class="setting_profile_value"><?php  echo ucfirst($fbinfo['first_name'])." ".ucfirst($fbinfo['last_name']);  ?></div>
					</div>
					<?php endif;?>

					<?php if(isset($networker['contact_name'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Name:</div>
						<div class="setting_profile_value"><?php echo $networker['contact_name'];?></div>
					</div>
					<?php endif;?>


					<?php if(isset($networker['address'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Address:</div>
						<div class="setting_profile_value"><?php echo $networker['address'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($networker['city'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">City:</div>
						<div class="setting_profile_value"><?php echo $networker['city'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($networker['state'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">State:</div>
						<div class="setting_profile_value"><?php echo $networker['state'];?></div>
					</div>
					<?php endif;?>

					<?php if(isset($networker['contact_phone'])): ?>
					<div class="setting_profile_row">
						<div class="setting_profile_field">Phone:</div>
						<div class="setting_profile_value"><?php echo $networker['contact_phone'];?></div>
					</div>
					<?php endif;?>
				</div>
			</div>	
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->


</div>
