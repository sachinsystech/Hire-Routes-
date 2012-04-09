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
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		
			<div class="network_contact_middleBox">
			  <div class="job_data">
					<table>	
						<tr>
							<td><strong>Job Received</strong></td>
							<td><?php echo $NewJobs;?></td>
						</tr>
						<tr>
							<td><strong>Job Shared</strong></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Job Filled</strong></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Rewards</strong></td>
							<td><?php echo $this->Number->format(
										$TotalReward,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></td>
						</tr>													
					</table>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
