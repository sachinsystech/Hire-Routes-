
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active">My Jobs</li>
				<li>My Network</li>
				<li>My Account</li>
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
				<li><a href="#">Settings/Subscription</a></li>	
                                <li class="active"><a href="http://hireroutes/jobseekers">Profile</a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
                                  <div style="padding:20px;">
					Email : <?php echo $user['account_email'];?><br><br>
					Address : <?php echo $jobseeker['address'];?><br><br>
					City : <?php echo $jobseeker['city'];?><br><br>
					State : <?php echo $jobseeker['state'];?><br><br>
					Phone : <?php echo $jobseeker['contact_phone'];?><br><br>
                                  </div>
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
