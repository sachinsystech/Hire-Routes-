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
							<td><strong>Applicants</strong></td>
							<td><?php echo $jobStatusArray['aat'];?></td>
							<td><?php echo $jobStatusArray['alm'];?></td>
							<td><?php echo $jobStatusArray['alw'];?></td>
						</tr>
						<tr>
							<td><strong>Shares<strong></td>
							<td><?php echo $jobStatusArray['sat'];?></td>
							<td><?php echo $jobStatusArray['slm'];?></td>
							<td><?php echo $jobStatusArray['slw'];?></td>
						</tr>
						<tr>
							<td><strong>Views</strong></td>
							<td><?php echo $jobStatusArray['vat'];?></td>
							<td><?php echo $jobStatusArray['vlm'];?></td>
							<td><?php echo $jobStatusArray['vlw'];?></td>
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
