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
                                                      'onchange'=>'return fillSpecification(this.value);',
                                                      'selected' => isset($job['industry'])?$job['industry']:""
                                              )
                                  );
          ?>
      </div>
      <div id="specification_loader" style="float:left;width:20px;"></div>
      <div style="float:left;">
          <?php echo $form -> input('specification',array(
                                                      'type'=>'select',
                                                      'label'=>'',
                                                      'empty' =>' -- Select Specifications-- ',
                                                      //'options'=>$specifications,
                                                      'class'=>'job_select__i_s required',
													  'selected'=>isset($job['specification'])?$job['specification']:""
                                              )
                                  );
          ?>
      </div>
    </div>

<?php /*?>
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
	
	<?php */?>
	
	<?php $state_val = $job['state']; ?>
	
		  <!-- 	Location :: State wise cities....	-->
	  
 <div style="float:left;margin-left: 0px;clear: both;">
<?php echo $form -> input('state',array(
											'type'=>'select',
											'label'=>'Location: ',
											'options'=>$states,
											'empty' =>' -- All States-- ',
											'class'=>'pj_select_ls required',
											'onchange'=>'return fillCities(this.value);',
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

<script>
	
$(document).ready(function(){

	fillSpecification(<?php echo $job['industry'];?>);
	$("select#JobSpecification option[value=<?php echo $job['specification'];?>]").attr('selected', 'selected');
	var city_id = <?php echo $job['city'];?>;
	fillCities(<?php echo $job['state'];?>);
	$("select#JobCity option[value=<?php echo $job['city'];?>]").attr('selected', 'selected');
	$("#JobEditJobForm").validate();
	
});

function fillSpecification($industry_id)
{
	$('#JobSpecification option').each(function(i, option){ $(option).remove(); });
	$.ajax({
		url: "/utilities/getSpecificationOfIndustry/"+$industry_id,
	 	dataType:'json',
	 	async:false,
	 	beforeSend: function(){
     		$('#specification_loader').html('<img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..." />');
		},
		complete: function(){
   	    	$('#specification_loader').html("");
		},
  		success: function(response){
	 		document.getElementById('JobSpecification').options[0]=new Option("--All Specification--",'');
			$.each(response, function(index, specification) {
				document.getElementById('JobSpecification').options[document.getElementById('JobSpecification').options.length] = new Option(specification, index);
            });
  		}
	});
}
	
function fillCities($state_id)
{
	$.ajax({
		url: "/utilities/getCitiesOfState/"+$state_id,
	 	dataType:'json',
		async:false,
		beforeSend: function(){
     		$('#city_loader').html('<img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..." />');
		},
		complete: function(){
   	    	$('#city_loader').html("");
		},
  		success: function(response){
	 		var options = '<option value=""> -- All Cities-- </option>';
			$.each(response, function(index, item) {
                options += '<option value="' + index + '">' + item + '</option>';
            });
			$("select#JobCity").html(options);
  		}
	});
	
}
</script>






