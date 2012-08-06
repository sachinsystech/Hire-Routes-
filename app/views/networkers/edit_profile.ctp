<script> 	
    $(document).ready(function(){
		$("#GraduateUniversityBreakdownEditProfileForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'164px','width':'230px'});
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
																	'value' => $user['UserList']['id']
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
							<?php echo $form->input('university',array('label'=> 'University',
																		'type'=>'text',
																		'class' => 'text_field_bg required',
																		'value' => isset($user['Universities'])?$user['Universities']['name']:"",
																	));
								if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
							?>
						</div>
						
						<div >
							<?php	echo $form->input('Networkers.graduate_degree_id', array('label' => 'Graduate Degree:',
												'type'  => 'select',
												'options'=>$graduateDegrees,
												'empty' =>' -- Select Gred Degree --',
												'class' => 'networker_select_bg',
												'style' => "float:right;width:208px;",
												'value' => isset($networker['graduate_degree_id'])?$networker['graduate_degree_id']:"",
												)
								 );
							?>
						</div>
						<div>
						<?php if(isset($networker) && isset( $graduateUniversity) ){ 
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
						
						<div style="display:none;">
						<?php
							echo $form->input('Networkers.university',
											array('type'=>'text',
											'value'=>isset($networker["university"])?$networker["university"]:"",
											));		
							echo $form->input('Networkers.graduate_university_id',
											array('type'=>'text', 
											'value'=>isset($networker["graduate_university_id"])?$networker["graduate_university_id"]:"",
											));

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


<style>
.loader{
	float:left;
	overflow:visible;
	width:30px;
}
</style>
<script>

	$(document).ready(function(){
		$("#GraduateUniversityBreakdownUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		$('#GraduateUniversityBreakdownUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#GraduateUniversityBreakdownUniversity').parent("div").css({"float":"left","width":"374px"});
				 		$('#GraduateUniversityBreakdownUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

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
				$('#NetworkersUniversity').val(ui.item.key);
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
		$("#NetworkersGraduateDegreeId").change( function(){ 
			$("#GraduateUniversityBreakdownGraduateUniversity").trigger('keydown');
		});	
		$( "#GraduateUniversityBreakdownGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#NetworkersGraduateDegreeId").val(),
					dataType: "json",
					beforeSend: function(){
				 		$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").css({"float":"left","width":"373px"});
				 		$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

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
				$('#NetworkersGraduateUniversityId').val(ui.item.key);
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

