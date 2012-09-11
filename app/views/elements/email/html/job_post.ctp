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
    Here are your new <span style="color:#329024;">Job</span> listings 
</div>
        
        
        
        <div style="width:643px; height:auto; margin:0 auto;">
        	<ul style="margin:0; padding:0;">
	        	<?php foreach($job as $job):?>
            	<li style="width:593px; height:49px; list-style:none; display:block; padding:28px 25px 0 25px; background:#eae6d6; margin:30px 0 0 0;">
                	<a style="text-decoration:underline; color:#3a9031; float:left; font:bold 20px 'OpenSansCondensedBold';width: 400px;word-wrap: break-word;" href="<?php echo $config_url.'jobs/jobDetail/'.$job['Job']['id'];?>"><?php echo $job['Job']['title']; ?></a>
                    <div style="width:auto; height:20px; float:right; font-size:20px; line-height: normal; text-transform: uppercase; color:#1d1d1d;  font-family: 'OpenSansCondensedBold';">
						Reward: <span style="color:#3a9031;"><?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> </span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
      <?php echo $this->element("email_footer"); ?>
        
      <div  style="clear:both;"></div>  
</div>

</body>
</html>

