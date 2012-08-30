
<script> 	
    $(document).ready(function(){               
		$("#PaymentInfoPaymentInfoForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'170px','width':'230px'});
			}
		});
		
		$("#clear_all").click(function(){ 
			$("input[type=text]").val("");
			$("#PaymentInfoAddress").val("");
			return false;
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
      $("#exp_date_error").removeClass().addClass("expry_date_error").html("Expiry Date should be greater than current date.*");
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
				<div class="job-right-top-left job-profile">
					<h2>PAYMENT INFORMATION</h2>
					<?php echo $this->Form->create('PaymentInfo', array('url' => array('controller' => 'companies', 'action' => 'paymentInfo'),'onsubmit'=>'return check_expdate();')); ?>
					<div class="edit-profile-text-box">

					 <?php echo $form->input('id', array('label' => '',
															'type'  => 'hidden',
															'value' => isset($payment['id'])?$payment['id']:""
															)
										 );
					?>

					<?php	echo $form->input('user_id', array('label' => '',
															'type'  => 'hidden',
															'value' => $user['id']
															)
												 );
					?>
					
					<?php	echo $form->input('applied_job_id', array('label' => '',
															'type'  => 'hidden',
															'value' => isset($appliedJobId)?$appliedJobId:""
															)
												 );
					?>
					</div>
					<!--	====================== Payment Form ===================	-->
					<div class="clr"></div>
					<div class="edit-profile-text-box">							
						<?php	
								echo $form->input('card_type', array('label' => "<span>Card Type</span> ",
											'type'  => 'select',
											'class' => 'text_field_bg required',
											'value' => $payment['card_type'],
											'div'=> false,
											'options' => array('Visa' => 'Visa', 'MC' => 'Mastercard', 'Disc' => 'Discover', 'AmEx' => 'American Express')
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('card_no', array('label' => "<span>Card Number</span> ",
											'type'  => 'text',
											'class' => 'text_field_bg required',
											'value' => $payment['card_no'],
											'maxlength'=>16,
											'maxlength'=>16,
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					<div class="edit-profile-text-box">
						<?php	$year = array();
								$curr_year = date('Y');
								$last_year = $curr_year+10;
								for($i=$curr_year;$i<=$last_year;$i++){
										$year[$i] = $i;
								}

								for($x=0; $x<12; $x++){
									$month = mktime(0, 0, 0, date("01")+$x, date("d"),  date("Y"));
									
									$key = date('n', $month);
									$monthname = date('F', $month);
									$months[$key] = $monthname;
								}
						
								echo $form->input('expiration_month', array('label' => "<span class='cc_expiray_date'>Expiry Date</span> ",
											'type'  => 'select',
											'class' => 'required cr_expire_month payment_month cc_exp_month',
											'value' => $payment['expiration_month'],
											'options' => $months,
											'div'=> false,												
											)
								);
								echo $form->input('expiration_year', array('label' => '',
											'type'  => 'select',
											'class' => 'expiry cr_expire_year payment_year cc_exp_yr',
											'value' => $payment['expiration_year'],
											'options' => $year,
											'div'=> false,	
											)
								);
						?>
					</div>
					<div class="clr"></div>
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('ccv_code', array('label' => "<span>CCV Code</span> ",
											'type'  => 'text',
											'class' => 'number required',
											'value' => $payment['ccv_code'],
											'minlength'=>3,
											'maxlength'=>4,
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('cardholder_name', array('label' => "<span>Card Holder's Name</span> ",
											'type'  => 'text',
											'class' => 'required alphabets',
											'value' => $payment['cardholder_name'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('address', array('label' => "<span>Address</span> ",
											'type'  => 'textarea',
											'class' => 'required cc_address',
											'value' => $payment['address'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('city', array('label' => "<span>City</span> ",
											'type'  => 'text',
											'class' => 'required',
											'value' => $payment['city'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('state', array('label' => "<span>State</span> ",
											'type'  => 'text',
											'class' => 'required',
											'value' => $payment['state'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('zip', array('label' => "<span>Zip</span> ",
											'type'  => 'text',
											'class' => 'required',
											'value' => $payment['zip'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('country', array('label' => "<span>Country</span> ",
											'type'  => 'text',
											'class' => 'required',
											'value' => $payment['country'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-clear-all">
						<label id="clear_all">Clear All</label>
					</div>
					<div class="save-profile-button">
						<?php echo $form->submit($submit_txt,array('div'=>false,)); ?>
					</div>
					<?php echo $form->end(); ?>	
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="job_pagination_bottm_bar"></div>
	<div class="clr"></div>
</div>
