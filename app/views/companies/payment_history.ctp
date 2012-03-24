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
					<table style="width:100%">
						<tr>
							<td style="text-align:center;"><strong>#</strong></td>
							<td style="text-align:center;"><strong>Transication-Id</strong></td>
							<td style="text-align:center;"><strong>Date</strong></td>
							<td style="text-align:center;width: 25%;"><strong>Payment Amount</strong></td>
						</tr>
						<?php $sn=1;?>
						<?php if(empty($PaymentHistory)){ ?>
						<tr>
							<td colspan="100%">Sorry, No Payment History found.</td>
						</tr>
						<?php } ?>
						<?php foreach($PaymentHistory as $PH):?>	
						<tr>
							<td style="text-align:center;"><?php echo $sn++; ?></td>
							<td style="text-align:center;"><?php echo$this->Html->link($PH['PaymentHistory']['transaction_id'], '/companies/paymentHistoryInfo/'.$PH['PaymentHistory']['id']."/".$PH['PaymentHistory']['transaction_id']); ?></td>
							<td style="text-align:center;"><?php echo $PH['PaymentHistory']['paid_date']; ?></td>
							<td><span style="float: right; margin-right: 30px;"><?php echo number_format($PH['PaymentHistory']['amount'],'2','.',''); ?><b>$</b></span></td>
						</tr>
						<?php endforeach; ?>
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
