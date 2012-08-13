<?php
switch($role) {
	case JOBSEEKER:
		$setting_page_url = '/jobseekers/setting';
		break;
	case NETWORKER:
		$setting_page_url = '/networkers/setting';
		break;
	default:
		$setting_page_url = '';		
}
?>
    <h1 class="title-emp">Thank you for Registering with Hire Routes</h1>
    <div class="sub-title-ty">Please click below and select your settings so you can start receiving the best jobs for you!</div>
    <div class="button-setting"> <a href="<?php echo $setting_page_url;?>">SETTINGS</a></div>

