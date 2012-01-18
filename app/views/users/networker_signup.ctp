<?php require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
<<<<<<< HEAD
<div class="sigup_heading">Register</div>
=======

<div style="font-weight:bold;font-size: 20px; ">Register</div>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
<div>You will be able to apply for jobs and share job posts with your network.</div>
<div>Please submit the form below and you will receive an email confirmation to complete you registration.</div>

<div class="facebook-login">
<<<<<<< HEAD
	<a href="<?php echo $facebook->getLoginUrl(); ?>"><button class="facebook"></button></a>
<div>

<div class="sigup_form" >
=======
	<div><a href="<?php echo $facebook->getLoginUrl(); ?>"><button class="facebook"></button></a></div>
	<?php /*	if($facebookUser): ?>
		<div><a href="<?php echo $FBlogoutUrl; ?>">Logout</a></div>
	<?php else: ?>
		<div><a href="<?php echo $FBloginUrl; ?>"><button class="facebook"></button></a></div>
	<?php endif */?>
<div>

<script>
	$(document).ready(function(){
		$("#UsersNetworkerSignupForm").validate({
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
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
<?php echo $form->create('Users', array('action' => 'networkerSignup','onsubmit'=>'return checkUserForm()')); ?>

	<?php	echo $form->input('role', array('type' => 'hidden','value'=>'networker'));    ?>

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
	<div class="signup_agree_condition">
	
		<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
=======
<div style="margin-top:15px;">
	
	<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
		                                       			'type'  => 'checkbox',
														'name'  => "data[Users][agree_condition]",
														'class' =>'required',
                              			)
                                 );
<<<<<<< HEAD
    	?>
    	<?php if(isset($errors)): ?>
		<div class="error-message"><?php echo $errors;?></div>
	 	<?php endif; ?>
			<?php 	echo $form->submit('Register',array('div'=>false,));?>
		<?php echo $form->end(); ?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#UsersNetworkerSignupForm").validate({
			  rules: {
				'data[Users][password]': "required",
				'data[Users][repeat_password]': {
				  equalTo: "#UsersPassword"
				}
			  }
			});
	});
</script>

=======
    ?>
    
<div>
 <?php if(isset($errors)): ?>
    <div class="error-message"><?php echo $errors;?></div>
 <?php endif; ?>
</div>
    
<div>
<div>
	<?php 	echo $form->submit('Register',array('div'=>false,));
	?>
</div>
<?php echo $form->end(); ?>
</div>

<script>
    function checkUserForm(){
		/*if(document.getElementById('UsersAgreeCondition').checked==""){
			alert("Select Terms and Conditions ");
	        return false;
		}*/
	}

	function loginViaFacebook(){
		window.location.href = "https://www.facebook.com/dialog/oauth?client_id=290012484379367&redirect_uri=http://localhost:80/hireroutes";
	} 
</script>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
