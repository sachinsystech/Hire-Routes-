<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/"><span>My Network</span></a></li>
				<li class="active">My Account</li>
				<li>My Employees</li>
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
			<ul style="float:left">
				<li class="active">Profile</li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentInfo">Payment Info</a></li>
				<li>Payment History</li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editProfile"><span>Edit</span></a></li>
			</ul>
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
