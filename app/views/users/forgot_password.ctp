<div class="login_middle_main"> 
	<div class="sub-title-forgot-password application_top_submenu network_top_txt">To reset your password, Enter your email address you use to sign in to Hire Routes</div>
<?php
	echo $this->Form->create('User');
?>
	<div class="network_form_row">
<?php 
	echo $this->Form->input('user_email',array('label'=>false,
												'type'=>'text',
												'div'=> false,
												'placeholder'=>'Email',
												'class' => 'required email'));
?>
	</div>
	<div class="clr"></div>
	<div class="network_form_row space">
		<div class="network_register_bttn">
			<?php echo $this->Form->submit('Continue');?>
		</div>
<?php
	
	echo $this->Form->end();
?>
	</div>
</div>
<script>
$(document).ready(function(){
   	$("#UserForgotPasswordForm").validate({
		errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				error.insertAfter(element)
				error.css({'width':'230px'});
		}
	});
});
</script>

