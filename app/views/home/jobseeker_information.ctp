<?php 
/*
Page for job seeker information
*/
?>
<center><b><h3>Jobseeker Information</h3></b></center>
<div>
<b>Get sent the right job for you automatically!
</b> <br>
Sed	ut perspicia-s unde	omnis iste natus error sit .........
  
</div>  
<br>
<p></p>
<center>
<div class="information-navigation">
  <span> COMPANY? </span>
  <button  class="left-button" onclick="informationPage(1);"></button>
    HOW IT WORKS ILLUSTRATION 
  <button class="right-button" onclick="informationPage(3);"></button>
  <span> NETWORKER? </span>
</div>
<div class="selection-button">
  <button onclick="getStarted();">Get Started</button>
</div>
</center>
<div >
	<div class="LeftContainer">
		<div class="HeadingInformation"  >HOW TO WORK VIDEO</div>
		<div class="Video">video</div>
		<div id="GetStart" onclick="return getStarted()">Get Started </div>
		<div >
			<div class="HeadingInformation">	WHY HIRE ROUTES?</div>
			<div class="WhyHireRoutes">
				<div class="WhyHireRoutesData">1: Hire Routes </div>
				<div class="WhyHireRoutesData">2: Hire Routes </div>
				<div class="WhyHireRoutesData">3: Hire Routes </div>
				<div class="WhyHireRoutesData">4: Hire Routes </div>
			</div>
		</div>
	</div>
	<div class="InformationImage">
		<?php echo $this->Html->image('/../img/job_seeker_info.png', array('style'=>'width:600px;height:510px;','usemap'=>'#network_info'));?>
		<map name="network_info">
			<area shape="rect" coords="215,450,395,480" href="/users/userSelection">
		</map>
	</div>
</div>
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
