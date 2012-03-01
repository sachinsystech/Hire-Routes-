<script> 	
    $(document).ready(function(){
  		$("#PaymentPaymentInfoForm").validate();
    });	
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li>My Network</li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>

				<li>My Employees</li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li>Profile</li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentInfo">Payment Info</a></li>
				<li>Payment History</li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		
			<div class="middleBox">
				<div class="company_edit_form">
                    
					<?php echo $this->Form->create('PaymentInfo', array('url' => array('controller' => 'companies', 'action' => 'paymentInfo'))); ?>
						<div>
                            <?php echo $form->input('id', array('label' => 'Your Name ',
																	'type'  => 'hidden',
																	'value' => isset($payment['id'])?$payment['id']:""
																	)
												 );?>

							<?php	echo $form->input('user_id', array('label' => 'User Id',
																	'type'  => 'hidden',
																	'value' => $user['id']
																	)
														 );?>
         
						</div>						
						<div style="clear:both"></div>
						
						<div>
							<?php	echo $form->input('card_type', array('label' => 'Card Type',
												'type'  => 'select',
												'class' => '',
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
												'class' => 'text_field_bg required creditcard',
												'value' => $payment['card_no'],
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('expiration_date', array('label' => 'Expiration Date',
												'type'  => 'text',
												'class' => 'text_field_bg required date',
												'minlength' => '10',
												'value' => $payment['expiration_date'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('cardholder_name', array('label' => "Card Holder's Name",
												'type'  => 'text',
												'class' => 'text_field_bg required alphabets',
												'value' => $payment['cardholder_name'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('address', array('label' => "Address",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['address'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('city', array('label' => "City",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['city'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('state', array('label' => "State",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['state'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('zip', array('label' => "Zip",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['zip'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('country', array('label' => "Country",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['country'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('email', array('label' => 'Email',
												'type'  => 'text',
												'class' => 'text_field_bg required email',
												'value' => $payment['email'],

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div class="company_profile_field_row">
							<div style="float:right;margin-top:20px">
								<?php echo $form->submit('Save Changes',array('div'=>false,)); ?>	
							</div>
						</div>
						<div style="clear:both"></div>						

					<?php echo $form->end(); ?>	
				</div>				
			</div>
			
			<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
