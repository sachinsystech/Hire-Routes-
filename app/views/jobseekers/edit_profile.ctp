<script> 	
    $(document).ready(function(){
   		$("#JobseekerSettingsEditProfileForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'172px','width':'236px'});
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
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="setting_middleBox">
				<div class="networker_edit_form">
					<?php echo $this->Form->create('', array('url' => array('controller' => 'jobseekers', 'action' => 'editProfile'))); ?>
						<div>
							<?php	echo $form->input('User.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $user['UserList']['id']
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
						
						<div class="required">
							<?php echo $form->input('university',array('label'=> 'University',
																		'type'=>'text',
																		'class' => 'text_field_bg required',
																		'value' => isset($user['Universities'])?$user['Universities']['name']:"",
																	));
								if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
							?>
						</div>
						<div style="clear:both"></div>
						<div>			
						<?php echo $form->input('Jobseekers.graduate_degree_id',array('label'=> 'Graduate Degree',
																	'type'=>'select',
																	'options'=>$graduateDegrees,
																	'empty' =>' -- Select Gred Degree --',
																	'class' => 'job_select_gred_degree',
																	'value' => isset($jobseeker['graduate_degree_id'])?$jobseeker['graduate_degree_id']:"",
																));
							if(isset($graduateErrors)):?><div class="error-message"><?php echo $graduateErrors;?></div><?php endif; 
						?>
						</div>
						<div style="clear:both"></div>
						<div>
						<?php if(isset($jobseekers) && isset( $graduateUniversity) ){ 
									$university[$graduateUniversity['id']] = $graduateUniversity['graduate_college'];						
								}else{ 
									$university = "";
								}
								echo $form->input('graduate_university',array('label'=> 'Graduate University',
																	'type'=>'text',
																	'class' => 'text_field_bg',
																	'options'=>$university,
																	'value'=>isset($user['GUB']['graduate_college'])?$user['GUB']['graduate_college']:"",
																));
							if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
						?>
						</div>
						<div style="clear:both"></div>

						<div class="company_profile_field_row">
							<div style="float:right;margin-right:20px">
								<?php echo $form->submit('Save Changes',array('div'=>false,)); ?>	
							</div>
						</div>
						<div style="clear:both"></div>						
						<div style="display:none;">
						<?php
							echo $form->input('Jobseekers.university_id',
											array('type'=>'text',
											'value'=>isset($jobseeker["university_id"])?$jobseeker["university_id"]:"",
											));		
							echo $form->input('Jobseekers.graduate_university_id',
											array('type'=>'text', 
											'value'=>isset($jobseeker["graduate_university_id"])?$jobseeker["graduate_university_id"]:"",
											));

						?>
						</div>
					<?php echo $form->end(); ?>	
				</div>
				
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->
</div>

<script>

	$(document).ready(function(){
		$("#JobseekerSettingsUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		$('#JobseekerSettingsUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#JobseekerSettingsUniversity').parent("div").css({"float":"left","width":"384px"});
				 		$('#JobseekerSettingsUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

			   		},
			   		complete: function(){
			   	    	$('.loader').remove();
			   		},
					success: function( data ) {
						if(data == null) return;	
						response( $.map( data, function(item) {
							if(data == null) return;
							return {
								value: item.name,
								key: item.id
							}
						}));
					}
				});
			},
			select: function( event, ui ) {
				$('#JobseekersUniversityId').val(ui.item.key);
				$( this ).removeClass( "ui-corner-all" );
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-all" );
			}
		});
	});
	
	$(document).ready(function() {
		$("#JobseekersGraduateDegreeId").change( function(){ 
			$("#JobseekerSettingsGraduateUniversity").trigger('keydown');
		});	
		$( "#JobseekerSettingsGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#JobseekersGraduateDegreeId").val(),
					dataType: "json",
					beforeSend: function(){
				 		$('#JobseekerSettingsGraduateUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#JobseekerSettingsGraduateUniversity').parent("div").css({"float":"left","width":"384px"});
				 		$('#JobseekerSettingsGraduateUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

			   		},
			   		complete: function(){
			   	    	$('.loader').remove();
			   		},
					
					success: function( data ) {
						if(data == null) return;
						response( $.map( data, function(item) {
							return {
								value: item.name,
								key: item.id
							}
						}));
					},
				});
			},
			select: function( event, ui ) {
				$('#JobseekersGraduateUniversityId').val(ui.item.key);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-all" );
			}
		});
	});
	
</script>

<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>
<style>
.ui-autocomplete {
    font-size: 12px;
    max-height: 154px;
    max-width: 205px;
    overflow-x: hidden;
    overflow-y: auto;

}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
	height: 100px;
}
</style>
