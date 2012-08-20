<script>
  function checkform() {
    var isAgreeCondition = $('input:checkbox[id=UserAgreeCondition]:checked').val();
    if(!isAgreeCondition){
      $("#agree_condition_error").removeClass().addClass("error").html("This is required field.");
      return false;
    }
    if(isAgreeCondition){
      $("#agree_condition_error").removeClass().html("");  
    }
  }
  $(document).ready(function(){
		$("#UserCompanyRecruiterSignupForm").validate({
			  errorClass: 'error_input_message',
			  rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  }
			});
  		
		/*
		$('[_placeholder]').focus(function() {
		  var input = $(this);
		  if (input.val() == input.attr('_placeholder')) {
			input.val('');
			input.removeClass('_placeholder');
		  }
		}).blur(function() {
		  var input = $(this);
		  if (input.val() == '' || input.val() == input.attr('_placeholder')) {
			input.addClass('_placeholder');
			input.val(input.attr('_placeholder'));
		  }
		}).blur().parents('form').submit(function() {
		  $(this).find('[_placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('_placeholder')) {
			  input.val('');
			}
		  })
		});
		*/
	  
  });
      
</script>
 <h1 class="title-emp">Companies/Recruiters Registration Request</h1>
    <div class="sub-title-cs">Please fill the registration request below, we will analyze your data and get back with in next 24 hours.</div>
    
<?php echo $form->create('User', array('action' => 'companyRecruiterSignup','onsubmit'=>'return checkform();')); ?>

    
	<div class="company-recruiter-checkbox">
		<div class="cross-button bottom-margin">
			<input id="CompaniesRoleCompany" name="data[Companies][role]" type="radio" value="" class = 'required'/>
		</div>
		<div class="comp-recruiter-text">I'm a Company</div>
		<div class="clr"></div>
		<div class="cross-button bottom-margin">
			<input id="CompaniesRoleRecruiter" name="data[Companies][role]" type="radio" value="" class='required'/>
		</div>
		<div class="comp-recruiter-text">I'm a Recruiter</div>
	</div>
    
    
    
	<div class="text-box"> 
	<?php	echo $form->input('Companies.company_name', array('label' => false,
                                           			'type'  => 'text',
                                           			'div' 	=>false,
													'class' => 'required alphabets',
													'minlength' => '3',
													'placeholder'=>'Company/Recruiter Name',
                                           			)
                                 );
    ?>
	</div>
	<div class="text-box text-box-below">
	<?php	echo $form->input('Companies.contact_name', array('label' => false,
                                           			'type'  => 'text',
                                           			'div'	=> false,
													'class' => 'required alphabets',
													'minlength' => '3',
													'placeholder'=>'Contact Name',
													'value' =>"",													
                                           			)
                                 );
    ?>
	</div>
	<div class="text-box text-box-below">
	<?php	echo $form->input('Companies.contact_phone', array('label' => false,
                                           			'type'  => 'text',
                                           			'div'	=>false,
													'class' => 'required number',
													'minlength' => '10',
													'placeholder'=>'Contact Phone',
													'value' =>"",
                                           			)
                                 );
    ?>
    </div>
    <div class="text-box text-box-below">
    <?php	echo $form->input('Companies.company_url', array('label' => false,
                                           			'type'  => 'text',
                                           			'div'=> false,
													'class' => 'url',
													'minlength' => '8',
													'placeholder'=> 'Company Website',
													'value' =>"",													
                                           			)
                                 );
    ?>
	</div>
	<div class="text-box text-box-below">
	<?php	echo $form->input('account_email', array('label' => false,
                                           			'type'  => 'text',
                                           			'div' 	=>false,
													'class' => 'required email',
													'placeholder'=> 'Account Email',
													'value' =>"",													
                                           			)
                                 );
    ?>
	</div>
	<div class="text-box text-box-below">
	<?php	echo $form->input('password', array('label' => false,
                                           			'type'  => 'password',
                                           			'div'	=> false,
													'name'  => "data[User][password]",
													'class' => 'password',
													'minlength' => '6',
													'placeholder'=> 'Password',
                                           			)
                                 );
    ?>
	</div>
	<div class="text-box text-box-below">
	<?php	echo $form->input('repeat_password', array('label' => false,
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'required',
													'div' => false,
													'placeholder'=> 'Repeat Password',
                                           			)
                                 );
    ?>
	</div>
	
		<div class="check-button">
    	<div class="cross-button">
		<?php	echo $form->input('agree_condition', array('label' => false,
		                                       			'type'  => 'checkbox',
														'name'  => "data[User][agree_condition]",
														'div' =>false,
		                                       			)
		                             );
		?>
		</div>
		<div class="remember-me agree-with">Agree with <a href="#">Terms & Conditions</a></div>
		<div id="agree_condition_error"></div>
		<?php if(isset($errors)): ?>
		 	<div class="error-message" ><?php echo $errors;?></div>
		<?php endif; ?>
	</div>
	<div class="login-button">
    	<input type="submit" value="SEND REQUEST"/>
    	<div class="clr"></div>
    </div>
    <?php echo $form->end(); ?>	
	<div class="forgot-password dont-know-width"><a href="/companyInformation">Don't know about Companies/Recruiters?</a></div>

