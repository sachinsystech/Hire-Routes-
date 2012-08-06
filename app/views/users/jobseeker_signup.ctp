<script>
	$(document).ready(function(){
		$("#UserJobseekerSignupForm").validate({
			  errorClass: 'error_input_message',
			  rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  },
			});
	});
	
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
</script>

<div style="width:550px;margin:auto;">
<?php //require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
<div style="font-weight:bold;font-size: 20px; "><u>Register</u></div>
<div>You will be able to apply for jobs and share job posts with your network.</div>
<div>Please submit the form below and you will receive an email confirmation to complete your registration.</div>

<div class="facebook-login">
	<?php if($this->Session->read('intermediateCode')!="" || $this->Session->read('intermediateCode')!=null){ ?>
		<div class="fb"><a href="<?php echo $FBLoginUrl;?>"><button class="facebook"></button></a></div>
		<!------------- Linked In sign up--------------->
		<div class="li"><a href="<?php echo $LILoginUrl;?>" > <button class="linkedin"></button></a></div>
	<?php }?>
</div>
<div style="width:480px; margin-top:20px;">
<?php echo $form->create('User', array('action' => 'jobseekerSignup','onsubmit'=>'return checkform()')); ?>

	<?php	echo $form->input('account_email', array('label' => 'Email',
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
		if(($this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')==null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null)){
			echo $form->input('Code.code', array('label' => 'Code',
                                           			'type'  => 'text',
													'name'  => "data[Code][code]",
													'class' => 'text_field_bg required'
                                           			)
                              );	
		}
    ?>
    
	<?php if(isset($codeErrors)): ?><div class="error-message"><?php echo $codeErrors;?></div><?php endif; ?>

	<?php echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
                                           			'type'  => 'checkbox',
													'name'  => "data[User][agree_condition]",
													)
                              );
    ?>
	<div id="agree_condition_error"  class="error-message">
		 <?php if(isset($errors)):	echo $errors; endif; ?>
	</div>
	<div>
		<div>
			<?php echo $form->submit('Register',array('div'=>false,)); ?>
		</div>
		<?php echo $form->end(); ?>
	</div>
	<div style="margin-top:50px;"><a href="/jobseekerInformation">Don't know about Jobseeker</a> </div>
</div>
