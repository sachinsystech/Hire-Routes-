<?php echo $this->Session->flash(); ?>

<div style="width:350px;margin:auto;">
<div class="sigup_heading"><u>Login</u></div>
<?php
	echo $this->Session->flash('auth');
	echo $this->Form->create('User');
	echo "<div class='required'>".$this->Form->input('username',array("class"=>'text_field_bg required'))."</div>";
	echo "<div class='required'>".$this->Form->input('password',array("class"=>'text_field_bg required'))."</div>";
	echo $this->Form->end('Login');
?>
</div>
<script>

	$(document).ready(function(){
		$("#UserLoginForm").validate();
	});     
</script>
