
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
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                    <table>
					<tr><td>Email:</td><td><?php echo $user['account_email'];?></td></tr>
					<tr><td>Address:</td><td><?php echo $jobseeker['address'];?></td></tr>
					<tr><td>City:</td><td><?php echo $jobseeker['city'];?></td></tr>
					<tr><td>State:</td><td><?php echo $jobseeker['state'];?></td></tr>
                    <tr><td>Phone:</td><td><?php echo $jobseeker['contact_phone'];?></td></tr>
				</table>
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
