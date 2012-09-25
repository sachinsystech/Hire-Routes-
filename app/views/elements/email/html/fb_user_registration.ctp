<b>Hello <?php echo ucfirst($message['contact_name']); ?>,</b>
<p>
Welcome to Hire Routes.
<p>
Your account is registered for e-mail  :  <?php echo $message['account_email'];?> .<p> 
You signed up as a <?php echo $message['userRole'] ;?> .
<p>
<p>
<p>
<?php $contact_url = Configure::read('httpRootURL')."contactUs";?> 
Please <a href="<?php echo $contact_url; ?>"><span style="color: #1E7EC8;">contact-us </span></a> at
<a target="_blank" href="mailto:info@hireroutes.com;?>">info@hireroutes.com</a>, for detailed information.
<p>
Thank you again, <br/>
Hire Routes
