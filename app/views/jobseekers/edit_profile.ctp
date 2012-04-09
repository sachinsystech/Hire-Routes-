<script> 	
    $(document).ready(function(){
  		$("#JobseekerSettingsEditProfileForm").validate();
    });	
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
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="setting_middleBox">
				<div class="networker_edit_form">
					<?php echo $this->Form->create('', array('url' => array('controller' => 'jobseekers', 'action' => 'editProfile'))); ?>
						<div>
							<?php	echo $form->input('User.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $user['id']
																	)
														 );
							?>
							<?php	if(isset($jobseeker)){ $id = $jobseeker['id']; } else { $id = "";}
                                    echo $form->input('Jobseekers.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $id
																	)
														 );
							?>
						</div>						
						<div style="clear:both"></div>

                        <div>
							<?php	$name = "";
                                    if(isset($fbinfo)){ $name = $fbinfo['first_name']." ".$fbinfo['last_name']; }
                                    if(isset($jobseeker) && $jobseeker['contact_name']!=""){ $name = $jobseeker['contact_name']; } 
                                    echo $form->input('Jobseekers.contact_name', array('label' => 'Contact Name:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $name,
												)
								 );
							?>
						</div>		
						<div style="clear:both"></div>
						
						<div>
							<?php	if(isset($jobseeker)){ $address = $jobseeker['address']; } else { $address = "";}
                                    echo $form->input('Jobseekers.address', array('label' => 'Address:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $address,

												)
								 );
							?>
						</div>		
						<div style="clear:both"></div>
												
						<div>
							<?php	if(isset($jobseeker)){ $city = $jobseeker['city']; } else { $city = "";}
                                    echo $form->input('Jobseekers.city', array('label' => 'City:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $city,
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

                        <div>
							<?php	if(isset($jobseeker)){ $state = $jobseeker['state']; } else { $state = "";}
                                    echo $form->input('Jobseekers.state', array('label' => 'State:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $state,
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	if(isset($jobseeker)){ $phone = $jobseeker['contact_phone']; } else { $phone = "";}
                                    echo $form->input('Jobseekers.contact_phone', array('label' => 'Contact Phone:',
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $phone,

												)
								 );
							?>
						</div>

						<div style="clear:both"></div>

						<div class="company_profile_field_row">
							<div style="float:right;margin-top:20px">
								<?php echo $form->submit('Save Changes',array('div'=>false,)); ?>	
							</div>
						</div>
						<div style="clear:both"></div>						

					<?php echo $form->end(); ?>	
				</div>
				
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
	$(document).ready(function(){
		$("#JobseekerSettingsEditProfileForm").validate();
	});     
</script>
