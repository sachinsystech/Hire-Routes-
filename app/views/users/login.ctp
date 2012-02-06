<div style="width:350px;margin:auto;">
<?php echo $this->Session->flash(); ?>
<div class="sigup_heading"><u>Login</u></div>
<?php
	echo $this->Session->flash('auth');
	echo $this->Form->create('User');
	echo $this->Form->input('username',array("class"=>'text_field_bg'));
	echo $this->Form->input('password',array("class"=>'text_field_bg'));
	echo $this->Form->end('Login');
?>
</div>
