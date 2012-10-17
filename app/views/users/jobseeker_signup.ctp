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
			$("#agree_condition_error").removeClass().addClass("error_input_message").html("This field is required .");
			return false;
		}
		if(isAgreeCondition){
			$("#agree_condition_error").removeClass().html("");  
		}
	}
</script>
    <h1 class="title-emp">Job Seeker Registration</h1>
    <div class="sub-title-js">You will be able to apply for jobs and share job posts with your network.<br />Please submit the form below and you will receive an email confirmation to complete you registration.</div>

<?php echo $form->create('User', array('action' => 'jobseekerSignup','onsubmit'=>'return checkform()')); ?>
<div class="login_middle_main"> 
	
	<?php
		if(($this->Session->read('intermediateCode')!='' || $this->Session->read('intermediateCode')!=null ) || ( $this->Session->read('icc')!='' || $this->Session->read('icc')!= null) || ( $this->Session->read('invitationCode')!='' || $this->Session->read('invitationCode')!= null)):?>
    <div class="js_middle_right_box">
        <ul>
            <li><a class="job-share-fb" href="<?php echo $FBLoginUrl; ?>"></a></li>
            <li><a class="job-share-in" href="<?php echo $LILoginUrl; ?>"></a></li>
        </ul>
    </div>
    <div class="login_middle_center_box nr_signup_or_txt_box"><strong>OR</strong></div>
    <!--div class="js_middle_center_box"><strong>OR</strong></div-->	
	<?php else:
			echo "<style>.login_middle_main { width: 300px !important;}</style>" ;
		endif;
	?>
	<div class="login_middle_left_box" style="margin-top:20px;">
		<span style="position: absolute; color:#847A6C; margin-top: 13px; font-size: 13px;">* Required</span>
		<div class="text-box">
		<?php	echo $form->input('account_email', array('label' => false,
														'div'	=> false,
		                                       			'type'  => 'text',
		                                       			'placeholder' => 'Email*',
														'class' => 'required email',
		                                       			)
		                             );
		?>
		</div>
		<div class="text-box text-box-below">
		<?php	echo $form->input('password', array('label' => false,
		                                       			'placeholder' => 'Password*',
														'div'	=> false,	
		                                       			'type'  => 'password',
														'name'  => "data[User][password]",
														'class' => 'password',
														'minlength' => '6',
		                                       			)
		                          );
		?>
		</div>
		<div class="text-box text-box-below">
		<?php	echo $form->input('repeat_password', array('label' => false,
		                                       			'placeholder' => 'Confirm Password*',	
		                                       			'div' => false,                                           														'type'  => 'password',
														'name'  => "data[User][repeat_password]",
														'class' => 'required'
		                                       			)
		                          );
		?>
		</div>
		<?php	
			if(($this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')==null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null)){
		?>
		<div class="text-box text-box-below">
		<?php
				echo $form->input('Code.code', array('label' => false,
														'div' => false,
		                                       			'placeholder' => 'Code*',
		                                       			'type'  => 'text',
														'name'  => "data[Code][code]",
														'class' => 'required'
		                                       			)
		                          );	
			}
		?>
		
		<?php if(isset($codeErrors)): ?><div class="error_input_message"><?php echo $codeErrors;?></div>
		<?php endif; ?>
		</div>
	
		<div class="check-button">
			<div class="cross-button">	
				<?php echo $form->input('agree_condition', array('label' =>false,
		    		                                   			'type'  => 'checkbox',
																'name'  => "data[User][agree_condition]",
																'div' =>false,
														)
		                          );
				?>
			</div>
			<div class="remember-me agree-with">Agree with <a href="/termsOfUse">Terms & Conditions</a></div>
			<div id="agree_condition_error"  class="error_input_message">
				 <?php if(isset($errors)):	echo $errors; endif; ?>
			</div>
		</div>
		<div class="login-button">
			<?php echo $form->submit('Register',array('div'=>false,)); ?>
			<div class="clr"></div>
		</div>
		<?php echo $form->end(); ?>

		<div class="forgot-password networker-width">
			<a href="/jobseekerInformation">Don't know about Jobseekers?</a>
		</div>
	</div>
	<div class="clr"></div>
</div>

