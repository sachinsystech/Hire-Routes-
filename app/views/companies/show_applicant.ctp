<?php echo $this->Session->flash();?>
<script>
function valid_form(){
	answer1 = $("#UserAnswer1").val();
	answer2 = $("#UserAnswer2").val();
	answer3 = $("#UserAnswer3").val();
	answer4 = $("#UserAnswer4").val();
	answer5 = $("#UserAnswer5").val();
	answer6 = $("#UserAnswer6").val();
	answer7 = $("#UserAnswer7").val();
	answer8 = $("#UserAnswer8").val();
	answer9 = $("#UserAnswer9").val();
	answer10 = $("#UserAnswer10").val();
	if(answer1==="" && answer2==="" && answer3==="" && answer4==="" && answer5==="" && answer6==="" && answer7==="" && answer8==="" && answer9==="" && answer10===""){
		$("#error_div").removeClass().addClass("js_terms-condition-error").html("Please Select Atleast One Option to Filter Results.*");
		return false;
	}
}

function clear_div(val){
	if(val!=""){
		$("#error_div").html(""); 
	}
}
		
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>		
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		    <div class="middleBox">
			<?php echo $form->create('', array('url' => array('controller' => 'companies', 'action' => 'showApplicant/'.$jobId),'name'=>'webform','onsubmit'=>'return valid_form();'));?>
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
															 'onChange'=>"return clear_div(this.value);"));?>
				</div> 

				<div style="float:left;" id="lbl">Work Experience</div>
				<div style="float:left;" id="field">
					<?php $answer2_array = array(''=>'Select','0 to 2 year'=>'0 to 2 year','2 to 5 year'=>'2 to 5 year','More than 5 year'=>'More than 5 year'); 
                          echo $form->input('answer2', array('label'   => '',
															 'type'    => 'select',
															 'class'   => 'show_appl_filter_select',
															 'options' =>$answer2_array,
															 'value'   => isset($filterOpt['answer2'])?$filterOpt['answer2']:"",
															 'onChange'=>"return clear_div(this.value);"));?>
				</div> 

				<div style="float:left;" id="lbl">Current CTC</div>
				<div style="float:left;" id="field">
					<?php	$answer3_array = array(''=>'Select','Less than 1,20,000'=>'Less than 1,20,000','1,20,000 to 3,60,000'=>'1,20,000 to 3,60,000','More than 3,60,000'=>'More than 3,60,000'); 
							echo $form->input('answer3', array('label'   => '',
															   'type'    => 'select',
                                                               'class'   => 'show_appl_filter_select',
															   'options' =>$answer3_array,
															   'value'   => isset($filterOpt['answer3'])?$filterOpt['answer3']:"",
																'onChange'=>"return clear_div(this.value);"
															   ));?>
				</div>
 
				<div style="float:left;" id="lbl">Expected CTC</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer4', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer3_array,
															 'value'   => isset($filterOpt['answer4'])?$filterOpt['answer4']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
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
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
				</div>
 
				<div style="float:left;" id="lbl">Ready to relocate</div>
				<div style="float:left;" id="field">
					<?php $answer6_array = array(''=>'Select','Yes'=>'Yes','No'=>'No'); 
                      	  echo $form->input('answer6', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer6'])?$filterOpt['answer6']:"",
															 'onChange'=>"return clear_div(this.value);"
															));?>
				</div>
 
				<div style="float:left;" id="lbl">Shifts Availability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer7', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
									                         'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer7'])?$filterOpt['answer7']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
				</div>
 
				<div style="float:left;" id="lbl">Passport Availability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer8', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer8'])?$filterOpt['answer8']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
				</div>
 
				<div style="float:left;" id="lbl">Travel Ability</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer9', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer6_array,
															 'value'   => isset($filterOpt['answer9'])?$filterOpt['answer9']:"",
														     'onChange'=>"return clear_div(this.value);"
															 ));?>
				</div> 

				<div style="float:left;" id="lbl">Training Needs</div>
				<div style="float:left;" id="field">
					<?php echo $form->input('answer10', array('label'   => '',
															  'type'    => 'select',
                                                              'class'   => 'show_appl_filter_select',
															  'options' =>$answer6_array,
															  'value'   => isset($filterOpt['answer10'])?$filterOpt['answer10']:"",
															  'onChange'=>"return clear_div(this.value);"
															 ));?>
				</div> 				
			</div>			
			<div style="float:right;margin:20px">
				<div id="error_div"></div>
				<?php	echo $form->submit('Search',array('div'=>false,)); ?>	
			</div>
			<?php echo $form->end();?>
			<table style="width:100%">
				<tr>
					<td colspan="100%">
						<div style="float:right;width:50%;text-align: right;">
						<?php $this->Paginator->options(array('url' =>$jobId));?>
						<?php echo $paginator->first(' << ', null, null, array("class"=>"disableText"));?>
						<?php echo $this->Paginator->prev(' < ', null, null, array("class"=>"disableText")); ?>
						<?php echo $this->Paginator->numbers(array('modulus'=>4)); ?>
						<?php echo $this->Paginator->next(' > ', null, null, array("class"=>"disableText")); ?>
						<?php echo $paginator->last(' >> ', null, null, array("class"=>"disableText"));?>
						</div>
					</td>
				</tr>
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
								$degree = count(explode(",",$applicant['JobseekerApply']['intermediate_users']));
							  }else{
								$degree = 0;
							  } echo $degree+1;?></td>
					<td><?php // echo $applicant['networkers']['contact_name'];
							if($applicant['User']['parent_user_id']==$applicant['Job']['user_id']||$degree==0){
							 echo "Personal";
							 }else{
							 	echo "Hireroutes";
							 } ?></td>
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
	if (confirm("Are you sure to Reject?")){
		window.location.href="/companies/rejectApplicant/"+id+"/"+jobid;
	}
	return false;
}
</script>

