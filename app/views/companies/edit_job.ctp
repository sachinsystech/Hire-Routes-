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

<script>
	$(document).ready(function(){
		$("#JobEditJobForm").validate();
	});

</script>

<div style="width:600px;margin: auto;">
<div style="width:300px; margin: 4px 0;">Job URL <input type="text" class='text_field_bg' value="<?php echo Configure::read('httpRootURL')."job/".$job['id']."/".$code; ?>"></div>
<div style="clear:both"></div>
<div class="sigup_heading">Edit Posted Job </div>
<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'editJob'))); ?>
	<?php	echo $form->input('id', array('label' => '',
											'type'  => 'hidden',
											'value' => $job['id']
											)
                                 );
    ?>
	<?php	echo $form->input('title', array('label' => 'Title:',
                                           			'type'  => 'text',
													'class' => 'text_field_job_title required',
                                                    'value' => isset($job['title'])?$job['title']:""
													
                                           			)
                                 );
    ?>

	<?php	echo $form->input('reward', array('label' => 'Reward$:',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required number',
                                                    'value' => isset($job['reward'])?$job['reward']:""
													
                                           			)
                                 );
    ?>
	<?php	echo $form->input('short_description', array('label' => 'Short_Description:',
                                           			'type'  => 'textarea',
													'class' => 'textarea_bg_job required',
													'value' => isset($job['short_description'])?$job['short_description']:""													
                                           			)
                                 );
    ?>


    <div>
      <div style="float:left;margin-left: -7px;clear: both;">
          <?php echo $form -> input('industry',array(
                                                      'type'=>'select',
                                                      'label'=>'Category',
                                                      'options'=>$industries,
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select_i required',
                                                      'selected' => isset($job['industry'])?$job['industry']:""
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
													  'selected'=>isset($job['specification'])?$job['specification']:""
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
                                                      'value' => isset($job['city'])?$job['city']:""
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
                                                    'selected' => isset($job['state'])?$job['state']:""
                                            )
                                );
          ?>
      </div> 
    </div>
    <div style="clear: both;"></div>
	<div class="salary_range">
		<div style="width: 130px;float:left">Annual salary Range</div>
		<div style="width: 130px;float:left">	
			<?php	echo $form->input('salary_from', array('label' => 'From',
                                           			'type'  => 'text',
													'class' => 'job_text_field_from required number',
													'value' => isset($job['salary_from'])?$job['salary_from']:""
                                           			)
                                 );
    		?>
    	</div>
		<div style="width: 130px;float:left">	
			<?php	echo $form->input('salary_to', array('label' => 'To',
                                           			'type'  => 'text',
													'class' => 'job_text_field_from required number',
													'value' => isset($job['salary_to'])?$job['salary_to']:""													
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
                                                      'selected' => $job['job_type']
                                              )
                                  );
    ?>
	<?php	echo $form->input('description', array('label' => 'Description:',
                                           			'type'  => 'textarea',
													'class' => 'textarea_bg_job required',
													'value' => isset($job['description'])?$job['description']:""
                                           			)
                                 );
    ?>
      <div style="clear: both;"></div>

	<?php echo $form->submit('Save',array('div'=>false,)); ?>
 <?php echo $form->end(); ?>
 </div>
 </div>
												
			</div>
	
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>









