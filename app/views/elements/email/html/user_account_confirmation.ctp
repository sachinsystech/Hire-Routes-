<?php 
 	$confirmation_link = Configure::read('rootURL')."users/account/".$user['Users']['id']."/".$user['Users']['confirm_code'];
?>
<b>Hire Routes</b>
<p>
Hello <?php echo $role_name; ?>,
<p>
Welcome to Hire Routes.
<p>
Your e-mail <?php echo $user['Users']['account_email'];?> must be confirmed before using it to log in to Hire Routes.
<p>
To confirm the e-mail and instantly log in, please, use <a href="<?php echo $confirmation_link; ?>"><span style="color: #1E7EC8;">this confirmation link</span></a>. This link is valid only once.<br>

<p style="border: 1px solid rgb(190, 188, 183); padding: 13px 18px; background: none repeat scroll 0% 0% rgb(248, 247, 245);">
Use the following values when prompted to log in:<br>
E-mail: <a target="_blank" href="mailto:<?php echo $user['Users']['account_email'];?>"><?php echo $user['Users']['account_email'];?></a><br>
Password: <?php echo $user['Users']['password'];?>
</p>If you have any questions about your account or any other matter, please contact us at support@hireroutes.com
<p>

Thank you again, Hire Routes

