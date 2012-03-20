<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>
				<li>My Employees</li>
			</ul>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">Profile</a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentInfo">Payment Info</a></li>
				<li  class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentHistory">Payment History</span></a></li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editProfile"><span>Edit</span></a></li>
			</ul>
			
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->

			<div class="middleBox">
				<div class="job_data">
					<table>	
						<tr>
							<td>Date</td>
							<td><strong>#</strong></td>
							<td><strong>Payment Method</strong></td>
							<td><strong>Payment Amount</strong></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>						
					</table>
				</div>
			</div>	
		<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
