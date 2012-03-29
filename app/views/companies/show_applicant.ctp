<?php //echo "<pre>"; print_r($jobs); exit;?>
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
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editJob/<?php echo $jobId;?>"> Edit </a></li><li class="active">Applicants - <?php echo count($applicants);?></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/jobStats/<?php echo $jobId;?>"> Data </a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		    <div class="middleBox">
			<?php echo $form->create('', array('url' => array('controller' => 'companies', 'action' => 'showApplicant/'.$jobId),'name'=>'webform'));?>
			<div>
				<div>Search By</div>

				<div style="float:left;" id="lbl">Qualification </div>
				<div style="float:left;" id="field">
					<?php $answer1_array = array(''=>'Select','High School'=>'High School','Diploma'=>'Diploma','Graduation'=>'Graduation','Post Graduation'=>'Post Graduation'); 
                          echo $form->input('answer1', array('label'   => '',
															 'type'    => 'select',
															 'class'   => 'show_appl_filter_select',
															 'options' =>$answer1_array,
															 'value'   => isset($filterOpt['answer1'])?$filterOpt['answer1']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div> 

				<div style="float:left;" id="lbl">Work Experience</div>
				<div style="float:left;" id="field">
					<?php $answer2_array = array(''=>'Select','0 to 2 year'=>'0 to 2 year','2 to 5 year'=>'2 to 5 year','More than 5 year'=>'More than 5 year'); 
                          echo $form->input('answer2', array('label'   => '',
															 'type'    => 'select',
															 'class'   => 'show_appl_filter_select',
															 'options' =>$answer2_array,
															 'value'   => isset($filterOpt['answer2'])?$filterOpt['answer2']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div> 

				<div style="float:left;" id="lbl">Current CTC</div>
				<div style="float:left;" id="field">
					<?php	$answer3_array = array(''=>'Select','Less than 1,20,000'=>'Less than 1,20,000','1,20,000 to 3,60,000'=>'1,20,000 to 3,60,000','More than 3,60,000'=>'More than 3,60,000'); 
							echo $form->input('answer3', array('label'   => '',
															   'type'    => 'select',
                                                               'class'   => 'show_appl_filter_select',
															   'options' =>$answer3_array,
															   'value'   => isset($filterOpt['answer3'])?$filterOpt['answer3']:"",
															   'onChange'=>"javascript:document.webform.submit();"));?>
				</div>
 
				<div style="float:left;" id="lbl">Expected CTC</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer4', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer3_array,
															 'value'   => isset($filterOpt['answer4'])?$filterOpt['answer4']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div> 

				<div style="float:left;" id="lbl" >Job Type</div>
				<div style="float:left;" id="field">
					<?php $answer5_array = array(''=>'Select',
												 '1'=>'Full Time',
									 			 '2'=>'Part Time',
									 			 '3'=>'Contract',
									 			 '4'=>'Internship',
									 			 '5'=>'Temporary'); 

                      	  echo $form->input('answer5', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer5_array,
															 'value'   => isset($filterOpt['answer5'])?$filterOpt['answer5']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div>
 
				<div style="float:left;" id="lbl">Ready to relocate</div>
				<div style="float:left;" id="field">
					<?php $answer6_array = array(''=>'Select','Yes'=>'Yes','No'=>'No'); 
                      	  echo $form->input('answer6', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer6'])?$filterOpt['answer6']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div>
 
				<div style="float:left;" id="lbl">Shifts Availability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer7', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
									                         'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer7'])?$filterOpt['answer7']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div>
 
				<div style="float:left;" id="lbl">Passport Availability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer8', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer8'])?$filterOpt['answer8']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div>
 
				<div style="float:left;" id="lbl">Travel Ability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer9', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer9'])?$filterOpt['answer9']:"",
															 'onChange'=>"javascript:document.webform.submit();"));?>
				</div> 

				<div style="float:left;" id="lbl">Training Needs</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer10', array('label'   => '',
															  'type'    => 'select',
                                                              'class'   => 'show_appl_filter_select',
															  'options' =>$answer6_array,
															  'value'   => isset($filterOpt['answer10'])?$filterOpt['answer10']:"",
															 'onChange' =>"javascript:document.webform.submit();"));?>
				</div> 				
			</div>
			<?php echo $form->end();?>
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
						<span style="font-size:11px"><?php echo "<br>Submitted ". $time->timeAgoInWords($applicant['JobseekerApply']['created']); ?> </span><br>
						<span>
						<?php if($applicant['JobseekerApply']['resume']!=''){
								echo $html->link('view resume',array('controller'=>'/companies/','action' => '/viewResume/resume/'.$applicant['JobseekerApply']['id'])); }?>
						<?php if($applicant['JobseekerApply']['resume']!='' && $applicant['JobseekerApply']['cover_letter']!=''){ echo " | "; }?>
						<?php if($applicant['JobseekerApply']['cover_letter']!=''){ 
								echo $html->link('view cover letter',array('controller'=>'/companies/','action' => '/viewResume/cover_letter/'.$applicant['JobseekerApply']['id'])); }?>
						</span>
					</td>
					<td><?php if($applicant['JobseekerApply']['intermediate_users']!=''){
								$degree = count(explode(",",$applicant['JobseekerApply']['intermediate_users']))+1;
							  }else{
								$degree = $applicant['JobseekerApply']['intermediate_users']+1;
							  } echo $degree;?></td>
					<td><?php // echo $applicant['networkers']['contact_name'];
							if($degree==1){ echo "Personal";} 
							if($degree>1){ echo "Hireroutes";} ?></td>
					<td align="center" width="10%">
						<?php
							
							echo $this->Html->image("/img/icon/ok.png", array(
								"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:22px;",
								'url' => "/companies/checkout/".$applicant['JobseekerApply']['id'],
								'title'=>'Accept'
							));
							
							echo $this->Html->image("/img/icon/delete.png", array(
							"alt" => "D","width"=>"24","height"=>"24","style"=>"margin-left:10px;",
							'url' => "javascript:void();",
							'onclick'=>'javascript:return deleteItem('.$applicant['JobseekerApply']['id'].','.$applicant['JobseekerApply']['job_id'].');',
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

function deleteItem(id,jobid){
	if (confirm("Are you sure to delete this?")){
		window.location.href="/companies/rejectApplicant/"+id+"/"+jobid;
	}
	return false;
}
</script>

