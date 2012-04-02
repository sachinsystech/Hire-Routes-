<?php

?>

<div style="font-weight:bold;"><center>Please select what type of user you are!</center></div>
<div class="selection-button">
<center>
<button onclick="registrationInto(1);">Company/Recruiter</button>
<button onclick="registrationInto(2);">Networker</button>
<button onclick="registrationInto(3);">Job Seeker</button>
</center>
</div>
<div style='margin-top:20px;'>
	<center>
		<font size='5px'><b><a style="color:#088A08;text-decoration:none;" href='/networkerInformation'>Don't Know?</a></b></font>
	</center>
</div>

<script>
function registrationInto(redirect){
	switch(redirect){
		case 1:
			window.location.href="/users/companyRecruiterSignup";			
			break;

		case 2:
			window.location.href="/users/networkerSignup";			
			break;

		case 3:
			window.location.href="/users/jobseekerSignup";			
			break;
	}
}
</script>
