<div style="width:550px;margin:auto;">
<?php require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
<div style="font-weight:bold;font-size: 20px; "><u>Register</u></div>
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
		$("#UserJobseekerSignupForm").validate({
			  rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  }
			});
	});
</script>
<div style="width:480px; margin-top:20px;">
<?php echo $form->create('User', array('action' => 'jobseekerSignup','onsubmit'=>'return checkUserForm()')); ?>

	<?php	echo $form->input('role', array('type' => 'hidden','value'=>'jobseeker'));    ?>

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
													'class' => 'text_field_bg required'
                                           			)
                                 );
    ?>
	
	<?php	
		if($this->Session->read('code')=="" || $this->Session->read('code')==null){
			echo $form->input('Code.code', array('label' => 'Code',
                                           			'type'  => 'text',
													'name'  => "data[Code][code]",
													'class' => 'text_field_bg required'
                                           			)
                              );	
		}
    ?>
	<?php if(isset($codeErrors)): ?><div class="error-message"><?php echo $codeErrors;?></div><?php endif; ?>
	<div style="margin-top:15px;">
	<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
                                           			'type'  => 'checkbox',
													'name'  => "data[User][agree_condition]",
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
</div>
