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
							<td><strong>Job Posted</strong></td>
							<td><?php echo $JobPosted;?></td>
						</tr>
						<tr>
							<td><strong>Job Filled</strong></td>
							<td><?php echo $JobFilled;?></td>
						</tr>
						<tr>
							<td><strong>Rewards Posted</strong></td>
							<td><?php echo $this->Number->format(
										$RewardsPosted,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></td>
						</tr>
						<tr>
							<td><strong>Rewards Paid</strong></td>
							<td><?php echo $this->Number->format(
										$RewardsPaid,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></td>
						</tr>
						<tr>
							<td><strong>Applicants</strong></td>
							<td><?php echo $Applicants;?></td>
						</tr>
						<tr>
							<td><strong>Views</strong></td>
							<td><?php echo $Views;?></td>
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
