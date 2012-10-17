<?php ?>
<style>
div .checkbox{
	float:left;
	width:15px;
	margin-top:0px;
	overflow:auto;
	padding:0px;
}
</style>
<script>
	$(document).ready(function(){
	    $("#JobseekerSettingsNotification").click(onCheckChange);
	});
	
	function onCheckChange(){
		if ($('#JobseekerSettingsNotification').attr('checked')) {
			$("#subs_div").show();
		}else{
    		$("#subs_div").hide();
			$("select#JobseekerSettingsSubscribeEmail").val('0');
			$("#email_setting").html(""); 
		}
	}

	function check_email_subs(){
		var sel_val = $("#JobseekerSettingsSubscribeEmail").val();
		if ($('#JobseekerSettingsNotification').attr('checked') && sel_val=='') {
			$("#email_setting").removeClass().addClass("js_terms-condition-error").html("Please Select Email Settings for Job Notifications*");
			return false;
		}
	}	
</script>
	<div class="job_top-heading">
		<?php echo $this->element("welcome_name"); ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
      		<?php echo $this->element('side_menu');?>
            <div class="job_right_bar">
            	<div class="job-right-content">
                	<h2>SETTINGS/SUBSCRIPTIONS</h2>
                    <p>Tailor your subscription to receive job posts suited for your specific job experience and location.  Let us also know how frequently you would like to receive these posts.</p>
                 </div>   
                    <div class="jobseeker-settings">
						<?php echo $form->create('JobseekerSettings', array('id'=>'JobseekerSettingsForm','url' => '/jobseekers/setting','onsubmit'=>'return check_email_subs();')); ?>
						<?php echo $form->input('id', array('label' => '',
														'type'  => 'hidden',
														'value' => isset($jobseekerData['id'])?$jobseekerData['id']:""
																	));?>
						<div class="jobseeeker_seeting_name">
						<?php if(!isset($jobseekerData['contact_name'])){
							echo $form->input('Jobseekers.contact_name',
														 array('label' => false,
														  'type'  => 'text',
														  'placeholder'=>'Contact Name',
														  'class' => 'jobseekers_text required',
														  'name' => 'data[Jobseekers][contact_name]',
													));		
						}?>
						</div>											  
						<div id="industry_specification_1">
                    		<div class="industry-specification-1">
                        	    <div class="industries-select">
									<?php $industry_array = array('1'=>'Industry1',
																  '2'=>'Industry2',
																  '3'=>'Industry3',
																  '4'=>'Industry4');?>
								  	<?php echo $form -> input('industry_1',
								  									array('type'=>'select',
																	     'label'=>'Industry 1',
																	     'options'=>$industries,
																	     'empty' =>'Select Industry',
																	     'class'=>'jobseeker_select required',
																	     'selected' => isset($jobseekerData['industry_1'])?$jobseekerData['industry_1']:""));?>
								</div>
                           		<div class="industries-select multiple_select_box">
									<?php $industry_specification_array = 
																array('1'=>'Industry specification 1',
																		'2'=>'Industry specification 2',
																		'3'=>'Industry specification 3',
																		'4'=>'Industry specification 4');?>
									<?php echo $form -> input('industry_specification_1',
																	array('type'=>'select',
																	   'label'=>'',
																	   'multiple'=>'multiple',
																	   'size' => '4',
																	   'options'=>$specifications,
																	    'class'=>'jobseeker_select__i_s required multiple_select',
											                            'selected'=>isset($jobseekerData['specification_1'])?explode(",",$jobseekerData['specification_1']):""));?>
								</div>
								<div id="specification_1_loader" style="float:left;"></div>
							</div>			
						</div>

						<div id="industry_specification_1">
                    		<div class="industry-specification-1">
	                            <div class="industries-select">
								<?php echo $form -> input('industry_2',array('type'=>'select',
																	     'label'=>'Industry 2',
																	     'options'=>$industries,
																	     'empty' =>'Select Industry',
																	     'class'=>'jobseeker_select required',
																	     'selected' => isset($jobseekerData['industry_2'])?$jobseekerData['industry_2']:""));?>
								</div>
	                           	<div class="industries-select multiple_select_box">
								<?php echo $form -> input('industry_specification_2',array('type'=>'select',
																	                   'label'=>'',
																	                   'multiple'=>'multiple',
																	                   'size' => '4',
																	                   'options'=>$specifications,
																                   'class'=>'jobseeker_select__i_s required multiple_select',
											                                           'selected'=>isset($jobseekerData['specification_2'])?explode(",",$jobseekerData['specification_2']):""));?>
    	                       	</div>
    	                       	<div id="specification_2_loader" style="float:left;"></div>
							</div>
							
						</div>
						<div id="industry_specification_1">
                            <div class="industries-select jobseeker_settings_state">
<?php echo $form -> input('state',array(
											'type'=>'select',
											'label'=>'Location',
											'options'=>$states,
											'empty' =>'All States',
											'class'=>'js_select_ls',
											'onchange'=>'return fillCities(this.value,"JobseekerSettingsCity","city_loader");',
											'selected' => isset($jobseekerData['state'])?$jobseekerData['state']:""
									)
						);
