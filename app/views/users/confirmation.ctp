
<?php echo $this->Session->flash(); ?>

<div style="font-weight:bold; font-size:27px;"><center>Welcome to Hire Routes!</center></div>

<?php if(isset($roleId)){?>

	<div style="margin-top:20px">
	<center>
		Thank you for signing up with us, we will analyze your data and get back with in next 24 hours.
	</center>
<?php	
}
else{
?>

	<div style="margin-top:20px">
	<center>
		Thank you for signing up with us. We&rsquo;ve sent you a confirmation email at <u><?php echo $confirmation_email;?></u>
	</center>
	</div>
	<div style="margin-top:20px">
	<center>
		Please click on the link in your email to confirm your account and get started!
	</center>
	</div>
<?php
}
?>
