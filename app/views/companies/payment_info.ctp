<script>  
	
	
	function checkValidForm(){
        type = document.getElementById("PaymentCardType").value;
		ccnum = document.getElementById("PaymentCardNo").value;	
		expdate = document.getElementById("PaymentExpirationDate").value;
		cardname = document.getElementById("PaymentCardholderName").value;	
		address = document.getElementById("PaymentAddress").value;	
		city = document.getElementById("PaymentCity").value;	
		state = document.getElementById("PaymentState").value;	
		zip = document.getElementById("PaymentZip").value;	
		country = document.getElementById("PaymentCountry").value;	
		email = document.getElementById("PaymentEmail").value;	

             
			validCard = isValidCreditCard(type, ccnum);
        	if(validCard==false)
        	return false;
		
	}

	function isValidCreditCard(type, ccnum){
	if (type == "Visa") {
        	// Visa: length 16, prefix 4, dashes optional.
        	var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
        } else if (type == "MC") {
        	// Mastercard: length 16, prefix 51-55, dashes optional.
            var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
   		} else if (type == "Disc") {
      		// Discover: length 16, prefix 6011, dashes optional.
      		var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
   		} else if (type == "AmEx") {
      		// American Express: length 15, prefix 34 or 37.
      		var re = /^3[4,7]\d{13}$/;
   		} else if (type == "Diners") {
      		// Diners: length 14, prefix 30, 36, or 38.
      		var re = /^3[0,6,8]\d{12}$/;
   		}
        
   		if (!re.test(ccnum)){
		document.getElementById("error_ccnum").innerHTML = "<font color='red'>Please Enter Valid Card Number.</font>";
        return false;
		}
   			// Remove all dashes for the checksum checks to eliminate negative numbers
   		ccnum = ccnum.split("-").join("");
   			// Checksum ("Mod 10")
   			// Add even digits in even length strings or odd digits in odd length strings.
   		var checksum = 0;
   		for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
     		checksum += parseInt(ccnum.charAt(i-1));
   		}
   			// Analyze odd digits in even length strings or even digits in odd length strings.
   		for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
      	var digit = parseInt(ccnum.charAt(i-1)) * 2;
      	if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   		}
   		if ((checksum % 10) == 0){ 
		}else{
		document.getElementById("error_ccnum").innerHTML = "<font color='red'>Please Enter Valid Card Number.</font>";
        return false;
		}
	}
	
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
					<?php echo $this->Form->create('Payment', array('url' => array('controller' => 'companies', 'action' => 'paymentInfo'),'onsubmit'=>'return checkValidForm()')); ?>
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
							<?php	echo $form->input('card_type', array('label' => 'Card Type *',
												'type'  => 'select',
												'class' => '',
												'value' => $payment['card_type'],
												'options' => array('Visa' => 'Visa', 'MC' => 'Mastercard', 'Disc' => 'Discover', 'AmEx' => 'American Express')
												)
								 );
							?>
						</div><span id="error_type"></span>		
						<div style="clear:both"></div>
												
						<div>
							<?php	echo $form->input('card_no', array('label' => 'Card Number *',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $payment['card_no'],
												)
								 );
							?><span id="error_ccnum"></span>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('expiration_date', array('label' => 'Expiration Date *',
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['expiration_date'],

												)
								 );
							?>
						</div><span id="error_date"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('cardholder_name', array('label' => "Card Holder's Name *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['cardholder_name'],

												)
								 );
							?>
						</div><span id="error_cardname"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('address', array('label' => "Address *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['address'],

												)
								 );
							?>
						</div><span id="error_address"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('city', array('label' => "City *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['city'],

												)
								 );
							?>
						</div><span id="error_city"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('state', array('label' => "State *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['state'],

												)
								 );
							?>
						</div><span id="error_state"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('zip', array('label' => "Zip *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['zip'],

												)
								 );
							?>
						</div><span id="error_zip"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('country', array('label' => "Country *",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $payment['country'],

												)
								 );
							?>
						</div><span id="error_country"></span>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('email', array('label' => 'Email *',
												'type'  => 'text',
												'class' => 'text_field_bg required email',
												'value' => $payment['email'],

												)
								 );
							?>
						</div><span id="error_email"></span>
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
