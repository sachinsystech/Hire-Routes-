<?php ?>
<script> 	
    $(document).ready(function(){               
		$("#PaymentInfoPaymentInfoForm").validate();
		$('#payementButton').click(function(){
			$('#payementButton').attr('disabled','disabled');
			$( "#submit-dialog-modal" ).dialog({
				height: 100,
				width: 400,
				modal: true,
				resizable: false,
			});
			
			//$(".ui-dialog").css({'border':" none !important",'width':'400px','overflow':"visible",'z-index':"997"});
			$(".ui-dialog-titlebar").hide();     
			$("a.ui-dialog-titlebar-close").remove();
			$('#submit-dialog-modal').css({'color':'#ff0000','text-align':'center'});
			$('#submit-dialog-modal').html('Please wait..., don\'t press back or refresh page.\n Your transaction being proceed.');
		});
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
			<?php echo $this->element('side_menu');?>
		</div>		
	</div>

<div id="submit-dialog-modal" role="dialog" style="display:none;">
	
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
				<div class="checkout_setting_profile">
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Job Title:</div>
						<div class="setting_profile_value"><?php echo $job['title'];?></div>
					</div>

					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Reward:</div>
						<div class="setting_profile_value"><?php echo "<b>$</b>".number_format($job['reward'],2,'.','');?></div>
					</div>
			
					<div class="setting_profile_row">
						<div class="cr_setting_profile_field">Description:</div>
						<div class="setting_profile_value"><?php echo $job['short_description'];?></div>
					</div>

					<div class="setting_profile_row">
						<div style="float:right;margin-right:50px">
							<button id ="payementButton" class="checkout_pay_button" onclick="paynow();">Pay Now...
							</button>
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
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
