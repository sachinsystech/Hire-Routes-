<script> 	
    $(document).ready(function(){
		$("#NetworkersEditProfileForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'125px','width':'230px'});
			}
		});
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
			<div class="setting_middleBox">
				<div class="networker_edit_form">
					<?php echo $this->Form->create('', array('url' => array('controller' => 'networkers', 'action' => 'editProfile'))); ?>
						<div>
							<?php	echo $form->input('User.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $user['id']
																	)
														 );
							?>
							<?php	if(isset($networker)){ $id = $networker['id']; } else { $id = "";}
                                    echo $form->input('Networkers.id', array('label' => '',
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
                                    if(isset($networker) && $networker['contact_name']!=""){ $name = $networker['contact_name']; } 
                                    echo $form->input('Networkers.contact_name', array('label' => 'Contact Name:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $name,

												)
								 );
							?>
						</div>		
						<div style="clear:both"></div>
						
						<div>
							<?php	if(isset($networker)){ $address = $networker['address']; } else { $address = "";}
                                    echo $form->input('Networkers.address', array('label' => 'Address:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $address,

												)
								 );
							?>
						</div>		
						<div style="clear:both"></div>
												
						<div>
							<?php	if(isset($networker)){ $city = $networker['city']; } else { $city = "";}
                                    echo $form->input('Networkers.city', array('label' => 'City:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $city,
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

                        <div>
							<?php	if(isset($networker)){ $state = $networker['state']; } else { $state = "";}
                                    echo $form->input('Networkers.state', array('label' => 'State:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $state,
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	if(isset($networker)){ $phone = $networker['contact_phone']; } else { $phone = "";}
                                    echo $form->input('Networkers.contact_phone', array('label' => 'Contact Phone:',
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $phone,

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	if(isset($networker)){ $university = $networker['university']; } else { $university = "";}
                                    echo $form->input('Networkers.university', array('label' => 'University:',
												'type'  => 'select',
												'options'=>$universities,
												'empty'=>"----select----",
												'class' => 'networker_select_bg required',
												'style' => "float:right;width:208px;",
												'value' => isset($networker['university'])?$networker['university']:"",
												)
								 );
							?>
						</div>
						
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

	$(document).ready(function(){
		$("#NetworkersEditProfileForm").validate();
	});     
</script>
