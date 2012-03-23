<script> 	
    $(document).ready(function(){               
		$("#PaymentInfoPaymentInfoForm").validate();
    });	

function check_expdate() {
    var currentTime = new Date();

	var month = currentTime.getMonth();	
	var month = parseInt(month)+1;
	var year  = currentTime.getFullYear();
	var selmonth = $("#PaymentInfoExpirationMonth").val();
	var selyear  = $("#PaymentInfoExpirationYear").val();
	
    if ( selyear==year && selmonth <= month){     
      $("#exp_date_error").removeClass().addClass("terms-condition-error").html("Expiry Date should be greater than current date.*");
      return false;
    }
  }
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>
				<li>My Employees</li>
			</ul>
		</div>		
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li class="active">Checkout</li>
			</ul>
			<ul style="float:right">
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		
			<div class="middleBox">
				<div class="checkout_setting_profile">

					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Title:</div>
						<div class="setting_profile_value"><?php echo $job['title'];?></div>
					</div>

					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Reward:</div>
						<div class="setting_profile_value"><?php echo number_format($job['reward'],2,'.','');?><b>$</b></div>
					</div>
			
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Description:</div>
						<div class="setting_profile_value"><?php echo $job['short_description'];?></div>
					</div>

					<div class="setting_profile_row">
						<div style="float:right;margin-right:50px">
							<button class="checkout_pay_button" onclick="paynow();">Pay Now...</button>
						</div>
					</div>
				
				</div>				
			</div>
			
			<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle content list -->

	</div>
	<!-- middle section end -->

</div>
<script>
function paynow(){
	window.location.href="/companies/paypalProPayment/<?php echo $appliedJobId;?>";			
}
</script>
