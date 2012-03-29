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
