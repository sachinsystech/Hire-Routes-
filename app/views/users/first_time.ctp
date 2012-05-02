
<?php echo $this->Session->flash(); ?>

<div style="font-weight:bold; font-size:27px;"><center>Welcome to Hire Routes!</center></div>
<div style="margin-top:35px">
<center>
	Thank you for registering with Hire Routes!
</center>
</div>
<div style="margin-top:20px">
<center>
	Please click below and select your settings so you can start<br/>
	helping people find jobs in the industries you think you can help in!
</center>
</div>

<?php
switch($roleName) {
	case JOBSEEKER:
		$setting_page_title = 'MY JOBSEEKER SETTINGS';
		$setting_page_url = '/jobseekers/setting';
		break;
	case NETWORKER:
		$setting_page_title = 'MY NETWORKER SETTINGS';
		$setting_page_url = '/networkers/setting';
		break;
	default:
		$setting_page_title = 'MY SETTINGS';
		$setting_page_url = '';		
}
?>

<div class="selection-button">
<center>
<a style="text-decoration:none;" href="<?php echo $setting_page_url;?>"><button style="height:50px;"><?php echo $setting_page_title; ?></button></a>
<?php if(isset($jobUrl)):?>
<a style="text-decoration:none;" href="<?php echo $jobUrl;?>"><button style="height:50px;">CONTINUE TO <br/>JOB</button></a>
<?php endif;?>
</center>
</div>
