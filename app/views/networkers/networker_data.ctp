<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/"><span>My Account</span></a></li>
			</ul>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle content top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>Personal</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/addContacts"><span>Add Contact(s)</span></a></li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/networkerData"><span>Data</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		
			<div class="network_contact_middleBox">
			  <div class="job_data">
					<table>	
						<tr>
							<td colspan="2">All Networkers</td>
						</tr>
						<tr>
							<td><strong>Total</strong></td>
							<td><?php echo array_sum($networkerData);?></td>
						</tr>
						<?php foreach($networkerData as $degree=>$totalNetworkers){?>
						<tr>
							<td><?php echo $degree+1;?></td>
							<td><?php echo $totalNetworkers;?></td>
						</tr>
						<?php }?>						
					</table>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