?>
							</div>
                       		<div class="industries-select industries-select-right">
									<?php echo $form -> input('city',array(
																'type'=>'select',
																'label'=>'',
																'empty' =>'All Cities',
																'class'=>'js_select_city',
																'selected' => isset($jobseekerData['city'])?$jobseekerData['city']:""
																)
															);
									?>	
							</div>
							<div id="city_loader" style="float:left;">&nbsp;</div>
						</div>
						<div class="clr"></div>
						<div id="industry_specification_1">
                    		<div class="jobseeker_settings_salary textbox-name">
		                        <?php echo $form->input('salary_range', 
		                        							array('label' => 'Minimum Salary ($)',
																  'type'  => 'text',
																  'div'=> false,
																  'class' => 'jobseekers_text_salary_range required number',
																  'min' =>1000,
																  'value' => isset($jobseekerData['salary_range'])?$jobseekerData['salary_range']:""));?>   	

		                    	<?php $emil_post_array =array('3'=>'Every 3 Days','10'=>'Every 10 Post','1'=>'Every Day','7'=>'Every Week'); ?>
		                    </div>
		                    <div class="clr"></div>
		                    <div class="jobseeker_settings_notification">
		                    	<p>Job Notifications by Email</p>
								<?php echo $form -> input('subscribe_email',array('type'=>'select',
																	              'label'=>'',
																	              'div'=> false,
																	              //'empty'=>'Select',
																	              'options'=>$emil_post_array,
																	              'class'=>'networker_select_job_notify',
																	              'selected' => isset($jobseekerData['subscribe_email'])?$jobseekerData['subscribe_email']:""));?>
							</div>
						</div>
						<div class="jobseeker_setting_button">
							<?php  echo $form->submit('SAVE',array('div'=>false,
																	'type'=>'submit',
																	)); ?>
						</div>  
					<?php echo $form->end(); ?>       	
				</div>
			</div>
		</div>
		<div class="clr"></div>
		<div class="job_pagination_bottm_bar"></div>
	</div>
	<div class="clr"></div>
</div>
<!--------------------------->
<style>
div .checkbox{
	float:left;
	width:12px;
	margin-top:0px;
	overflow:auto;
}
</style>
<script>
	$(document).ready(function(){
	    $("#NetworkersNotification").click(onCheckChange);
	});
	
	function onCheckChange(){
		if ($('#NetworkersNotification').attr('checked')) {
			$("#subs_div").show();
		}else{
    		$("#subs_div").hide();
			$("select#NetworkersSubscribeEmail").val('0');
			$("#email_setting").html(""); 
		}

	}

	function check_email_subs(){
		var sel_val = $("#NetworkersSubscribeEmail").val();
		/*if (!$('#NetworkersNotification').attr('checked')) {
			$("#email_setting").removeClass().addClass("js_terms-condition-error").html("Please Check for email notifications.*");
			return false;
		}*/
		if (/*$('#NetworkersNotification').attr('checked') && */sel_val=='') {
			$("#email_setting").removeClass().addClass("js_terms-condition-error").html("Please Select Email Settings for Job Notifications*");
			return false;
		}
	}	
</script>

<script>
$("#JobseekerSettingsForm").validate();
$("input[type=submit]").submit(function(){
	$("#JobseekerSettingsForm").validate();
	$(this).attr("disabled", "true");
});
</script>
<?php $industry_1 = isset($jobseekerData['industry_1'])?$jobseekerData['industry_1']:1;?>
<?php $industry_2 = isset($jobseekerData['industry_2'])?$jobseekerData['industry_2']:1;?>
<?php $state = isset($jobseekerData['state'])?$jobseekerData['state']:null;?>
<script>
$(document).ready(function(){
	<?php if(isset($jobseekerData['industry_1'])){?>
		//fillSpecification(<?php echo $industry_1;?>, 'JobseekerSettingsIndustrySpecification1', 'specification_1_loader');
	<?php $specification_1=explode(",",$jobseekerData['specification_1']);
		foreach($specification_1 as $key=>$specification_id)
		{
	?>
	$("select#JobseekerSettingsIndustrySpecification1 option[value=<?php echo $specification_id;?>]").attr('selected', 'selected');
	<?php
		}
	}
	?>
	<?php if(isset($jobseekerData['industry_2'])){?>
	//fillSpecification(<?php echo $industry_2;?>, 'JobseekerSettingsIndustrySpecification2', 'specification_2_loader');
	<?php $specification_2=explode(",",$jobseekerData['specification_2']);
		foreach($specification_2 as $key=>$specification_id)
		{?>
	$("select#JobseekerSettingsIndustrySpecification2 option[value=<?php echo $specification_id;?>]").attr('selected', 'selected');
	<?php 
		}
	}
	?>
	<?php if(isset($jobseekerData['city'])&&!empty($jobseekerData['city'])){?>
	fillCities(<?php echo $state;?>,'JobseekerSettingsCity','city_loader');
	$("select#JobseekerSettingsCity option[value=<?php echo $jobseekerData['city'];?>]").attr('selected', 'selected');
	<?php 
	}
	?>
});
</script>
<style>
.industries-select select{
	width:150px;
	height:auto;
}
</style>
