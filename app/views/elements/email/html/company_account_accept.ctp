<b>Hire Routes</b>
<p>
Welcome to Hire Routes.
<p>
Your account for Email: <?php echo $message['account_email'];?> is accepted and confirmed.
</p>
<?php $login_url = Configure::read('httpRootURL')."users/login/";?>
Now, you can <a href="<?php echo $login_url; ?>"><span style="color: #1E7EC8;">login</span></a> into our system.
<p>
<?php $contact_url = Configure::read('httpRootURL')."contactUs";?> 
Please <a href="<?php echo $contact_url; ?>"><span style="color: #1E7EC8;">contact-us </span></a> at
<a target="_blank" href="mailto:support@hireroutes.com;?>">support@hireroutes.com</a>, for detailed information.
<p>
<p>
Thank you again,<br> Hire Routes

