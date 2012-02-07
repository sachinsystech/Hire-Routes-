<?php //echo "<pre>"; print_r($jobs); exit;?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active">My Jobs</li>
				<li>My Network</li>
				<li>My Account</li>
				<li>My Employees</li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
				<li class="active">New Jobs - <?php echo count($jobs);?></li>
				<li>Shared Jobs - 20</li>
				<li>Old Jobs - 2</li>
				<li>JOb Data</li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="middleBox">
			<table style="width:100%">
				<tr>
					<th style="width:15%">Title</th>
					<th style="width:10%">Reward$</th>
					<th  style="width:15%">Description</th>
					<th style="width:30%">Category</th>
					<th style="width:20%">Location</th>
					<th style="width:10%">Job Type</th>
				</tr>
				<?php foreach($jobs as $job):?>	
				<tr>
					<td><?php echo $this->Html->link($job['title'], '/companies/editJob/'.$job['user_id'].'/'.$job['id']); ?></td>
					<td><?php echo $job['reward']; ?></td>
					<td><?php echo $job['short_description']; ?></td>
					<td><?php echo $industries[$job['industry']].", ".$specifications[$job['specification']]; ?></td>
					<td><?php echo $job['city'].", ".$states[$job['state']]; ?></td>
					<td><?php echo $job_array[$job['job_type']]; ?></td>
				</tr>
				
				<?php endforeach; ?>			
			</table>
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