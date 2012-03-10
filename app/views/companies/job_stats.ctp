<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies"><span>My Account</span></a></li>
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
				<li ><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editJob/<?php echo $jobId;?>">Edit Job</a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/showApplicant/<?php echo $jobId;?>">Applicants</a></li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/jobStats/<?php echo $jobId;?>">Statistics</a></li>
			</ul>
			
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->

			<div class="middleBox">
				<div class="job_data">
					<table>	
						<tr>
							<td>#</td>
							<td><strong>All the Time</strong></td>
							<td><strong>Last Month</strong></td>
							<td><strong>Last Week</strong></td>
						</tr>
						<tr>
							<td><strong>Applications</strong></td>
							<td><?php echo $application_alltime;?></td>
							<td><?php echo $application_last_month?></td>
							<td><?php echo $application_last_week?></td>
						</tr>
						<tr>
							<td><strong>Shares<strong></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Views</strong></td>
							<td><?php echo $view_alltime;?></td>
							<td><?php echo $view_last_month;?></td>
							<td><?php echo $view_last_week;?></td>
						</tr>
					</table>
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
