<?php
	/**
	 * Jobseeker Specific Data
	 */
?>
<div id="page-heading"><h1>Jobseeker Specific Data</h1></div>
<div class='dataBorder'>
	<div class='jobseekerSpecificData'>
		<div class='specificData'>
			<div class="DataRow">
				<div class="NSDInfoHeading">NAME:</div>
				<div class="NSDInfo"><?php echo ucfirst($jobseekerData['Jobseeker']['contact_name']);?></div>
			</div>
			<div class="DataRow">
				<div class="NSDInfoHeading">Email:</div>
				<div class="NSDInfo"><?php echo $jobseekerData['User']['account_email'];?></div>
			</div>
			<div class="DataRow">
				<div class="NSDInfoHeading">Applied Job:</div>
				<div class="NSDInfo"><?php echo $jobseekerData['0']['appliedJob'];?></div>
			</div>
		</div>
	</div>
</div>

