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
	
	
	<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
           <?php echo $this->element('side_menu');?>
            <div class="job_right_bar">
            	<div class="job-right-top-content1">
                    <div class="job-right-top-left">
                       	<h2>CHECKOUT</h2>
                        <div class="co_container">
                        	<p>Jobseeker:<span> </span></p>
                            <p>Job Title:<span><?php echo $job['title'];?></span></p>
                            <p>Reward:<span><?php echo "<b>$</b>".number_format($job['reward'],2,'.','');?></span></p>
                            <p>Description:<span><?php echo $job['short_description'];?></span></p>
                            <div class="clr"></div>
                        </div>
                        <div class="network_register_bttn post_job_left">
                            <input type="submit" value="PAY NOW" id ="payementButton" class="checkout_pay_button" onclick="paynow();">
								
                        </div>
                       
                    </div>
                </div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="job_pagination_bottm_bar"></div>
		<div class="clr"></div>
	</div>
	
	
<script>
function paynow(){
	window.location.href="/companies/paypalProPayment/<?php echo $appliedJobId;?>";			
}
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
