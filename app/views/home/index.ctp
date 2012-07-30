<div id="wrapper-middle">
<!-- Hire Route -->
	<div class="top">
	  <div class="Hire-Routes"> </div>
	  <div class="icons">
		<ul>
		  <li> <a href="" class="twit"> </a> </li>
		  <li> <a href="#<?php //echo $FBLoginUrl; ?>" class="fb"> </a></li>
		  <li> <a href="#<?php //echo $LILoginUrl; ?>" class="in"> </a> </li>
		</ul>
	  
	  </div>
	</div>
	<div class="middle">
		<h1 class="title-emp">Empowering Social Networks to <span> Help People Find Jobs </span></h1>
		<a href="/users/userSelection" class="get-started"></a>
		<div class="content">
			<div class="box" id="company">
				<div class="box-content company">
					<img src="../images/company.png" />
					<h2>COMPANIES / RECRUITERS</h2>
					<h3>UTILIZE YOUR NETWORK</h3>
					<p>Empower your networks to find talent through trusted channels...</p>
					<div class="button-orange"> <a href="/companyInformation">LEARN MORE</a></div>
					<div class="clr"></div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="box" id="networker">
				<div class="box-content network"> <img src="../images/network.png" />
					<h2>NETWORKER</h2>
					<h3> MAKE CONNECTIONS, MAKE MONEY</h3>
					<p>Use your social networks to get paid for helping people find jobs...</p>
					<div class="button-blue"> <a href="/networkerInformation">LEARN MORE</a></div>
					<div class="clr"></div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="box" id="jobseeker">
				<div class="box-content job"> 
					<img src="../images/job.png" />
					<h2>JOB SEEKERS</h2>
					<h3> FIND JOBS HERE</h3>
					<p>Get the jobs you are looking for 
						  sent right to your email inbox...</p>
					<div class="button-green"> <a href="/jobseekerInformation">LEARN MORE</a></div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		</div>
	<div class="clr"></div>
</div>
<script type="text/javascript">
  $(".box").mouseover(function() {
	$(this).addClass('hover');
  }).mouseout(function(){
       $(this).removeClass('hover');
  });
	$("div.box").click(function() {
		var userType = $(this).attr('id');
		if(userType== "company")
			window.location.href = "/companyInformation";
		else if(userType== "networker")
			window.location.href = "/networkerInformation";
		else if(userType== "jobseeker")
			window.location.href = "/jobseekerInformation";			
  });
</script>
