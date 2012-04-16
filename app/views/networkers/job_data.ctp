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
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<div class="middleBox">
			<div class="setting_profile">
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Received:</div>
						<div class="setting_profile_value"><?php echo $NewJobs;?></div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Shared:</div>
						<div class="setting_profile_value"><?php echo $SharedJobs;?></div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Filled:</div>
						<div class="setting_profile_value">
						</div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Rewards:</div>
						<div class="setting_profile_value">
							<?php echo $this->Number->format(
										$TotalReward,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
							);?>
						</div>
					</div>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
