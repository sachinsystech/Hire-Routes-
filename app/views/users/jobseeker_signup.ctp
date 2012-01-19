<?php require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>

<div style="font-weight:bold;font-size: 20px; ">Register</div>
<div>You will be able to apply for jobs and share job posts with your network.</div>
<div>Please submit the form below and you will receive an email confirmation to complete your registration.</div>

<div class="facebook-login">
	<div><a href="<?php echo $facebook->getLoginUrl(); ?>"><button class="facebook"></button></a></div>
	<?php /*	if($facebookUser): ?>
		<div><a href="<?php echo $FBlogoutUrl; ?>">Logout</a></div>
	<?php else: ?>
		<div><a href="<?php echo $FBloginUrl; ?>"><button class="facebook"></button></a></div>
	<?php endif */?>
<div>
<script>
	$(document).ready(function(){
		$("#UsersJobseekerSignupForm").validate({
			  rules: {
				'data[Users][password]': "required",
				'data[Users][repeat_password]': {
				  equalTo: "#UsersPassword"
				}
			  }
			});
	});
</script>
<div style="width:480px; margin-top:20px;">
<?php echo $form->create('Users', array('action' => 'jobseekerSignup','onsubmit'=>'return checkUserForm()')); ?>

	<?php	echo $form->input('role', array('type' => 'hidden','value'=>'jobseeker'));    ?>

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
<div style="margin-top:15px;">
	
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
		<?php echo $form->submit('Register',array('div'=>false,)); ?>
	</div>
	<?php echo $form->end(); ?>
</div>

