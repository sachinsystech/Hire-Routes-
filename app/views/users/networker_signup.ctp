

<h1 class="title-emp">Networker Registration</h1>
<div class="sub-title-ty application_top_submenu network_top_txt">You will be able to apply for jobs and share job posts with your network.<br />
Please submit the form below and you will receive an email confirmation to complete your registration.</div>
<!---  application form start --->
<div class="login_middle_main"> 
	
	<?php
		if(($this->Session->read('intermediateCode')!='' || $this->Session->read('intermediateCode')!=null ) || ( $this->Session->read('icc')!='' || $this->Session->read('icc')!= null) || ( $this->Session->read('invitationCode')!='' || $this->Session->read('invitationCode')!= null)):?>
	<div class="login_middle_right_box nr_signup_social_box">
	   	<div class="signup_social_box_txt">Sign in with Your Social network</div>
	       	<ul>
	       	    <li><a class="job-share-fb" href="<?php echo $FBLoginUrl; ?>"></a></li>
	       	    <li><a class="job-share-in" href="<?php echo $LILoginUrl; ?>"></a></li>
	       	</ul>
		</div>
	</div>
	<div class="login_middle_center_box nr_signup_or_txt_box" style="margin:120px 40px 0 !important;"><strong>OR</strong></div>
	<?php else:
	echo "<style>.login_middle_main { width: 300px !important;}</style>" ;
	endif;?>
	<div class="login_middle_left_box" style="float:left;">
		<span style="position: absolute; color:#847A6C; margin-top: -7px; font-size: 13px;">* Required</span>
		<?php echo $form->create('User', array('action' => 'networkerSignup','onsubmit'=>'return checkform()')); ?>
		<div class="network_form_row">
			<?php	echo $form->input('account_email', array('label' => false,
                                           			'type'  => 'text',
													'class' => 'required email',
													'div'=> false,
													'placeholder' => "Email*",
                                           			)
                                 );
	    	?>
		</div>
	
		<div class="network_form_row">
			<?php	echo $form->input('password', array('label' => false,
				                                   			'type'  => 'password',
															'name'  => "data[User][password]",
															'class' => 'password',
															'minlength' => '6',
															'placeholder'=>'Password*',
															'div'=>false,
				                                   			)
				                         );
			?>

		</div>
	
		<div class="network_form_row">
			<?php if(isset($pwd_error)): ?><div class="error-message"><?php //echo $pwd_error;?></div><?php endif; ?>
			<?php	echo $form->input('repeat_password', array('label' => false,
		                                       			'type'  => 'password',
		                                       			'div'=> false,
														'name'  => "data[User][repeat_password]",
														'class' => 'required',
														'placeholder' => 'Repeat Password*',
		                                       			)
		                             );
			?>
		</div>
	
		<div class="network_form_row">
			<?php
				if(($this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')==null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null) && ( $this->Session->read('invitationCode')=='' || $this->Session->read('invitationCode')== null)):
					echo $form->input('Code.code', array('label' => false,
		        	                           			'type'  => 'text',
														'name'  => "data[Code][code]",
														'class' => 'required',
														'div'	=> false,
														'placeholder'=>'Code*',
		                                       			)
		                             );
				if(isset($codeErrors)):?><div class="error-message"><?php echo $codeErrors;?></div><?php endif; ?>
				<?php  endif;?>
	
		</div>
		    
		<div class="network_form_row space">
			<?php echo $form->input('university',array('label'=>false,
														'type'=>'text',
														'class' => 'required',
														'placeholder'=>'University*',
														'div'=>false,
									));
				if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
			?>
		</div>
		    
		<div class="network_form_row">
			<?php echo $form->input('Networker.graduate_degree_id',
		    										array('label'=> false,
															'type'=>'select',
															'options'=>$graduateDegrees,
															'empty' =>'Select Graduate Degree',
															'div'=> false,
															'style'=>"width:289px",
														));
				if(isset($graduateErrors)):?><div class="error-message"><?php echo $graduateErrors;?></div><?php endif; 
			?>
		    <div class="clr"></div>
		</div>
		    
		<div class="network_form_row space">
			<?php echo $form->input('graduate_university',array('label'=> false,
															'type'=>'text',
															'div'=> false,
															'class' => '',
															'placeholder'=>'Graduate University',
														));
				if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
			?>
		
		</div>
		<div style="display:none;">
			<?php
				echo $form->input('Networker.graduate_university_id',array('type'=>'text', 'value'=>''));
				echo $form->input('Networker.university',array('type'=>'text','value'=>''));
			?>
		</div> 
		    
		    
		<div class="network_form_row space1">
			<div class="network_checkbox">
				<?php	echo $form->input('agree_condition', array('label' => false,
																	'type'  => 'checkbox',
																	'name'  => "data[User][agree_condition]",
																	'div'	=> false,
																	)
											 );
				?>	
			</div>
		    <div class="network_checkbox_txt">Agree with <a href="/termsOfUse">Terms & Conditions</a></div>	
			<div id="agree_condition_error"  class="error-message">
				<?php if(isset($tcErrors)): echo $tcErrors; endif; ?>
			</div>
		    <div class="clr"></div>
		</div>
		    
		<div class="network_form_row space">
			<div class="network_register_bttn">
				<?php echo $form->submit('Register',array('div'=>false,)); ?>
			</div>
			<div class="application_delete_resume_row network_bttnbottm_txt">
				<a href="/networkerInformation">Don't know about Networkers?</a>
			</div>
		</div>
		<?php echo $form->end(); ?>        
	</div>
</div>



<script>
	$(document).ready(function(){
		$("#UserNetworkerSignupForm").validate({
				errorClass: 'error_input_message',
				rules: {
					'data[User][password]': "required",
					'data[User][repeat_password]': {
					  equalTo: "#UserPassword"
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element)
				}
			});
	});
	function checkform() {
		var isAgreeCondition = $('input:checkbox[id=UserAgreeCondition]:checked').val();
		if(!isAgreeCondition){
			$("#agree_condition_error").removeClass().addClass("error_input_message").html("This field is required.");
			return false;
		}
		if(isAgreeCondition){
			$("#agree_condition_error").removeClass().html("");  
		}
	}
	
</script>
<script>

	$(document).ready(function(){
		$("#UserUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		//$('#UserUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		//$('#UserUniversity').parent("div").css({"float":"left","width":"446px"});
				 		$('#UserUniversity').parent("div").parent("div").append('<div class="loader"><img src="/images/loading_transparent2.gif" border="0" alt="Loading, please wait..."  /></div>');

			   		},
			   		complete: function(){
			   	    	$('.loader').remove();
			   		},
					success: function( data ) {
						if(data == null) return;
						if(data[0]['id'] != 0 && data[0]['university_name'] != "Other"){
							$("#UserUniversity").next('div').remove();
							$("#UserUniversity").next('label').remove();
						}
						response( $.map( data, function(item) {
							if(item.id === 0) {
								$("#NetworkerGraduateDegreeId").next('div').remove();								
								$("#NetworkerGraduateDegreeId").next('label').remove();
								$("#UserUniversity").next('div').remove();
								$("#UserUniversity").next('label').remove();
								$("#UserUniversity").after('<div class="tooltip_backround"></div><label for="name" generated="true" class="error tooltip_university">'+item.university_name+'</label>');
								$("#UserUniversity").autocomplete('search', 'other');
							}else{
								return {
									value: item.university_name,
									key: item.id
								}
							}
						}));
					}
				});
			},
			select: function( event, ui ) {
				$('#NetworkerUniversity').val(ui.item.key);
				$("#UserUniversity").next('div').remove();
				$("#UserUniversity").next('label').remove();
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
		$("#UserGraduateUniversity").attr('readonly', true).keypress(function(){
			if($(this).attr("readonly")){
				$("#NetworkerGraduateDegreeId").next('div').remove();								
				$("#NetworkerGraduateDegreeId").next('label').remove();
				$("#NetworkerGraduateDegreeId").after('<div class="tooltip_graduate_degree_backround"></div><label for="name" generated="true" class="error tooltip_graduate_degree" >Please select Graduate Degree first</label>');	
			}});
		$("#NetworkerGraduateDegreeId").change( function(){
			if($(this).val() == "" || $(this).val() == null){
				$("#UserGraduateUniversity").attr('readonly', true).val("");
				$('#NetworkerGraduateUniversityId').val("");
				$("#UserGraduateUniversity").next('div').remove();								
				$("#UserGraduateUniversity").next('label').remove();
				return;
			}else{
				$("#UserGraduateUniversity").attr('readonly', false);
				$("#NetworkerGraduateDegreeId").next('div').remove();
				$("#NetworkerGraduateDegreeId").next('label').remove();
			} 	
			$("#UserGraduateUniversity").autocomplete('search', '');
		});	
		$( "#UserGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#NetworkerGraduateDegreeId").val(),
					dataType: "json",
					success: function( data ) {
						if(data == null) return;
						if(data[0]['id'] != 0 && data[0]['university_name'] != "Other"){
							$("#UserGraduateUniversity").next('div').remove();								
							$("#UserGraduateUniversity").next('label').remove();
						}
						response( $.map( data, function(item) {
							if(item.id === 0) {
								$("#UserGraduateUniversity").next('div').remove();								
								$("#UserGraduateUniversity").next('label').remove();
								$("#UserGraduateUniversity").after('<div class="tooltip_backround"></div><label for="name" generated="true" class="error tooltip_graduate_university" >'+item.university_name+'</label>');
								$("#UserGraduateUniversity").autocomplete('search', 'other');
							}else{
								return {
									value: item.university_name,
									key: item.id
								}
							}
							
						}));
					}
				});
			},
			select: function( event, ui ) {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				$('#NetworkerGraduateUniversityId').val(ui.item.key);
				$("#UserGraduateUniversity").next('div').remove();								
				$("#UserGraduateUniversity").next('label').remove();
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

<div class="clr"></div>
