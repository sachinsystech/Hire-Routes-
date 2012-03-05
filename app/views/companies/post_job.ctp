<?php ?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
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
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="job_middleBox">
												
<div style="width:600px;margin: auto;">
<div class="sigup_heading">Post  New Job </div>
<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'save'))); ?>
	<?php	echo $form->input('title', array('label' => 'Title:',
													'type'  => 'text',
													'class' => 'text_field_job_title required'
													)
								 );
	?>

	<?php	echo $form->input('reward', array('label' => 'Reward$:',
													'type'  => 'text',
													'class' => 'text_field_bg required number',
													'min' =>2000,
													)
								 );
	?>
	<?php	echo $form->input('short_description', array('label' => 'Short_Description:',
													'type'  => 'textarea',
													'class' => 'textarea_bg_job required',
													)
								 );
	?>


	<div>
	  <div style="float:left;margin-left: -7px;clear: both;">
		  <?php $industry_array = array('1'=>'Industry1','2'=>'Industry2','3'=>'Industry3','4'=>'Industry4');?>
		  <?php echo $form -> input('industry',array(
													  'type'=>'select',
													  'label'=>'Category',
													  'options'=>$industries,
													  'empty' =>' -- Select Industry-- ',
													  'class'=>'jobseeker_select_i required',
											  )
								  );
		  ?>
	  </div>
	  <div style="float:left;">
		  <?php echo $form -> input('specification',array(
													  'type'=>'select',
													  'label'=>'',
													  'options'=>$specifications,
													  'class'=>'job_select__i_s required',
											  )
								  );
		  ?>
	  </div>
	</div>


	<div style=" clear :both;">
	  <div style="float: left; width: 302px;">
		  <?php echo $form->input('city', array('label' => 'Location:',
													  'type'  => 'text',
													  'class' => 'job_text_location required',
													  //'value' => isset($jobseekerData['city'])?$jobseekerData['city']:""
													  )
								   );
		  ?>
	  </div>
	  <div style="float:left">
		  <?php echo $form -> input('state',array(
													'type'=>'select',
													'label'=>'',
													'options'=>$states,
													'empty' =>' -- Select state-- ',
													'class'=>'job_select_state required',
											)
								);
		  ?>
	  </div> 
	</div>
	  <div style="clear: both;"></div>
	<div>
		<div style="width: 130px;float:left">Annual salary Range</div>
		<div style="width: 130px;float:left">	
			<?php	echo $form->input('salary_from', array('label' => 'From',
													'type'  => 'text',
													'class' => 'job_text_field_from required number',
													)
								 );
			?>
		</div>
		<div style="width: 130px;float:left">	
			<?php	echo $form->input('salary_to', array('label' => 'To',
													'type'  => 'text',
													'class' => 'job_text_field_from required number',
													)
								 );
			?>
		</div>
	</div>
	  <div style="clear: both;"></div>
	<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
	<?php echo $form -> input('job_type',array(
													  'type'=>'select',
													  'label'=>'Job Type',
													  'options'=>$job_array,
													  'class'=>'job_select_job_type required',
											  )
								  );
		  ?>
	<?php	echo $form->input('description', array('label' => 'Description:',
													'type'  => 'textarea',
													'class' => 'textarea_bg_job required',
													)
								 );
	?>
	  <div style="clear: both;"></div>
<div style="text-align:center">
	<?php echo $form->submit('Save for Later',array('div'=>false,'name'=>'save','value'=>'later')); ?>
	<?php echo $form->submit('Post and Share Job with Network',array('div'=>false,'name'=>'save','value'=>'share')); ?>
</div>
 <?php echo $form->end(); ?>
 </div>
												
			</div>
	
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>



<script>
	$(document).ready(function(){
		$("#JobPostJobForm").validate();
	});

</script>

