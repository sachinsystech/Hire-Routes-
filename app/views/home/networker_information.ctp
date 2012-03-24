<?php
?>
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
<div >
	<div id="LeftContainer">
		<div id="HeadingInformation"  >HOW TO WORK VIDEO</div>
		<div id="Video">video</div>
		<div id="GetStart" onclick="return getStarted();">Get Started </div>
		<div >
			<div id="HeadingInformation">	WHY HIRE ROUTES?</div>
			<div id="WhyHireRoutes">
				<div id="WhyHireRoutesData">1: Hire Routes </div>
				<div id="WhyHireRoutesData">2: Hire Routes </div>
				<div id="WhyHireRoutesData">3: Hire Routes </div>
				<div id="WhyHireRoutesData">4: Hire Routes </div>
			</div>
		</div>
	</div>
	<div id="InformationImage">
		<?php echo $this->Html->image('/../img/network_info.png', array('style'=>'width:600px;height:510px;','usemap'=>'#network_info'));?>
		<map name="network_info">
			<area shape="rect" coords="215,475,400,510" href="/users/userSelection">
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
