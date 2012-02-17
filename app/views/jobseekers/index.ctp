
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li >My Jobs</li>
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
                <li><a href="#">Job Profile</a></li>	
				<li><a href="/jobseekers/setting">Settings/Subscription</a></li>	
                <li class="active"><a href="/jobseekers">Profile</a></li>
			</ul>
            <ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                    <table>
                    <?php if(isset($fbinfo['first_name'])){?>
                    <tr><td>First Name:</td><td><?php  echo $fbinfo['first_name'];  ?></td></tr>
                    <?php }if(isset($fbinfo['last_name'])){?>
                    <tr><td>Last Name:</td><td><?php  echo $fbinfo['last_name']; ?></td></tr>
                    <?php }?>                    
                    <tr><td>Email:</td><td><?php echo $user['account_email'];?></td></tr>
                    <?php if(isset($jobseeker['address'])){ ?>
                    <tr><td>Address:</td><td><?php echo $jobseeker['address'];?></td></tr>
                    <?php }if(isset($jobseeker['city'])){?>
                    <tr><td>City:</td><td><?php  echo $jobseeker['city'];?></td></tr>
                    <?php }if(isset($jobseeker['state'])){?>
                    <tr><td>State:</td><td><?php  echo $jobseeker['state'];?></td></tr>
                    <?php }if(isset($jobseeker['contact_phone'])){?>
                    <tr><td>Phone:</td><td><?php  echo $jobseeker['contact_phone'];?></td></tr>
                    <?php }?>
				</table>
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
