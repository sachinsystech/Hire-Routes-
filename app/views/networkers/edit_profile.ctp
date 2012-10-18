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
                		<?php echo $this->Form->create('', array('url' => array('controller' => 'networkers', 'action' => 'editProfile'))); ?>
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
                    	<h2>EDIT PROFILE</h2>
                    	<div class="edit-profile-text-box">
                    	<?php	$name = "";
                                    if(isset($fbinfo)){ $name = $fbinfo['first_name']." ".$fbinfo['last_name']; }
                                    if(isset($networker) && $networker['contact_name']!=""){ $name = $networker['contact_name']; } 
                                    echo $form->input('Networkers.contact_name', array('label' => "<span>Name</span>",
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
							<?php	if(isset($networker)){ $address = $networker['address']; } else { $address = "";}
                                    echo $form->input('Networkers.address', array('label' => "<span>Address</span> ",
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
                    		<?php	if(isset($networker)){ $city = $networker['city']; } else { $city = "";}
                                    echo $form->input('Networkers.city', array('label' => "<span>City</span> ",
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
                   			<?php	if(isset($networker)){ $state = $networker['state']; } else { $state = "";}
                                    echo $form->input('Networkers.state', array('label' => "<span>State</span> ",
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
							<?php	if(isset($networker)){ $phone = $networker['contact_phone']; } else { $phone = "";}
                                    echo $form->input('Networkers.contact_phone', 
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
                    		<?php echo $form->input('university',array('label'=> "<span>University</span> ",
																		'type'=>'text',
																		'div'=> false,
																		'class' => 'text_field_bg required',
																		'value' => isset($user['Universities'])?$user['Universities']['name']:"",
																	));
								if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
							?>
							
                    	</div>					
                    	<div class="clr"></div>
                    	<div class="edit-profile-text-box">
                    		<?php	echo $form->input('Networkers.graduate_degree_id', 
                    							array('label' => "<span>Graduate Degree</span>",
													'type'  => 'select',
													'div'=> false,
													'options'=>$graduateDegrees,
													'empty' =>'Select Graduate Degree',
													'class' => 'networker_select_bg',
													'value' => isset($networker['graduate_degree_id'])?$networker['graduate_degree_id']:"",
												)
								 );
							?>
                    	</div> 
                    	<div class="clr"></div>                  		
                    	<div class="edit-profile-text-box" style="width:490px;">
                    		<div class="graduateUniversityLoader loader" style="visibility:hidden;">
								<img border="0" alt=".." src="/images/loading_transparent2.gif">
							</div>
							<?php if(isset($networker) && isset( $graduateUniversity) ){ 
								$university[$graduateUniversity['id']] = $graduateUniversity['graduate_college'];						
								}else{ 
									$university = "";
								}
								echo $form->input('graduate_university',array('label'=> "<span>Graduate University</span>",
																	'type'=>'text',
																	'class' => 'text_field_bg',
																	'options'=>$university,
																	'div'=> false,
																	'value'=>isset($user['GUB']['graduate_college'])?$user['GUB']['graduate_college']:"",
																));
							?>
							<?php if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
						?>
							
						</div>                        
                        <div class="clr"></div>
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
						<div class="clr"></div>
						<div class="edit-profile-clear-all">
							<label id="clearAll">Clear All</label>
						</div>
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
		$("#clearAll").click(function(){
			$("input[type=text]").val("");
			$("#NetworkersGraduateDegreeId").val("");
		});
		$("#GraduateUniversityBreakdownUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		//$('#GraduateUniversityBreakdownUniversity').parent("div").css({"float":"left","width":"490px"});
				 		$('.universityLoader').css('visibility','visible');
				 		//$('#GraduateUniversityBreakdownUniversity').parent("div").children("label").append('<div class="loader"><img src="/images/loading_transparent2.gif" border="0" alt='..'/ ></div>');

			   		},
			   		complete: function(){
				 		$('.universityLoader').css('visibility','hidden');
			   	    	//$('.loader').remove();
				 		//$('#GraduateUniversityBreakdownUniversity').parent("div").css({"float":"left","width":"460px"});
			   		},
					success: function( data ) {
						if(data == null) return;
						if(data[0]['id'] != 0 && data[0]['name'] != "Other"){
							$("#GraduateUniversityBreakdownUniversity").parent("div").next('div').remove();
							$("#GraduateUniversityBreakdownUniversity").parent("div").next('label').remove();
						}	
						response( $.map( data, function(item) {
							if(item.id === 0) {
								$("#GraduateUniversityBreakdownUniversity").parent("div").next('div').remove();
								$("#GraduateUniversityBreakdownUniversity").parent("div").next('label').remove();
								$("#GraduateUniversityBreakdownUniversity").parent("div").after('<div class="editprofile_tooltip_backround"></div><label for="name" generated="true" class="error editprofile_tooltip_university">'+item.name+'</label>');
								$("#GraduateUniversityBreakdownUniversity").autocomplete('search', 'other');
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
				$('#NetworkersUniversity').val(ui.item.key);
				$("#GraduateUniversityBreakdownUniversity").parent("div").next('div').remove();
				$("#GraduateUniversityBreakdownUniversity").parent("div").next('label').remove();
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
			$("#GraduateUniversityBreakdownGraduateUniversity").autocomplete('search', '');
		});	
		$( "#GraduateUniversityBreakdownGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#NetworkersGraduateDegreeId").val(),
					dataType: "json",
					beforeSend: function(){
				 		$('.graduateUniversityLoader').css('visibility','visible');
				 		//$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").css({"float":"left","width":"490px"});
				 		//$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").children("label").append('<div class="loader"><img src="/images/loading_transparent2.gif" border="0" alt=".."  /></div>');
			   		},
			   		complete: function(){
			   	    	$('.graduateUniversityLoader').css('visibility','hidden');
			   	    	//$('#GraduateUniversityBreakdownGraduateUniversity').parent("div").css({"float":"left","width":"460px"});
			   		},
					
					success: function( data ) {
						if(data == null) return;
						if(data[0]['id'] != 0 && data[0]['name'] != "Other"){
							$("#GraduateUniversityBreakdownGraduateUniversity").parent("div").next('label').remove();
						}
						response( $.map( data, function(item) {
							if(item.id === 0) {
								$("#GraduateUniversityBreakdownGraduateUniversity").parent("div").next('label').remove();
								$("#GraduateUniversityBreakdownGraduateUniversity").parent("div").after('<div class="editprofile_tooltip_backround"></div><label for="name" generated="true" class="error editprofile_tooltip_university">'+item.name+'</label>');
								$("#GraduateUniversityBreakdownGraduateUniversity").autocomplete('search', 'other');
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
				$('#NetworkersGraduateUniversityId').val(ui.item.key);
				$("#GraduateUniversityBreakdownGraduateUniversity").parent("div").next('label').remove();
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

    $(document).ready(function(){
   		$("#GraduateUniversityBreakdownEditProfileForm").validate({
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
					error.css({'margin-left':'172px','width':'236px'});
			}
		});
    });	
	

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
