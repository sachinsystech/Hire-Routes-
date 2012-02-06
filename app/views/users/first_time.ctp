
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
	case '2':
		$setting_page_title = 'MY JOBSEEKER SETTINGS';
		$setting_page_url = '/users/jobseekerSetting';
		break;
	case '3':
		$setting_page_title = 'MY NETWORKER SETTINGS';
		$setting_page_url = '/users/networkerSetting';
		break;
	default:
		$setting_page_title = 'MY SETTINGS';
		$setting_page_url = '';		
}
?>

<div class="selection-button">
<center>
<a href="<?php echo $setting_page_url?>"><button><?php echo $setting_page_title; ?></button></a>
</center>
</div>
