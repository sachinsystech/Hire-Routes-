
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

<<<<<<< HEAD
<?php
switch($roleName) {
	case 'jobseeker':
		$setting_page_title = 'MY JOBSEEKER SETTINGS';
		$setting_page_url = '/users/jobseekerSetting';
		break;
	case 'networker':
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
=======

<div class="selection-button">
<center>
<button> MY SETTINGS </button>
>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
</center>
</div>
