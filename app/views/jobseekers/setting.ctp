<?php ?>
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
		<div class="jobseeker_setting_middleBox">
			<?php if($jobseekerData):?>
				<div>Welcome back, <?php echo $jobseekerData['name'];?>!</div>
			<?php endif;?>
			<div class="form_content"  style="margin:auto;">
				<?php echo $form->create('JobseekerSettings', array('id'=>'JobseekerSettingsAddForm','url' => '/jobseekers/setting','onsubmit'=>'return check_email_subs();')); ?>
					<?php echo $form->input('id', array('label' => 'Your Name',
														'type'  => 'hidden',
														'value' => isset($jobseekerData['id'])?$jobseekerData['id']:""
																	));?>
					<?php echo $form->input('name', array('label' => 'Your Name',
														  'type'  => 'text',
														  'class' => 'jobseekers_text required',
														  'value' => isset($jobseekerData['name'])?$jobseekerData['name']:""));?>
					<div id="industry_specification_1">
						<div style="float:left;margin-left: -7px;clear: both;">
							<?php $industry_array = array('1'=>'Industry1',
														  '2'=>'Industry2',
														  '3'=>'Industry3',
														  '4'=>'Industry4');?>
						  	<?php echo $form -> input('industry_1',array('type'=>'select',
																	     'label'=>'Industry 1:',
																	     'options'=>$industries,
																	     'empty' =>' -- Select Industry-- ',
																	     'onchange'=>'return fillSpecification(this.value,"JobseekerSettingsIndustrySpecification1","specification_1_loader");',
																	     'class'=>'jobseeker_select required',
																	     'selected' => isset($jobseekerData['industry_1'])?$jobseekerData['industry_1']:""));?>
						</div>
						<div id="specification_1_loader" style="float:left;"></div>
						<div style="float:left;width: 270px;">
							<?php $industry_specification_array = array('1'=>'Industry specification 1',
																		'2'=>'Industry specification 2',
																		'3'=>'Industry specification 3',
																		'4'=>'Industry specification 4');?>
							<?php echo $form -> input('industry_specification_1',array('type'=>'select',
																					   'label'=>'',
																	                   'multiple'=>'multiple',
																	                   'size' => '4',
																	                   //'options'=>$specifications,
																	                   'class'=>'jobseeker_select__i_s required',
											                                           'selected'=>isset($jobseekerData['specification_1'])?explode(",",$jobseekerData['specification_1']):""));?>
						</div>
					</div>
					<div>
						<div style="float:left;margin-left: -7px;clear: both;">
							<?php echo $form -> input('industry_2',array('type'=>'select',
																	     'label'=>'Industry 2:',
																	     'options'=>$industries,
																	     'empty' =>' -- Select Industry-- ',
																	     'onchange'=>'return fillSpecification(this.value,"JobseekerSettingsIndustrySpecification2","specification_2_loader");',
																	     'class'=>'jobseeker_select required',
																	     'selected' => isset($jobseekerData['industry_2'])?$jobseekerData['industry_2']:""));?>
						</div>
						<div id="specification_2_loader" style="float:left;"></div>
						<div style="float:left;width: 270px;">
							<?php echo $form -> input('industry_specification_2',array('type'=>'select',
																	                   'label'=>'',
																	                   'multiple'=>'multiple',
																	                   'size' => '4',
																	                   //'options'=>$specifications,
																	                   'class'=>'jobseeker_select__i_s required',
											                                           'selected'=>isset($jobseekerData['specification_2'])?explode(",",$jobseekerData['specification_2']):""));?>
						</div>
					</div>
					
							  <!-- 	Location :: State wise cities....	-->
	  
 <div style="float:left;margin-left: 0px;clear: both;">
<?php echo $form -> input('state',array(
											'type'=>'select',
											'label'=>'Location: ',
											'options'=>$states,
											'empty' =>' -- All States-- ',
											'class'=>'js_select_ls required',
											'onchange'=>'return fillCities(this.value,"JobseekerSettingsCity","city_loader");',
											'selected' => isset($jobseekerData['state'])?$jobseekerData['state']:""
									)
						);
?>
</div>
<div id="city_loader" style="float:left;">&nbsp;</div>
<div style="float:left;">
<?php echo $form -> input('city',array(
											'type'=>'select',
											'label'=>'',
											'empty' =>' -- All Cities-- ',
											'class'=>'js_select_city',
											'selected' => isset($jobseekerData['city'])?$jobseekerData['city']:""
									)
						);
