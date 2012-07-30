<script> 	
    $(document).ready(function(){
		$("#GraduateUniversityBreakdownEditProfileForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'147px','width':'230px'});
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

						<div class="required">
							<?php	echo $form->input('Networkers.university', array('label' => 'University:',
												'type'  => 'select',
												'options'=>$universities,
												'empty'=>"select",
												'class' => 'networker_select_bg  required',
												'style' => "float:right;width:208px;",
												'value' => isset($networker['university'])?$networker['university']:"",
												)
								 );
							?>
						</div>
						
						<div >
							<?php	echo $form->input('Networkers.graduate_degree_id', array('label' => 'Graduate Degree:',
												'type'  => 'select',
												'options'=>$graduateDegrees,
												'empty'=>"select",
												'class' => 'networker_select_bg',
												'style' => "float:right;width:208px;",
												'onchange'=>"fillGraduateUniversity()",
												'value' => isset($networker['graduate_degree_id'])?$networker['graduate_degree_id']:"",
												)
								 );
							?>
						</div>

						<div>
							<?php	if(isset($networker) && isset( $graduateUniversity) ){ 
										$university[$graduateUniversity['id']] = $graduateUniversity['graduate_college'];						
									}else{ 
										$university = "";
									}
                                    echo $form->input('Networkers.graduate_university_id', array('label' => 'Graduate University:',
												'type'  => 'select',
												'options'=>$university,
												'class' => 'networker_select_bg',
												'style' => "float:right;width:208px;",
												)
								 );
							?>
						</div>						
						<div class="company_profile_field_row">
							<div style="float:right;margin-right:20px">
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

	function fillGraduateUniversity(){
			$.ajax({
				url: "/Utilities/getGraduateUniversities/startWith:/degree_id:"+$("#NetworkersGraduateDegreeId").val(),
				dataType: "json",
				beforeSend: function(){
			 		$('#NetworkersGraduateUniversityId').parent("div").parent("div").css({"float":"left","width":"400px"});
			 		$('#NetworkersGraduateUniversityId').parent("div").css({"float":"left","width":"350px"});
			 		$('#NetworkersGraduateUniversityId').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

		   		},
		   		complete: function(){
		   	    	$('.loader').remove();
		   		},
				success: function( data ) {
					if(data == null) return;
					$('#NetworkersGraduateUniversityId').html("");
					$('#NetworkersGraduateUniversityId').append($('<option>').text("select").attr('value',""));

					$(data).each(function(){
						$('#NetworkersGraduateUniversityId').append($('<option>').text(this.name).attr('value', this.id));
					});
				},
			});
		}
	   
</script>
<style>
.loader{
	float:left;
	overflow:visible;
	width:30px;
}
</style>
