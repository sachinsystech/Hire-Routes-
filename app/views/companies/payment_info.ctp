
<script> 	
    $(document).ready(function(){               
		$("#PaymentInfoPaymentInfoForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'150px','width':'230px'});
			}
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
				<div class="payment_form">
                    
					<?php echo $this->Form->create('PaymentInfo', array('url' => array('controller' => 'companies', 'action' => 'paymentInfo'),'onsubmit'=>'return check_expdate();')); ?>
						<div>
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
						<div>
							<?php	echo $form->input('card_type', array('label' => 'Card Type',
												'type'  => 'select',
												'class' => 'payment_ctype',
												'value' => $payment['card_type'],
												'options' => array('Visa' => 'Visa', 'MC' => 'Mastercard', 'Disc' => 'Discover', 'AmEx' => 'American Express')
												)
								 );
							?>
						</div>
						<div style="clear:both"></div>
												
						<div>
							<?php	echo $form->input('card_no', array('label' => 'Card Number',
												'type'  => 'text',
												'class' => 'payment_text_field required creditcard',
												'value' => $payment['card_no'],
												'maxlength'=>16,
												'maxlength'=>16
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
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
							?>
							<div style="float:left">
								<?php
									echo $form->input('expiration_month', array('label' => 'Expiry Date',
												'type'  => 'select',
												'class' => 'cr_expire_month payment_month',
												'value' => $payment['expiration_month'],
												'options' => $months
												)
									);
								?>
							</div>
							<div style="float:left" class="cr_pi_year">
								<?php
									echo $form->input('expiration_year', array('label' => '',
												'type'  => 'select',
												'class' => 'expiry cr_expire_year payment_year',
												'value' => $payment['expiration_year'],
												'options' => $year
												)
									);
								?>
							</div>	
							<div id="exp_date_error"></div>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('ccv_code', array('label' => "CCV Code",
												'type'  => 'text',
												'class' => 'payment_text_field required number',
												'value' => $payment['ccv_code'],
												'minlength'=>3,
												'maxlength'=>4,
												)
								 );
							?>
						</div>
						
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('cardholder_name', array('label' => "Card Holder's Name",
												'type'  => 'text',
												'class' => 'payment_text_field required alphabets',
												'value' => $payment['cardholder_name'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('address', array('label' => "Address",
												'type'  => 'textarea',
												'class' => 'payment_textarea_field required',
												'value' => $payment['address'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('city', array('label' => "City",
												'type'  => 'text',
												'class' => 'payment_text_field required',
												'value' => $payment['city'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('state', array('label' => "State",
												'type'  => 'text',
												'class' => 'payment_text_field required',
												'value' => $payment['state'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('zip', array('label' => "Zip",
												'type'  => 'text',
												'class' => 'payment_text_field required',
												'value' => $payment['zip'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('country', array('label' => "Country",
												'type'  => 'text',
												'class' => 'payment_text_field required',
												'value' => $payment['country'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div >
							<div style="float:right;">

								<?php echo $form->submit($submit_txt ,array('div'=>false,)); ?>	
							</div>
						</div>
						<div style="clear:both"></div>						

					<?php echo $form->end(); ?>
				<!--	==================== End Payment Form =================	-->
						
				</div>				
			</div>
			
			<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
