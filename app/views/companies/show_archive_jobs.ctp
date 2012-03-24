<?php ?>
<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectChange);
		$("#message").hide();
	});
	function onSelectChange(){
	    var displaySelected = $("#switch_display option:selected");
		var shortSelected = $("#short_by option:selected"); 
		window.location.href="/companies/showArchiveJobs/display:"+displaySelected.text()+"/shortby:"+shortSelected.val();
	}

	function onDelete(id)
	{	if(confirm("Do you want to delete?")){
			$.ajax({
				url: "/companies/deleteJob",
				type: "post",
				data: {jobId : id,action:'archiveJobs'},
				success: function(response){
					window.location.reload();          
				},
				error:function(response)
				{
					$('#message').html("ERROR:");
				}
			});
		}
		return false;
	}

	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>
<div id="message" class="success"></div>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob">My Jobs</a></li>
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
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob">Jobs - <?php echo $activejobCount;?></a></li>
				<li class="active">Archive - <?php echo count($jobs);?></li>
				<li> Data </li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
			<table style="width:100%">
				<tr >
					<td colspan="100%">
						<div style="float:left;width:50%;">
							SORT BY<select  id="short_by">
							<option value="date-added" <?php echo $shortBy=="date-added"?"selected":"" ?> >Date Added</option>
							<option value="industry" <?php echo $shortBy=="industry"?"selected":"" ?> >Industry</option>
							<option value="salary" <?php echo $shortBy=="salary"?"selected":"" ?> >Salary</option>
							</select>
						</div>
						<div style="float:right;width:50%;text-align: right;">
						<?php echo $paginator->first(' << ', null, null, array("class"=>"disableText"));?>
						<?php echo $this->Paginator->prev(' < ', null, null, array("class"=>"disableText")); ?>
						<?php echo $this->Paginator->numbers(); ?>
						<?php echo $this->Paginator->next(' > ', null, null, array("class"=>"disableText")); ?>
						<?php echo $paginator->last(' >> ', null, null, array("class"=>"disableText"));?>
						 DISPLAYING 
						<select id="switch_display">
							<option <?php echo $displayPageNo=="10"?"selected":"" ?>>10</option>
							<option <?php echo $displayPageNo=="20"?"selected":"" ?>>20</option>
							<option <?php echo $displayPageNo=="50"?"selected":"" ?>>50</option>
						</select>
						</div>
					</td></tr>
				<tr>
					<th style="width:53%">Title</th>
					<th style="width:20%">Submissions</th>
					<th  style="width:17%">Action</th>
				</tr>
				<?php if(empty($jobs)){ ?>
				<tr>
					<td colspan="100%">Sorry, No job found.</td>
				</tr>
				<?php } ?>
				<?php foreach($jobs as $job):?>	
				<tr>
					<td><?php echo $this->Html->link($job['Job']['title'], '/companies/editJob/'.$job['Job']['id']); echo "<br>Posted ". $time->timeAgoInWords($job['Job']['created']) ?></td>
					<td><?php echo $job[0]['submissions']; ?> submissions</td>
					<td><?php echo $this->Html->image("/img/icon/detail.png", array(
						"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:2px;",
						'url' =>  '/jobs/jobDetail/'.$job['Job']['id'],
                        'title'=> 'Detail'
						));
						echo $this->Html->image("/img/icon/edit.png", array(
						"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:2px;",
						'url' =>  '/companies/editJob/'.$job['Job']['id'],
                        'title'=> 'Edit'
						));

						echo $this->Html->image("/img/icon/delete.png", array(
						"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:2px;",
						'url' => '#',
                        'title'=>'Delete',
						'onclick'=>'return onDelete('.$job['Job']['id'].');'
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

