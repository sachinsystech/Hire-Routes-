<?php 
	$contact_url = Configure::read('httpRootURL')."contactUs";
 	$login_link = Configure::read('httpRootURL')."users/login";
?>
<div><h1>Hire Routes,</h1></div>
<div>
	<div>
		Your password for account email <?php echo $message['account_email'] ;?>  is <b><?php echo $message['password'] ;?></b>
	</div>
	<div>
		Your can <a href="<?php echo $login_link; ?>" >login</a>
	</div>
	<p>
		Please <a href="<?php echo $contact_url; ?>"><span style="color: #1E7EC8;">contact-us </span></a> at
		<a target="_blank" href="mailto:support@hireroutes.com;?>">support@hireroutes.com</a>, for details information.
	<p>
	Thank you again,<br> Hire Routes
</div>
