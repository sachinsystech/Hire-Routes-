
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
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left job-profile">
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
                    	<h2>EDIT PROFILE</h2>
                    	<div class="edit-profile-text-box">
                    	<?php	$name = "";
                                    if(isset($fbinfo)){ $name = $fbinfo['first_name']." ".$fbinfo['last_name']; }
                                    if(isset($jobseeker) && $jobseeker['contact_name']!=""){ $name = $jobseeker['contact_name']; } 
                                    echo $form->input('Jobseekers.contact_name', array('label' => "<span>Name</span>",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $name,
												'div'=> false,
												)
								 );
							?>
   
						</div>
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">							
							<?php	if(isset($jobseeker)){ $address = $jobseeker['address']; } else { $address = "";}
                                    echo $form->input('Jobseekers.address', array('label'=>'<span>Address</span>',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $address,
												'div'=> false,

												)
								 );
							?>
						</div>
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">
							<?php	if(isset($jobseeker)){ $city = $jobseeker['city']; } else { $city = "";}
                                    echo $form->input('Jobseekers.city', array('label' => "<span>City</span> ",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $city,
												'div'=> false,
												)
								 );
							?>
                    	</div>
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">							
							<?php	if(isset($jobseeker)){ $state = $jobseeker['state']; } else { $state = "";}
                                    echo $form->input('Jobseekers.state', array('label' => "<span>State</span> ",
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $state,
												'div'=> false,
												)
								 );
							?>
						</div>
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">													
							<?php	if(isset($jobseeker)){ $phone = $jobseeker['contact_phone']; } else { $phone = "";}
                                    echo $form->input('Jobseekers.contact_phone', 
                                    		array('label' => "<span>Phone</span> ",
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $phone,
												'div'=> false,

												)
								 );
							?>
						</div>
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box" style="width:490px;">
	                    	<div class="universityLoader loader" style="visibility:hidden;">
								<img border="0" alt=".." src="/images/loading_transparent2.gif">
							</div>	
                    		<?php echo $form->input('university',array('label'=>"<span>University</span> ",
																		'type'=>'text',
																		'class' => 'text_field_bg required',
																		'div'=> false,
																		'value' => isset($user['Universities'])?$user['Universities']['name']:"",
																	));
								if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
							?>
                    		
                    	</div>					
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">
                    		<?php echo $form->input('Jobseekers.graduate_degree_id',array('label'=>"<span>Graduate Degree</span>",
																	'type'=>'select',
																	'div'=> false,
																	'options'=>$graduateDegrees,
																	'empty' =>'Select Graduate Degree',
																	'class' => 'job_select_gred_degree',
																	'value' => isset($jobseeker['graduate_degree_id'])?$jobseeker['graduate_degree_id']:"",
																));
								if(isset($graduateErrors)):?><div class="error-message"><?php echo $graduateErrors;?></div><?php endif; 
							?>

                    	</div> 
                    	<div class="clr"></div>                  		
                    	<div class="edit-profile-text-box" style="width:490px;">
	                    	<div class="graduateUniversityLoader loader" style="visibility:hidden;">
								<img border="0" alt=".." src="/images/loading_transparent2.gif">
							</div>
							<?php if(isset($jobseekers) && isset( $graduateUniversity) ){ 
									$university[$graduateUniversity['id']] = $graduateUniversity['graduate_college'];						
								}else{ 
									$university = "";
								}
								echo $form->input('graduate_university',array('label'=> '<span>Graduate University</span>',
																	'type'=>'text',
																	'class' => 'text_field_bg',
																	'options'=>$university,
																	'div'=> false,
																	'value'=>isset($user['GUB']['graduate_college'])?$user['GUB']['graduate_college']:"",
																));
								if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
							?>
							
						</div>                        
                        <div class="clr"></div>
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
						<div class="clr"></div>
						<div class="edit-profile-clear-all">
							<label id="clearAll">Clear All</label>
						</div>
						<div class="clr"></div>
						<div class="save-profile-button">
							<?php echo $form->submit('SAVE CHANGES',array('div'=>false,)); ?>
						</div>
						<?php echo $form->end(); ?>	
					</div>
				</div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="job_pagination_bottm_bar"></div>
		<div class="clr"></div>
	</div>	
<style>
.loader{
	float:right;
	overflow:visible;
	width:30px;
}
</style>

<script>

	$(document).ready(function(){
		$("#JobseekerSettingsUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		$('.universityLoader').css('visibility','visible');
			   		},
			   		complete: function(){
			   	    	$('.universityLoader').css('visibility','hidden');
			   		},
					success: function( data ) {
						if(data == null) return;	
						response( $.map( data, function(item) {
							if(data == null) return;
							if(data[0]['id'] != 0 && data[0]['name'] != "Other"){
								$("#JobseekerSettingsUniversity").parent("div").next('label').remove();
							}
							if(item.id === 0) {
								$("#JobseekerSettingsUniversity").parent("div").next('label').remove();
								$("#JobseekerSettingsUniversity").parent("div").after('<label for="name" generated="true" class="error editprofile_tooltip_university">'+item.name+'</label>');
								$("#JobseekerSettingsUniversity").autocomplete('search', 'other');
							}else{
								return {
									value: item.name,
									key: item.id
								}
							}
						}));
					}
				});
			},
			select: function( event, ui ) {
				$('#JobseekersUniversityId').val(ui.item.key);
				$("#JobseekerSettingsUniversity").parent("div").next('label').remove();
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
		$("#clearAll").click(function(){
			$("input[type=text]").val("");
		});
	
		$("#JobseekersGraduateDegreeId").change( function(){ 
			$("#JobseekerSettingsGraduateUniversity").autocomplete('search', '');
		});	
		$( "#JobseekerSettingsGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#JobseekersGraduateDegreeId").val(),
					dataType: "json",
					beforeSend: function(){
				 		$('.graduateUniversityLoader').css('visibility','visible');			 		
			   		},
			   		complete: function(){
			   	    	$('.graduateUniversityLoader').css('visibility','hidden');
			   		},
					
					success: function( data ) {
						if(data == null) return;
						if(data[0]['id'] != 0 && data[0]['name'] != "Other"){
								$("#JobseekerSettingsGraduateUniversity").parent("div").next('label').remove();
							}
						response( $.map( data, function(item) {
							if(item.id === 0) {
								$("#JobseekerSettingsGraduateUniversity").parent("div").next('label').remove();
								$("#JobseekerSettingsGraduateUniversity").parent("div").after('<label for="name" generated="true" class="error editprofile_tooltip_university">'+item.name+'</label>');
								$("#JobseekerSettingsGraduateUniversity").autocomplete('search', 'other');
							}else{
								return {
									value: item.name,
									key: item.id
								}
							}
						}));
					},
				});
			},
			select: function( event, ui ) {
				$('#JobseekersGraduateUniversityId').val(ui.item.key);
				$("#JobseekerSettingsGraduateUniversity").parent("div").next('label').remove();
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
    max-width: 350px;
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
