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
			Invitation from Hire Routes<span style="color:#329024;"><?php echo ucfirst($message['userName']) ;?></span> 
		</div>
        
        <div style="width:643px; height:auto; margin:0 auto;">
        	 <p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;"><?php echo $message['message']; ?></p>
        	<p>
        		<a style="text-decoration:underline; color:#3a9031; float:left; font:20px 'OpenSansCondensedBold';width: 600px;word-wrap: break-word;text-align:center;" href= "<?php echo $message['invitationUrl']?>"> Connect With Us >></a>
        	</p>
			<?php if(isset($message['userName']) && $message['userName'] != null) { ?>
			<p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">- <?php echo ucfirst($message['userName']) ;?></p> 
			<?php } ?>
        </div>
		<?php echo $this->element("email_footer"); ?>
      
      <div  style="clear:both;"></div>  
</div>

</body>
</html>

