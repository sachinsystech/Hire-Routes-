<div style="width:550px;margin:auto;">
<?php require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
<div class="sigup_heading"><u>Register</u></div>
<div>You will be able to apply for jobs and share job posts with your network.</div>
<div>Please submit the form below and you will receive an email confirmation to complete you registration.</div>

<div class="fb"><a href="<?php echo $facebook->getLoginUrl(); ?>"><button class="facebook"></button></a></div>

<div style="width:480px; margin-top:20px;">
<?php echo $form->create('User', array('action' => 'networkerSignup','onsubmit'=>'return checkUserForm()')); ?>

	<?php	echo $form->input('role', array('type' => 'hidden','value'=>'networker'));    ?>

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
<?php if(isset($pwd_error)): ?><div class="error-message"><?php echo $pwd_error;?></div><?php endif; ?>
	<?php	echo $form->input('repeat_password', array('label' => 'Repeat Password',
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'text_field_bg required'
                                           			)
                                 );
    ?>
	<?php
		if($this->Session->read('code')=='' || $this->Session->read('code')==null){
			echo $form->input('Code.code', array('label' => 'Code',
                                           			'type'  => 'text',
													'name'  => "data[Code][code]",
													'class' => 'text_field_bg required'
                                           			)
                                 );
			if(isset($codeErrors)):?><div class="error-message"><?php echo $codeErrors;?></div><?php endif; ?>
	<?  }?>
	<div class="signup_agree_condition">
		<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
															'type'  => 'checkbox',
															'name'  => "data[User][agree_condition]",
															'class' =>'required',
											)
									 );
		?>	
		<?php if(isset($tc_errors)): ?><div class="error-message"><?php echo $tc_errors;?></div><?php endif; ?>
	</div>
	<?php echo $form->submit('Register',array('div'=>false,)); ?>
	<?php echo $form->end(); ?>
</div>

<script>
	$(document).ready(function(){
		$("#UserNetworkerSignupForm").validate({
			  rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  }
			});
	});

</script>

</div>
