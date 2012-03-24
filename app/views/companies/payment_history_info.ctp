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
					<div>PAYMENT INFO ::</div>
					<div class="payment_info" style="width:400px;margin-left:50px">
						<div style="clear:both">							
							<div style="float:left">Transaction-Id:</div>
							<div style="float:right"><?php echo $PaymentDetail['PaymentHistory']['transaction_id']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left">Date:</div>
							<div style="float:right"><?php echo $PaymentDetail['PaymentHistory']['paid_date']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left">Reward(Amout):</div>
							<div style="float:right"><?php echo number_format($PaymentDetail['PaymentHistory']['amount'],'2','.',''); ?><b>$</b></div>
						</div>
					</div>
					<div style="clear:both">JOB ::</div>
					<div class="job_info" style="width:400px;margin-left:50px">
						<div style="clear:both">							
							<div style="float:left">Jobseeker Name:</div>
							<div style="float:right"><?php echo $PaymentDetail['j_setting']['name']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left">Title:</div>
							<div style="float:right"><?php echo $PaymentDetail['job']['title']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left">Description:</div>
							<div style="float:right"><?php echo $PaymentDetail['job']['short_description']; ?></div>
						</div>
						
						<div style="clear:both">							
							<div style="float:left">Industry:</div>
							<div style="float:right"><?php echo $jobInfo['ind']['name'].", ".$jobInfo['spec']['name']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left">Location:</div>
							<div style="float:right"><?php echo $jobInfo['state']['state'].", ".$jobInfo['city']['city']; ?></div>
						</div>
					</div>
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
