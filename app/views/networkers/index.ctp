
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li>My Jobs</li>
				<li>My Network</li>
				<li class="active">My Account</li>

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
				<li><a href="/networkers/setting">Settings/Subscription</a></li>	
				<li class="active"><a href="/networkers">Profile</a></li>			
            </ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
				<div class="networker_setting_profile">
					<div class="networker_setting_profile_row">
						<div class="networker_setting_profile_field">Email:</div>
						<div class="networker_setting_profile_value"><?php echo $user['account_email'];?></div>
					</div>
					<div class="networker_setting_profile_row">
						<div class="networker_setting_profile_field">Address:</div>
						<div class="networker_setting_profile_value"><?php echo $networker['address'];?></div>
					</div>
					<div class="networker_setting_profile_row">
						<div class="networker_setting_profile_field">City:</div>
						<div class="networker_setting_profile_value"><?php echo $networker['city'];?></div>
					</div>
					<div class="networker_setting_profile_row">
						<div class="networker_setting_profile_field">State:</div>
						<div class="networker_setting_profile_value"><?php echo $networker['state'];?></div>
					</div>
					<div class="networker_setting_profile_row">
						<div class="networker_setting_profile_field">Phone:</div>
						<div class="networker_setting_profile_value"><?php echo $networker['contact_phone'];?></div>
					</div>
				</div>

			<div>                            
                  <table>
					<?php if(isset($fbinfo['first_name'])){?>
                    <tr><td>First Name:</td><td><?php  echo $fbinfo['first_name'];  ?></td></tr>
                    <?php }if(isset($fbinfo['last_name'])){?>
                    <tr><td>Last Name:</td><td><?php  echo $fbinfo['last_name']; ?></td></tr>
                    <?php }?>   
                    <tr><td>Email:</td><td><?php echo $user['account_email'];?></td></tr>
                    <?php if(isset($networker['address'])){ ?>
                    <tr><td>Address:</td><td><?php echo $networker['address'];?></td></tr>
                    <?php }if(isset($networker['city'])){ ?>
                    <tr><td>City:</td><td><?php echo $networker['city'];?></td></tr>
                    <?php }if(isset($networker['state'])){ ?>
                    <tr><td>State:</td><td><?php echo $networker['state'];?></td></tr>
                    <?php }if(isset($networker['contact_phone'])){?>
                    <tr><td>Phone:</td><td><?php  echo $networker['contact_phone'];?></td></tr>
                    <?php }?>
				</table>
					
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
