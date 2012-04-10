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
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Posted:</div>
						<div class="setting_profile_value"><?php echo $JobPosted;?></div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Filled:</div>
						<div class="setting_profile_value"><?php echo $JobFilled;?></div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Rewards Posted:</div>
						<div class="setting_profile_value">
							<?php echo $this->Number->format(
										$RewardsPosted,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
							);?>
						</div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Rewards Paid:</div>
						<div class="setting_profile_value">
							<?php echo $this->Number->format(
										$RewardsPaid,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
							);?>
						</div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Applicants:</div>
						<div class="setting_profile_value"><?php echo $Applicants;?></div>
					</div>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Views:</div>
						<div class="setting_profile_value"><?php echo $Views;?></div>
					</div>
				</div>
			</div>	
		<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
