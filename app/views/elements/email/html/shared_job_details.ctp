<?php $base_link = Configure::read('httpRootURL');?>
<?php if(isset($message['code'])&&!empty($message['code'])){
		$intermediateCode= "/?intermediateCode=".$message['code'];
	}else{
		$intermediateCode="";
	}
?>
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
<div style="width:649px; height:44px; border-bottom:1px solid #D4CCC1; border-top:1px solid #D4CCC1; margin:0 auto; font-size: 23px; line-height: normal; color: #4a4947; font-family: Lucida Sans Unicode, Sans-serif; padding:5px 0 0 0; text-align:center;">	
    Empowering Social Networks to <span style="color:#329024;">Help People Find Jobs</span>
  </div>
        
        <div style="width:468px; height:auto; padding:20px 0 0 20px; margin:0 0 0 30px;">
        	<!-----------------------
        	<h2 style="font-size:20px; line-height: normal; text-transform: uppercase; color:#1d1d1d;  font-family: 'OpenSansCondensedBold';">STEVE WASTERVAL,</h2>
        	--------------->
            <!--<p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">I would like to send you this job posting because I think you are the right cantidate for the job, and if you are not you can forward it on to your friends and networks as well and we will all share a cut of the reward.</p>-->
            <p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;"><?php echo ucfirst($message['message']) ;?></p>
            
            
            <?php if(isset($message['userName']) && $message['userName'] != null) { ?>
			<p style="margin:20px 0 0 10px; font:15px Arial, Helvetica, sans-serif; color:#1d1d1d; text-align:justify; line-height:20px;">- <?php echo ucfirst($message['userName']) ;?></p> 
			<?php } ?>
        </div>
        
        <div style="width:643px; height:auto; margin:0 auto;">
        	<ul style="margin:0; padding:0;">
            	<li class="job_title" style="width:593px; height:49px; border-top:solid 1px #d3cdc1; border-bottom:solid 1px #d3cdc1; list-style:none; display:block; padding:28px 25px 0 25px; background:#eae6d6; margin:30px 0 0 0;">
                	<a style="text-decoration:underline; color:#3a9031; float:left; font:bold 20px 'OpenSansCondensedBold';width: 400px;word-wrap: break-word;" href="<?php echo $message['jobUrl']; ?>" > <?php echo strtoupper($message['Job']['title']); ?> </a>
                    <div style="width:auto; height:20px; float:right; font-size:20px; line-height: normal; text-transform: uppercase; color:#1d1d1d;  font-family: 'OpenSansCondensedBold';">
						Reward: <span style="color:#3a9031;">$30,500</span>
                    </div>
                </li>
            </ul>
        </div>
        
        <div style="width:570px; margin:20px auto;">
        	<div style="width:235px; margin:0 auto; text-align:center; height:100px; float:left;">
            	<p style="font:15px Arial, Helvetica, sans-serif;">Share this post with your network</p>
                <div style="width:207px; height:62px; margin:0 auto;"><img src="<?php echo $base_link;?>images/email_share_bttn.png" alt="" border="0" usemap="#Map2" />
                  <map name="Map2" id="Map2">
                    <area shape="rect" coords="9,9,194,49" href="<?php echo $message['jobUrl'] ; ?>" />
                  </map>
                </div>
                <a style="color:#2d9d97; text-decoration:underline; font:15px Arial,Helvetica,sans-serif;" href="<?php echo $base_link.'howItWorks/'.$message['Job']['id'].$intermediateCode;?>">How it works</a>
            </div>
            
            <div style="font:24px 'OpenSansCondensedBold'; text-align: center; width: 100px; float:left;margin-top: 22px;">OR</div>
            
            <div style="width:235px; margin:0 auto; height:100px; float:left; text-align:center;">
            	<p style="font:15px Arial, Helvetica, sans-serif;">Apply for the job yourself</p>
                <div style="width:207px; height:62px;   margin:0 auto;"><img src="<?php echo $base_link;?>images/email_apply_bttn.png" alt="" border="0" usemap="#Map3" />
                  <map name="Map3" id="Map3">
                    <area shape="rect" coords="9,8,195,49" href="<?php echo $base_link.'jobs/applyJob/'.$message['Job']['id'].$intermediateCode;?>" />
                  </map>
                </div>
                <a style="color:#50a64e; text-decoration:underline; font:15px Arial,Helvetica,sans-serif;" href="<?php echo $base_link.'howItWorks/'.$message['Job']['id'].$intermediateCode;?>" >How it works</a>
            </div>
            <div style="clear:both;"></div>
        </div>
        
<div style="width:643px; height:auto; margin:0 auto; padding-top:30px;">
        	<h1 style="font-size:24px; padding:0 0 0 25px; line-height: normal; color: #4a4947; font-family: Lucida Sans Unicode, Sans-serif;">5 Reasons to Use/Join Hire Routes</h1>
            <ul style="margin:15px 0 0 0; padding:10px 0 0 0; border-top:solid 1px #d3cdc1; padding-left:25px;">
           	  <li style="list-style:decimal inside; font:15px Arial, Helvetica, sans-serif; padding:12px 0; display:block;">1. Help a Friend Find a Job</li>
              <li style="list-style:decimal inside; font:15px Arial, Helvetica, sans-serif; padding:12px 0; display:block;">2. Find a Job for Yourself</li>
              <li style="list-style:decimal inside; font:15px Arial, Helvetica, sans-serif; padding:12px 0; display:block;">3. Charity (2%of Revenue goes to various charitable organizations.)</li>
              <li style="list-style:decimal inside; font:15px Arial, Helvetica, sans-serif; padding:12px 0; display:block;">4. Help Hire Routes grow so we can help more people!</li>
              <li style="list-style:decimal inside; font:15px Arial, Helvetica, sans-serif; padding:10px 0 0 0; display:block;">5. Help a Friend Find a Job</li>
</ul>
      </div>
      <?php echo $this->element("email_footer"); ?>
        
      <div  style="clear:both;"></div>  
</div>

</body>
</html>
