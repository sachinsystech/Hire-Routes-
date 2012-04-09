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
		if (!$('#NetworkersNotification').attr('checked')) {
			$("#email_setting").removeClass().addClass("js_terms-condition-error").html("Please Check for email notifications.*");
			return false;
		}
		if ($('#NetworkersNotification').attr('checked') && sel_val=='') {
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
			<?php echo $this->element('top_menu'); ?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="setting_sub_middleBox">
				<div class="form_content"  style="margin:auto;">
					<div><b>Add Subscriptions:</b></div>
					<?php echo $form->create('NetworkerSettings', array('id'=>'NetworkerSettingsForm','url' => '/networkers/setting')); ?>
					<div>
						<div style="float:left">
						<?php echo $form -> input('industry',array(
																	'type'=>'select',
																	'label'=>'',
																	'options'=>$industries,
																	'empty' =>' -- Select Industry-- ',
																	'style'=>'margin-left:0px;',
																	'class'=>'networker_select_bg required',
																	'onchange'=>'return fillSpecification(this.value,"NetworkerSettingsSpecification","specification_loader");'
															)
												);
						?>
						</div>
						<div id="specification_loader" style="float:left;"></div>
						<div style="float:right">
						<?php echo $form -> input('specification',array(
																	'type'=>'select',
																	'label'=>'',
																	'empty' =>' -- Select Specification-- ',
																	'class'=>'networker_select_bg'
															)
												);
						?>
						</div>
					</div>
					<div>
						<div style="float:left;margin-left: 43px;clear: both;">
							<?php echo $form -> input('state',array(
																		'type'=>'select',
																		'label'=>'Location: ',
																		'options'=>array('-1'=>' -- All States-- ',$states),
																		'class'=>'networker_select_state',
																		'onchange'=>'return fillCities(this.value,"NetworkerSettingsCity","city_loader");'
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
																		'class'=>'networker_select_city'
																)
													);
							?>							
						</div>
						<div style="float:right;margin-top: -15px;">
							<?php echo $form ->submit('Subscribe');?>
						</div>
					</div>	
						<?php echo $form->end(); ?>
				</div>
				
				<div style="clear: both; margin:auto;" >
					<b>Current Subscriptions:</b>
					
					
					<div id="accordion" style="width:620px">
						<?php
							$oldIndustry = null;
						?>
						<?php foreach($NetworkerData as $NSI): ?>
							<?php
								$indtemp = $NSI['ind']['name'];
							if($oldIndustry != $indtemp && $oldIndustry != null)
								echo "</div>";
							if($oldIndustry != $indtemp){
							?>
							<div>
								<span><?php echo $NSI['ind']['name']; ?></span>
							</div>
							<?php
							}
							if($oldIndustry != $indtemp){
							?>
							<div style="font-size: 14px;">
							<?php }
							$oldIndustry = $indtemp;
							?>
							<div style="margin-top:2px">
								<span><?php echo isset($NSI['spec']['name'])?$NSI['spec']['name']:"All Specifications"?>,
								<?php echo isset($NSI['state']['name'])?$NSI['state']['name']:"All Location"?>
								<?php echo isset($NSI['city']['name'])?", ".$NSI['city']['name']:""; ?></span>
								<span class="delete_spe" onclick="return deleteItem(<?php echo $NSI['NetworkerSettings']['id']?>);">Delete</span>
							</div>
							
						<?php endforeach;?>
							</div>
					</div>
					
				
				
				<div class="form_content">
				 <?php echo $form->create('', array('name'=>'Subscriptions','controller'=>'networkers','action' => 'sendNotifyEmail','onsubmit'=>'return check_email_subs();')); ?>
				
					<div>
						<?php	if(isset($SubscriptionData)){ $id = $SubscriptionData['id']; } else { $id = "";}
                                    echo $form->input('NetworkerSettings.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $id
																	)
														 );?>
						<div style="float:left;">	
							<?php echo $form->input('notification', array('label' => '',
																          'type'  => 'checkbox',
																		  'class' => '',
                                                                          'checked' => isset($SubscriptionData['notification'])?$SubscriptionData['notification']:"checked",
																		  'value' => isset($SubscriptionData['notification'])?$SubscriptionData['notification']:""));?>
							
							<span>I would like to receive job notifications by email based on my information:<span>
						</div>
						<div>
							<?php if(isset($SubscriptionData['notification']) && $SubscriptionData['notification']==1){
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
																              'selected' => isset($SubscriptionData['subscribe_email'])?$SubscriptionData['subscribe_email']:""));?>
							</div>
							<div id="email_setting" style="padding-left:400px;"></div>
						</div>
						<div>
							<?php echo $form ->submit('Save');?>
						</div>				
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
	$("#NetworkerSettingsForm").validate();
	$("#accordion").accordion();
}); 

 
function deleteItem($id){
	if (confirm("Are you sure to delete this?")){
		window.location.href="/networkers/delete/"+$id;
	}
	return false;
}

function saveSubFrequency(){
	var notifyId = $("#job_notification_email").val();
	window.location.href="/networkers/sendNotifyEmail/"+notifyId;
	return false;
}
</script>