?>							
</div>
	  
	  
      <!-- 	End of Location fields...	-->
	  
	  <div style=" clear :both;">
	
					
					
					
					<div style=" clear :both;">
						<?php $salary_array = array('25'=>'20K-30K','35'=>'30K-40K','45'=>'40K-50K','55'=>'50K-60K'); ?>
						<?php // echo $form -> input('salary_range',array('type'=>'select',
							  //										   'label'=>'Annual Salary Range',
							  //										   'options'=>$salary_array,
							  //										   'class'=>'jobseeker_select_salary',
							  //										   'selected' => isset($jobseekerData['salary_range'])?$jobseekerData['salary_range']:""));?>
						<?php echo $form->input('salary_range', array('label' => 'Annual Salary Range ($):',
																  'type'  => 'text',
																  'class' => 'jobseekers_text_salary_range required number',
																  'min' =>1000,
																  'value' => isset($jobseekerData['salary_range'])?$jobseekerData['salary_range']:""));?>
					<div>
						<b>Subscription Frequency:</b><p>
						<div style="float:left;margin-top: 8px;width: 616px;">
							<?php if(isset($jobseekerData['notification']) && $jobseekerData['notification']==1){?>
							<?php echo $form->input('notification', array('label' => '',
																          'type'  => 'checkbox',
																		  'class' => '',
                                                                          'checked' => 'checked',
																		  'value' => isset($jobseekerData['notification'])?$jobseekerData['notification']:""));?>
							<?php }else{ ?>
							<?php echo $form->input('notification', array('label' => '',
																          'type'  => 'checkbox',
																          'class' => '',));?>
							<?php }?>
							<span style=" margin-left:10px;font-size: 87%;">I would like to receive job notifications by email based on my information:<span>
							<div style="float:right;margin-top: -12px;width: 129px;">
							<?php if(isset($jobseekerData['notification']) && $jobseekerData['notification']==1){
									$style = '';
								}else{
									$style = 'style="display:none;"';
							 	}?>
							<?php $emil_post_array =array(''=>'Please Select','10'=>'Every 10 Post','1'=>'Every Day','3'=>'Every 3 Days','7'=>'Every Week'); ?>
							<div id="subs_div" <?php echo $style;?>>
								<?php echo $form -> input('subscribe_email',array('type'=>'select',
																              'label'=>'',
																              'options'=>$emil_post_array,
																              'class'=>'networker_select_job_notify',
																              'selected' => isset($jobseekerData['subscribe_email'])?$jobseekerData['subscribe_email']:""));?>
							</div>
							<div id="email_setting"></div>
						</div>
							
							
						</div>
						
					</div>
					<?php echo $form ->submit('Save');?>
					<?php echo $form->end(); ?>
				</div>
			</div>
		</div>
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->
</div>
<script>
$("#JobseekerSettingsAddForm").validate();
</script>
<?php $industry_1 = isset($jobseekerData['industry_1'])?$jobseekerData['industry_1']:1;?>
<?php $industry_2 = isset($jobseekerData['industry_2'])?$jobseekerData['industry_2']:1;?>
<?php $state = $jobseekerData['state'];?>
<script>
$(document).ready(function(){
	<?php if(isset($jobseekerData['industry_1'])){?>
		fillSpecification(<?php echo $industry_1;?>, 'JobseekerSettingsIndustrySpecification1', 'specification_1_loader');
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
	fillSpecification(<?php echo $industry_2;?>, 'JobseekerSettingsIndustrySpecification2', 'specification_2_loader');
	<?php $specification_2=explode(",",$jobseekerData['specification_2']);
		foreach($specification_2 as $key=>$specification_id)
		{?>
	$("select#JobseekerSettingsIndustrySpecification2 option[value=<?php echo $specification_id;?>]").attr('selected', 'selected');
	<?php 
		}
	}
	?>
	<?php if(isset($jobseekerData['industry_2'])){?>
	fillCities(<?php echo $state;?>,'JobseekerSettingsCity','city_loader');
	$("select#JobseekerSettingsCity option[value=<?php echo $jobseekerData['city'];?>]").attr('selected', 'selected');
	<?php 
	}
	?>
});
</script>
