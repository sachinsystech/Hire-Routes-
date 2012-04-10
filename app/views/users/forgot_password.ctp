<?php echo $this->Session->flash(); ?>

<div style="width:650px;margin:auto;">
<div style="margin:10px;font-weight:bold">To reset your password, Enter your email address you use to sign in to Hire Routes:</div>
<?php
	echo $this->Form->create('User');
	echo "<div class='required'>".$this->Form->input('user_email',array('label'=>'Email',
												'type'=>'text',
												'class' => 'text_field_forget_password required email',))."</div>";
	echo $this->Form->submit('Continue');
	echo $this->Form->end();
?>
</div>
<script>
$(document).ready(function(){
	$("#UserForgotPasswordForm").validate();
});
</script>

