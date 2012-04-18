<?php ?>
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
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="job_middleBox">


<div style="width:600px;margin: auto;">
<div style="width:300px; margin: 4px 0;">Job URL <input type="text" class='text_field_bg' value="<?php echo Configure::read('httpRootURL')."job/".$job['id']."/"; ?>"></div>
<div style="clear:both"></div>
<div class="sigup_heading">Edit Posted Job </div>
<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'editJob',$job['id']))); ?>
	<?php	echo $form->input('Job.id', array('label' => '',
											'type'  => 'hidden',
											'value' => $job['id']
											)
                                 );
    ?>
	<?php	echo $form->input('Job.title', array('label' => 'Title:',
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
                                                      'onchange'=>'return fillSpecification(this.value,"JobSpecification","specification_loader");',
                                                      'selected' => isset($job['industry'])?$job['industry']:""
                                              )
                                  );
          ?>
      </div>
      <div id="specification_loader" style="float:left;"></div>
      <div style="float:left;">
          <?php echo $form -> input('specification',array(
                                                      'type'=>'select',
                                                      'label'=>'',
                                                      'empty' =>' -- Select Specifications-- ',
                                                      'class'=>'job_select__i_s required',
													  'selected'=>isset($job['specification'])?$job['specification']:""
                                              )
                                  );
          ?>
      </div>
    </div>
	<?php $state_val = $job['state']; ?>
	
		  <!-- 	Location :: State wise cities....	-->
	  
 <div style="float:left;margin-left: 0px;clear: both;">
<?php echo $form -> input('state',array(
											'type'=>'select',
											'label'=>'Location: ',
											'options'=>$states,
											'empty' =>' -- All States-- ',
											'class'=>'pj_select_ls required',
											'onchange'=>'return fillCities(this.value,"JobCity","city_loader");',
											'selected' => isset($job['state'])?$job['state']:""
									)
						);
?>	
</div>
<div id="city_loader" style="float:left;"></div>
<div style="float:left;">
<?php echo $form -> input('city',array(
											'type'=>'select',
											'label'=>'',
											'empty' =>' -- All Cities-- ',
											'class'=>'job_select__i_s',
											'selected' => isset($job['city'])?$job['city']:""
									)
						);
?>							
</div>
	  
	  
      <!-- 	End of Location fields...	-->
	  
	  <div style=" clear :both;">
	
	
	<div class="salary_range">
		<div style="width: 130px;float:left"><label>Annual salary Range ($):</label></div>
		<div style="width: 150px;float:left;padding:0;margin:0;">	
			<?php	echo $form->input('salary_from', array('label' => 'From',
                                           			'type'  => 'text',
													'class' => 'job_text_field_from required number',
													'value' => isset($job['salary_from'])?$job['salary_from']:""
                                           			)
                                 );
    		?>
    	</div>
    	<div style="float:left;width:55px;">a year</div>
		<div style="width: 130px;float:left;padding:0;margin:0;">	
			<?php	echo $form->input('salary_to', array('label' => 'To',
                                           			'type'  => 'text',
													'class' => 'job_text_field_from required number',
													'value' => isset($job['salary_to'])?$job['salary_to']:""													
                                           			)
                                 );
    		?>
    	</div>
    	<div style="float:left;width:55px;">a year</div>
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
<script>
	$("#JobEditJobForm").validate();
</script>
<script>
	
$(document).ready(function(){
	<?php if(isset($job['industry'])){?>
	fillSpecification(<?php echo $job['industry'];?>,"JobSpecification","specification_loader");
	$("select#JobSpecification option[value=<?php echo $job['specification'];?>]").attr('selected', 'selected');
	<?php 
	}
	?>
	<?php if(isset($job['state'])){?>
	fillCities(<?php echo $job['state'];?>,"JobCity","city_loader");
	$("select#JobCity option[value=<?php echo $job['city'];?>]").attr('selected', 'selected');
	<?php
	}
	?>
});
</script>






