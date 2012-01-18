<<<<<<< HEAD
=======
<?php echo $this->Session->flash(); ?>

<?php echo $session->flash(); ?>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
<script>
	$(document).ready(function(){
		$("#UsersCompanyRecruiterSignupForm").validate({
			  rules: {
				'data[Users][password]': "required",
				'data[Users][repeat_password]': {
				  equalTo: "#UsersPassword"
				}
			  }
			});
	});
<<<<<<< HEAD
    
  function checkform() {
    var isAgreeCondition = $('input:checkbox[id=UsersAgreeCondition]:checked').val();
    if(!isAgreeCondition){
      $("#agree_condition_error").removeClass().addClass("terms-condition-error").html("This is required field.");
      return false;
    }
    if(isAgreeCondition){
      $("#agree_condition_error").removeClass().html("");  
    }
  }
      
=======
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
</script>
<div class="sigup_heading">Companies/Recruiters  Registration Request</div>

<div class="sigup_head_description">Please fill the registration request below, we will analyze your data and get back with in next 24 hours.</div>
<div class="sigup_form" >
<<<<<<< HEAD
<?php echo $form->create('Users', array('action' => 'companyRecruiterSignup','onsubmit'=>'return checkform();')); ?>
	<?php  echo $form -> input('role',array(
                                                 'before' => '<strong style="font-weight:bold">',
=======
<?php echo $form->create('Users', array('action' => 'companyRecruiterSignup')); ?>

<div class="form_content">
	<?php  echo $form -> input('role',array( 'before' => '<strong style="font-weight:bold">',
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
                                                 'after' => '</strong>',
                                                 'legend' => false,
                                                 'type'=>'radio',
                                                 'class' => 'required',
<<<<<<< HEAD
                                                 'label'=>'',
=======
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
                                                 'options'=>array('company'=>"I'm a company",'recruiter'=>"I'm a recruiter"),
										),
										array('checked'=>0)
							);
    ?>
<<<<<<< HEAD
=======
</div>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67

	<?php	echo $form->input('Companies.company_name', array('label' => 'Company / Recruiter Name',
                                           			'type'  => 'text',
													'class' => 'text_field_bg'
                                           			)
                                 );
    ?>

	<?php	echo $form->input('Companies.contact_name', array('label' => 'Contact Name',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required alphabets',
<<<<<<< HEAD
													'minlength' => '3',
=======
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
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

	<?php	echo $form->input('account_email', array('label' => 'Account Email',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required email',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('password', array('label' => 'Password',
                                           			'type'  => 'password',
													'name'  => "data[Users][password]",
													'class' => 'text_field_bg password',
													'minlength' => '6',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('repeat_password', array('label' => 'Repeat Password',
                                           			'type'  => 'password',
													'name'  => "data[Users][repeat_password]",
													'class' => 'text_field_bg'
                                           			)
                                 );
    ?>
<<<<<<< HEAD

	<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
                                           			'type'  => 'checkbox',
													'name'  => "data[Users][agree_condition]",
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
=======
<div class="signup_agree_condition">
	<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
                                           			'type'  => 'checkbox',
													'name'  => "data[Users][agree_condition]",
													'class' => 'required',
                                           			)
                                 );
    ?>
    
<div>
 <?php if(isset($errors)): ?>
    <div class="error-message"><?php echo $errors;?></div>
 <?php endif; ?>
</div>
	
<div>
<div>
	<?php 	echo $form->submit('Send A Request',array('div'=>false,));
	?>
</div>
<?php echo $form->end(); ?>
</div>

<script>
    function checkUserForm(){
		if(document.getElementById('UsersRoleCompany').checked=="" && document.getElementById('UsersRoleRecruiter').checked==""){
			alert("Please select Role: \"I'm a company/I'm a recruiter\" ");
			return false;
		}
		
	}
		
</script>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
