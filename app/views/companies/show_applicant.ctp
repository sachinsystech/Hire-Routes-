<?php //echo "<pre>"; print_r($jobs); exit;?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active">My Jobs</li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>
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
				<li class="active">Applicants - <?php echo count($applicants);?></li>
				<li>Shared Jobs - 20</li>
				<li>Old Jobs - 2</li>
				<li>JOb Data</li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		    <div class="middleBox">
			<div>
				<div>Search By</div>
				<div style="float:left;width:150px;padding-left:5px;">Filter label </div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px">Filter label</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px;padding-left:5px;">Filter label</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px">Filter label</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px;padding-left:5px;">Filter label</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px">Filer8</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px;padding-left:5px;">Filer4</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px">Filer9</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px;padding-left:5px;">Filer5</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 
				<div style="float:left;width:150px">Filer10</div>
				<div style="float:left;width:150px"><select><option>--select--</option></select></div> 				
			</div>
			<table style="width:100%">
				<tr>
					<th style="width:35%">Name</th>
					<th style="width:25%">Degree of Separation</th>
					<th style="width:20%">Networker</th>
					<th style="width:20%">Operatoins</th>
				</tr>
				<?php if(empty($applicants)): ?>
				<tr>
					<td colspan="100%">Sorry, No applicant found.</td>
				</tr>
				<?php endif; ?>
				<?php foreach($applicants as $applicant):?>	
				<tr>
					<td>
						<span style="font-weight:bold"><?php echo $applicant['jobseekers']['contact_name']; ?></span>
						<span style="font-size:11px"><?php echo "<br>Submitted ". $time->timeAgoInWords($applicant['JobseekerApply']['created']); ?> </span>
						<?php echo "<br> view resume   |   view cover letter"; ?>
					</td>
					<td>--</td>
					<td>--</td>
					<td align="center" width="10%">
						<?php
							
							echo $this->Html->image("/img/icon/ok.png", array(
								"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:22px;",
								'url' => "/companies/acceptApplicant/".$applicant['JobseekerApply']['id'],
								'title'=>'Accept'
							));
							
							echo $this->Html->image("/img/icon/delete.png", array(
							"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:10px;",
							'url' => "",
							'title'=>'Reject'
							));
						?>
					</td>
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
