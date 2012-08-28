	<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
      		<?php echo $this->element('side_menu');?>
            <div class="job_right_bar">
            	<div class="job-right-content">
                	<h2>SETTINGS/SUBSCRIPTIONS</h2>
                    <p>This is where some text can go to explain what this section is for and can go onto a second line but I wouldnt go much farther</p>
                 </div>  
                 <!------------------------------------->
                 <div class="job-subs">
                    <?php echo $form->create('NetworkerSettings', array('id'=>'NetworkerSettingsForm','url' => '/networkers/setting')); ?>

                    	<div class="job-subs-left">
                        	<p>Industries</p>
                            <div class="industries-select">
                                <?php echo $form -> input('industry',array(
																	'type'=>'select',
																	'label'=>false,
																	'value'=>'1',
																	'style'=>'margin-left:0px;',
																	'class'=>'required',
																	'div'	=> false,
																	'onchange'=>'return fillSpecification(this.value,"NetworkerSettingsSpecification","specification_loader");'
															)
												);
								?>
                            </div>
                            <div class="clr"></div>
                            <p>State</p>
                            <div class="state-select">
	                			<?php echo $form -> input('state',array(
													'type'=>'select',
													'label'=>false,
													'empty' =>' All States ',
													'options'=>array($states),
													'class'=>'networker_select_state',
													'onchange'=>'return fillCities(this.value,"NetworkerSettingsCity","city_loader");',
													'div'=> false,
													)
											);
								?>
                            </div>
                        </div>
                    
                    		<div class="job-subs-left">
                        		<p>Specifications</p>
                            	<div class="industries-select">
									<?php echo $form -> input('specification',array(
																			'type'=>'select',
																			'label'=>false,
																			'empty' =>'Select Specification',
																			'class'=>'setting_specification',
																			'after'	=>'<div id="specification_loader"></div>',
																			'div'=> false,
																	)
														);
									?>
                            	</div>
                            	<div class="clr"></div>
                            	<p>City</p>
                            	<div class="industries-select">
									<?php echo $form -> input('city',array(
															'type'=>'select',
															'label'=>false,
															'empty' =>' All Cities ',
															'class'=>'networker_select_city setting_specification',
															'after'	=>'<div id="city_loader"></div>',
															'div'	=> false,
													)
											);
									?>
                            	</div>
                        	</div>
                            	<div class="login-button job-subscribe">
							<input type="submit" value="SUBSCRIBE">
							<div class="clr"></div>
						</div>
						<?php echo $form->end(); ?>												
                      </div>
                 
                 <!-----------------------------------------------------> 
					<div class="job-current-subs">
						<?php echo $form->create('Networkers', array('name'=>'Subscriptions',
															'controller'=>'networkers',
															'action' => 'sendNotifyEmail',
															'onsubmit'=>'return check_email_subs();')); ?>
						<?php if(!empty($NetworkerData)):?>															
                  		<h2>CURRENT SUBSCRIPTIONS</h2>
                  		<?php endif;?>
                  		<?php $oldIndustry = null; ?>
                  		
                  		<ul>
                  		<?php foreach($NetworkerData as $NSI): ?>
							<?php
								$indtemp = $NSI['ind']['name'];
							if($oldIndustry != $indtemp && $oldIndustry != null)
								echo "</div>";
							if($oldIndustry != $indtemp){
							?>
							<li>
								<div class="job-subs-table-left"><?php echo $NSI['ind']['name']; ?></div>
							</li>
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
								<div class="job-subs-table-right"><a href="#" onclick="return deleteItem(<?php echo $NSI['NetworkerSettings']['id']?>);">delete</a></div>
							</div>
							
						<?php endforeach;?>
                  		</ul>
                             
						<p>Job Notifications by Email</p>
                        <?php $emil_post_array =array('10'=>'Every 10 Post','1'=>'Every Day','3'=>'Every 3 Days','7'=>'Every Week'); ?>
                        <?php if(isset($SubscriptionData)){
                        		$id = $SubscriptionData['id'];
                           	}else{
								$id = "";
                       		}
                     	     echo $form->input('NetworkerSettings.id', array('label' => '',
																		'type'  => 'hidden',
																		'value' => $id
																		)
														 );?>
                      	<div class="industries-select job-subs-select">
                      		<?php echo $form -> input('subscribe_email',array('type'=>'select',
																              'label'=>false,
																              //'empty'=>'Select',
																              'options'=>$emil_post_array,
																              'div'=>false,
																              'class'=>'',
																              'selected' => isset($SubscriptionData['subscribe_email'])?$SubscriptionData['subscribe_email']:""));?>
						</div>
                        <div class="login-button job-save-setting">
							<?php echo $form->submit('Save Notification');?>
								<!--<input type="submit" value="SAVE SETTINGS">-->
							<div class="clr"></div>
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
<script>
$(document).ready(function(){
	$("#NetworkerSettingsForm").validate();
	$("#accordion").accordion();
	fillSpecification(1,"NetworkerSettingsSpecification","specification_loader")
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

