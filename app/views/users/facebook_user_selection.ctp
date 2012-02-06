<?php

?>

<div style="font-weight:bold;"><center>Please select what type of user you are!</center></div>
<div class="selection-button">
<center>
	<button onclick="registrationInto(2);">Job Seeker</button>
	<button onclick="registrationInto(3);">Networker</button>
</center>
</div>

<script>
function registrationInto(redirect){
	switch(redirect){
		case 2:
			window.location.href="/users/saveFacebookUser/2";			
			break;

		case 3:
			window.location.href="/users/saveFacebookUser/3";			
			break;
	}
}
</script>
