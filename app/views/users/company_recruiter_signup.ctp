<div style="width:550px;margin:auto;">
<script>
	$(document).ready(function(){
		$("#UserCompanyRecruiterSignupForm").validate({
			  rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  }
			});
	});
    
  function checkform() {
    var isAgreeCondition = $('input:checkbox[id=UserAgreeCondition]:checked').val();
    if(!isAgreeCondition){
      $("#agree_condition_error").removeClass().addClass("terms-condition-error").html("This is required field.");
      return false;
    }
    if(isAgreeCondition){
      $("#agree_condition_error").removeClass().html("");  
    }
  }
      
</script>
<div class="sigup_heading"><u>Companies/Recruiters  Registration Request</u></div>

<div class="sigup_head_description">Please fill the registration request below, we will analyze your data and get back with in next 24 hours.</div>
<div class="sigup_form" >
<?php echo $form->create('User', array('action' => 'companyRecruiterSignup','onsubmit'=>'return checkform();')); ?>
	<?php  echo $form -> input('Companies.role',array(
                                                 'before' => '<strong style="font-weight:bold">',
                                                 'after' => '</strong>',
                                                 'legend' => false,
                                                 'type'=>'radio',
                                                 'class' => 'required',
                                                 'label'=>'',
                                                 'options'=>array('company'=>"I'm a company",'recruiter'=>"I'm a recruiter"),
										),
										array('checked'=>0)
							);
    ?>
    <div></div>
	<?php	echo $form->input('Companies.company_name', array('label' => 'Company / Recruiter Name',
                                           			'type'  => 'text',
													'class' => 'text_field_bg'
                                           			)
                                 );
    ?>

	<?php	echo $form->input('Companies.contact_name', array('label' => 'Contact Name',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required alphabets',
													'minlength' => '3',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('Companies.contact_phone', array('label' => 'Contact Phone',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required number',
													'minlength' => '10',
													
                                           			)
                                 );
    ?>
    <?php	echo $form->input('Companies.company_url', array('label' => 'Company Website',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required url',
													'minlength' => '8',
													
                                           			)
                                 );
    ?>

	<?php	echo $form->input('account_email', array('label' => 'Account Email',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required email',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('password', array('label' => 'Password',
                                           			'type'  => 'password',
													'name'  => "data[User][password]",
													'class' => 'text_field_bg password',
													'minlength' => '6',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('repeat_password', array('label' => 'Repeat Password',
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'text_field_bg'
                                           			)
                                 );
    ?>

	<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
                                           			'type'  => 'checkbox',
													'name'  => "data[User][agree_condition]",
                                           			)
                                 );
    ?>
    <div id="agree_condition_error"></div>
    <?php if(isset($errors)): ?>
      <div class="error-message"><?php echo $errors;?></div>
    <?php endif; ?>
    <?php echo $form->submit('Send A Request',array('div'=>false,)); ?>
    <?php echo $form->end(); ?>	
</div>
<div style="margin-top:50px;"><a href="/companyInformation">Don't know about Company/Recruiters</a> </div>
</div>
