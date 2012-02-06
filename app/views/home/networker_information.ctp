<center><b><h3>Networker Information</h3></b></center>

<div>
<b>Make money by helping people find jobs!</b> <br>
Sed	ut perspicia-s unde	omnis iste natus error sit .........
  
</div>  
<br>

<p></p>
<center>
<div class="information-navigation">
  <span> COMPANY? </span>
  <button  class="left-button" onclick="informationPage(1);"></button>
    HOW IT WORKS ILLUSTRATION 
  <button class="right-button" onclick="informationPage(2);"></button>
  <span> JOBSEEKER? </span>
</div>
<div class="selection-button">
  <button onclick="getStarted();">Get Started</button>
</div>
</center>




<script>
function informationPage(redirect){
	switch(redirect){
		case 1:
			window.location.href="/companyInformation";			
			break;

		case 2:
			window.location.href="/jobseekerInformation";			
			break;

		case 3:
			window.location.href="/networkerInformation";			
			break;
	}
}
function getStarted(){
    window.location.href="/users/userSelection";			
}

</script>