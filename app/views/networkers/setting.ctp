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
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li  class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/"><span>My Account</span></a></li>
			</ul>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
				<li class="active"><a  style="text-decoration:none" href="/networkers/setting">Settings/Subscription</a></li>	
				<li><a style="text-decoration:none" href="/networkers">Profile</a></li>			
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="setting_sub_middleBox">
				<div class="form_content"  style="margin:auto;">
					<div><b>Add Subscriptions:</b></div>
					<?php echo $form->create('Networkers', array('action' => 'add')); ?>
					<div>
						<div style="float:left">
						<?php echo $form -> input('industry',array(
																	'type'=>'select',
																	'label'=>'',
																	'options'=>$industries,
																	'empty' =>' -- Select Industry-- ',
																	'class'=>'networker_select_bg required'
															)
												);
						?>
						</div>
						<div style="float:right">
						<?php echo $form -> input('specification',array(
																	'type'=>'select',
																	'label'=>'',
																	'options'=>$specifications,
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
																		'options'=>$states,
																		'empty' =>' -- All States-- ',
																		'class'=>'networker_select_state',
																		'onchange'=>'return fillCities(this.value);'
																)
													);
							?>
						</div>
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
				
				<div style="clear: both; margin:auto;" class="form_content">
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
					
				
				</div>
				 <?php echo $form->create('', array('name'=>'Subscriptions','controller'=>'networkers','action' => 'sendNotifyEmail','onsubmit'=>'return check_email_subs();')); ?>
				<div class="form_content">
					<div>
						<?php	if(isset($SubscriptionData)){ $id = $SubscriptionData['id']; } else { $id = "";}
                                    echo $form->input('Networkers.id', array('label' => '',
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
				</div>
				<?php echo $form->end(); ?>						   
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->
</div>
<script>
$(document).ready(function(){
	$("#NetworkersAddForm").validate();
	$("#accordion").accordion();
}); 

 
function deleteItem($id){
	if (confirm("Are you sure to delete this?")){
		window.location.href="/networkers/delete/"+$id;
	}
	return false;
}

function fillCities($state_id)
{
	$.ajax({
		url: "/utilities/getCitiesOfState/"+$state_id,
	 	dataType:'json',
  		success: function(response){
	 		var options = '<option value=""> -- All Cities-- </option>';
			$.each(response, function(index, item) {
                options += '<option value="' + index + '">' + item + '</option>';
            });
			$("select#NetworkersCity").html(options);
  		}
	});
}

function saveSubFrequency(){
	var notifyId = $("#job_notification_email").val();
	window.location.href="/networkers/sendNotifyEmail/"+notifyId;
	return false;
}
</script>

