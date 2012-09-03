<!------- Starts contents for user selection -------->
<h1 class="title-emp">What type of user are you? </span></h1>
<div class="button"> <a href="/networkerInformation">DON'T KNOW? </a> </div>
<div class="content">
    <div class="box1" onclick="registrationInto(1);">
      <div class="box-content company-up" style="margin:5px 0 0 70px">
	 	<img src="/images/company_1.png" />
        <div class="clr"></div>
      </div>
      <div class="button-company" > <a href="/users/companyRecruiterSignup">COMPANY </a></div>
      <div class="clr"></div>
    </div>
    <div class="box1" onclick="registrationInto(3);">
      <div class="box-content network-up"> <img src="/images/network_1.png" />
        <div class="clr"></div>
      </div>
      <div class="button-network" > <a href="/users/networkerSignup">NETWORKER</a></div>
      <div class="clr"></div>
    </div>
    <div class="box1" onclick="registrationInto(2);">
      <div class="box-content job-up"> <img src="/images/job_1.png" />
      </div>
      <div class="clr"></div>
      <div class="button-jobseeker" > <a href="/users/jobseekerSignup">JOB SEEKER </a></div>
    </div>
  </div>
<div class="clr"></div>

<!------ End contents for user selection ---------->

<script>
function registrationInto(redirect){
	switch(redirect){
		case 1:
			//window.location.href="/users/companyRecruiterSignup";			
			break;

		case 3:
			//window.location.href="/users/networkerSignup";			
			break;

		case 2:
			//window.location.href="/users/jobseekerSignup";			
			break;
	}
}
/*$(".box").mouseover(function() {
	$(this).addClass('hover');
}).mouseout(function(){
   $(this).removeClass('hover');
});
$("div.box").click(function() {
	$(this).addClass('click');	
});
*/
</script>
