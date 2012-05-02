<script> 	
    $(document).ready(function(){               
		$("#PaymentInfoPaymentInfoForm").validate();
				
		$('button').click(function(){
			$('button').attr('disable',true);
			$( "#submit-dialog-modal" ).dialog({
				height: 0,
				modal: true
			});
			$("div").removeClass("ui-dialog-titlebar-close ui-corner-all ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-resizable-handle ui-resizable-e ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se ui-dialog-titlebar-close ui-corner-all ui-icon ui-icon-closethick ui-widget-content ui-resizable-n").
			addClass('test');
		
			$(".ui-dialog-titlebar-close ui-corner-all").remove("a");
			$(".ui-icon").remove("span");
		
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

<div id="submit-dialog-modal" role="dialog" >
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
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
