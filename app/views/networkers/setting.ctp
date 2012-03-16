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
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
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
																	'class'=>'networker_select_bg required'
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
//																		'options'=>$cities,
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
							//$indtemp2 = null;
						?>
						<?php foreach($NetworkerData as $NSI): ?>
							<?php
								$indtemp1 = $NSI['NetworkerSettings']['industry'];
							if($oldIndustry != $indtemp1 && $oldIndustry != null)
								echo "</div>";
							if($oldIndustry != $indtemp1){
							?>
							<div>
								<span><?php echo $industries[$NSI['NetworkerSettings']['industry']]; ?></span>
							</div>
							<?php
							}
							if($oldIndustry != $indtemp1){
							?>
							<div style="font-size: 14px;">
							<?php }
							$oldIndustry = $indtemp1;
							?>
								<div style="margin-top:2px">
									<span>Specification : <?php echo $specifications[$NSI['NetworkerSettings']['specification']]?>,
									State : <?php echo isset($states[$NSI['NetworkerSettings']['state']])?$states[$NSI['NetworkerSettings']['state']]:"All"?>,
									City : <?php echo ($NSI['NetworkerSettings']['city']!="")?$NSI['NetworkerSettings']['city']:"All"; ?></span>
									<span class="delete_spe" onclick="return deleteItem(<?php echo $NSI['NetworkerSettings']['id']?>);">Delete</span>
								</div>
							
						<?php endforeach;?>
							</div>
					</div>
					
				
				</div>
				<?php /* 
				<div class="form_content" style="clear: both; margin-left: 150px;">
					<b>Subscription Frequency:</b><p>
					<div style="float:left;">		
						<?php	echo $form->input('is_notify', array('label' => '<span style="font-size: 87%;">I would like to receive job notifications by email based on my network settings:<span>',
																		'type'  => 'checkbox',
																		)
													 );
						?>
					</div>
						
					<div style="float:right;">	
						<?php echo $form -> input('job_notification_email',array(
																	'type'=>'select',
																	'label'=>'',
																	'options'=>array('Every 10 Post','Every Day','Every 3 Days','Every Week'),
																	'class'=>'networker_select_job_notify'
															)
												);
						*/ ?>
					</div>
				</div>						   
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

