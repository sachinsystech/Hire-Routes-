<?php $login_url = Configure::read('httpRootURL')."users/login/";?>
<?php $contact_url = Configure::read('httpRootURL')."contactUs";?> 

<p>Welcome to Hire Routes!</p>

<p>Your request has been accepted and confirmed for <?php echo ucfirst($message['contact_name']);?> at <?php echo $message['company_name']; ?>.</p>

<p>You can now <a href="<?php echo $login_url; ?>"><span style="color: #1E7EC8;">login</span></a> using your username : <?php echo $message['account_email'];?></p>

<p>Please contact us at <a target="_blank" href="info@hireroutes.com;?>">info@hireroutes.com</a> if you have any questions or you simply have something on your mind...anything at all!</p>
<p> </p>
<p>Thanks again for signing up!</p>
<p> </p>
<p>Sincerely, Hire Routes</p>
