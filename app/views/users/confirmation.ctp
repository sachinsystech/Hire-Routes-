<!------ Content for User confirmation ------>
<?php if(isset($roleId)){?>
<h1 class="title-emp">Welcome to Hire Routes</h1>
<div class="sub-title-ce">Thank you for signing up with us, we will analyze your data and get back with in next 24 hours.
</div>
<div class="hr-computer-image"></div>
<div class="sub-content">
	Thank you for signing up with us, we will analyze your data and get back with in next 24 hours.
</div>
<?php	
}
else{
?>
<h1 class="title-emp">Welcome to Hire Routes</h1>
<div class="sub-title-ce">Thank you for signing up with us. We've sent you a confirmation email at: <a href="mailto:
<?php echo $confirmation_email;?>"><?php echo $confirmation_email;?> </a>
</div>
<div class="hr-computer-image"></div>
<div class="sub-content">Please click on the link in your email to confirm your account and get started!</div>
<?php
}
?>
<!------ End content for User confirmation ------>
