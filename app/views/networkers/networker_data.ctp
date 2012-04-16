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
			<div class="middleBox">
				<div class="setting_profile">
					<?php if(count($networkerData)>0){ ?>
					<div class="setting_profile_row">
						<div class="nr_data_field">All Networkers:</div>
						<div class="nr_data_value"></div>
					</div>
					<div class="setting_profile_row">
						<div class="nr_data_field">Total:</div>
						<div class="nr_data_value"><?php echo array_sum($networkerData);?></div>
					</div>
					<?php foreach($networkerData as $degree=>$totalNetworkers){?>
					<div class="setting_profile_row">
						<div class="nr_data_field"><?php	$networkDegree = $degree+1;
									  	if($networkDegree==1){
											$suffix = "st";
									  	}elseif($networkDegree==2){
											$suffix = "nd";
									  	}elseif($networkDegree==3){
											$suffix = "rd";
									  	}else{
											$suffix = "th";
									  	}
										echo $networkDegree."<sup>".$suffix."<sup>&omicron;</sup></sup>:";?></div>
						<div class="nr_data_value" style="margin-top:10px">
							<?php echo $totalNetworkers;?>
						</div>
					</div>
					<?php }} else{?>
							<div class="empty_concats_msg"> No Data To Show..</div>
			  		<?php }?>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
