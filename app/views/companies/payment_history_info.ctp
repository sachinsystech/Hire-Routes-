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
					<div style="font-weight: bold;margin:10px;"><u>PAYMENT INFO</u> ::</div>
					<div class="payment_info" style="width:500px;margin-left:50px">
						<div style="clear:both;">							
							<div style="float:left;font-weight: bold;width: 130px;">Transaction-Id:</div>
							<div style="float:left"><?php echo $PaymentDetail['PaymentHistory']['transaction_id']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Date & Time:</div>
							<div style="float:left"><?php echo $this->Time->format('m/d/Y H:i:s',$PaymentDetail['PaymentHistory']['paid_date']); ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Reward(Amout):</div>
							<div style="float:left"><?php echo number_format($PaymentDetail['PaymentHistory']['amount'],'2','.',''); ?><b>$</b></div>
						</div>
					</div>
					<div style="clear:both;margin-left: 45px;margin-top: 35px;width: 410px;"><hr/></div>
					<div style="clear:both;font-weight: bold;margin:10px;"><u>JOB INFO</u> ::</div>
					<div class="job_info" style="width:500px;margin-left:50px">
						<?php if(!empty($PaymentDetail['js']['contact_name'])):?>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Jobseeker Name:</div>
							<div style="float:left"><?php echo $PaymentDetail['js']['contact_name']; ?></div>
						</div>
						<?php endif;?>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Title:</div>
							<div style="float:left"><?php echo $PaymentDetail['job']['title']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Description:</div>
							<div style="float:left"><?php echo $PaymentDetail['job']['short_description']; ?></div>
						</div>
						
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Industry:</div>
							<div style="float:left"><?php echo $jobInfo['ind']['name'].", ".$jobInfo['spec']['name']; ?></div>
						</div>
						<div style="clear:both">							
							<div style="float:left;font-weight: bold;width: 130px;">Location:</div>
							<div style="float:left"><?php echo $jobInfo['state']['state'].", ".$jobInfo['city']['city']; ?></div>
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
