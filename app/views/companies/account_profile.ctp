<?php
/*
	page for companie account
*/
?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
		<!--<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>-->
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

					<?php if(isset($company['company_name'])): ?>
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Company:</div>
						<div class="setting_profile_value"><?php echo $company['company_name'];?></div>
					</div>
					<?php endif;?>

					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Company Name:</div>
						<div class="setting_profile_value"><?php echo $company['contact_name'];?></div>
					</div>
			
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Contact Phone:</div>
						<div class="setting_profile_value"><?php echo $company['contact_phone'];?></div>
					</div>
					
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Email:</div>
						<div class="setting_profile_value"><?php echo $user['account_email'];?></div>
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
