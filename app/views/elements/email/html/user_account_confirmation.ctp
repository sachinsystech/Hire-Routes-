<?php
	if(isset($message['intermediateCode'])&&!empty($message['intermediateCode'])) 
 		$confirmation_link = Configure::read('httpRootURL')."users/account/".$message['id']."/".$message['confirm_code']."/".$message['intermediateCode'];
 	else
 		$confirmation_link = Configure::read('httpRootURL')."users/account/".$message['id']."/".$message['confirm_code']."/";
?>
<?php $config_url = Configure::read('httpRootURL');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hire - Route</title>
<style>
	@font-face {
    font-family: 'OpenSansCondensedBold';
    src: url('fonts/opensans-condbold-webfont.eot');
    src: url('fonts/opensans-condbold-webfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/opensans-condbold-webfont.woff') format('woff'),
         url('fonts/opensans-condbold-webfont.ttf') format('truetype'),
         url('fonts/opensans-condbold-webfont.svg#OpenSansCondensedBold') format('svg');
    font-weight: normal;
    font-style: normal;

}
</style>
</head>

<body style="margin:0; padding:0;">

	<div style="width:725px; height:auto; margin:0 auto; background:#f9f3e4;">
    	<?php echo $this->element("email_header"); ?>
<div style="width:649px; height:44px; border-bottom:1px solid #D4CCC1; border-top:1px solid #D4CCC1; margin:0 auto; font-size: 30px; line-height: normal; color: #4a4947; font-family: Lucida Sans Unicode, Sans-serif; padding:5px 0 0 0; text-align:center;">	
    Welcome to Hire Routes 
</div>
        
        <div style="width:643px; height:auto; margin:0 auto;">
        	 <p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">Your e-mail <?php echo $message['account_email'];?> must be confirmed before using it to log in to Hire Routes..<br>
        	 	To confirm the e-mail and instantly log in, please, use
	        	<a style="color:#2d9d97; text-decoration:underline; font:15px Arial,Helvetica,sans-serif;" href="<?php echo $confirmation_link; ?>">This confirmation link</a> This link is valid only once.
	      	</p>
            <p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">
			Use the following values when prompted to log in:<br>
			E-mail: <a target="_blank" href="mailto:<?php echo $message['account_email'];?>"><?php echo $message['account_email'];?></a>
			</p>
			<p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">
				Thank you again, <br/>
				Hire Routes
			</p>
        </div>
      <?php echo $this->element("email_footer"); ?>
        
      <div  style="clear:both;"></div>  
</div>

</body>
</html>

