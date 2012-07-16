<div style="width:550px;margin:auto;">
<?php //require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
<div class="sigup_heading"><u>Register</u></div>
<div>You will be able to apply for jobs and share job posts with your network.</div>
<div>Please submit the form below and you will receive an email confirmation to complete you registration.</div>
<?php if($this->Session->read('intermediateCode')!="" || $this->Session->read('intermediateCode')!=null){ ?>
	<div class="fb"><a href="<?php echo $FBLoginUrl; ?>"><button class="facebook"></button></a></div>
<?php } ?>
<div style="width:480px; margin-top:20px;">
<?php echo $form->create('User', array('action' => 'networkerSignup','onsubmit'=>'return checkform()')); ?>

	<?php	echo $form->input('account_email', array('label' => 'Account Email',
                                           			'type'  => 'text',
													'class' => 'text_field_bg required email',
                                           			)
                                 );
    ?>

	<?php	echo $form->input('password', array('label' => 'Password',
                                           			'type'  => 'password',
													'name'  => "data[User][password]",
													'class' => 'text_field_bg password',
													'minlength' => '6',
                                           			)
                                 );
    ?>
	<?php if(isset($pwd_error)): ?><div class="error-message"><?php //echo $pwd_error;?></div><?php endif; ?>
	<?php	echo $form->input('repeat_password', array('label' => 'Repeat Password',
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'text_field_bg required'
                                           			)
                                 );
    ?>
	<?php
		if(($this->Session->read('intermediateCode')=='' || $this->Session->read('intermediateCode')==null ) && ( $this->Session->read('icc')=='' || $this->Session->read('icc')== null)):
			echo $form->input('Code.code', array('label' => 'Code',
                                           			'type'  => 'text',
													'name'  => "data[Code][code]",
													'class' => 'text_field_bg required',
													'style'=>'margin-top: -2px;'
                                           			)
                                 );
			if(isset($codeErrors)):?><div class="error-message"><?php echo $codeErrors;?></div><?php endif; ?>
			<div class="required" style="padding:0;">
			<?php echo $form->input('Networker.university',array('label'=> 'University',
														'type'=>'select',
														'options'=>$universities,
														'empty' =>' -- Select University -- ',
														'class' => 'net_select_university required'
													));
				if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
			?>
			</div>
			
			<?php echo $form->input('Networker.graduate_degree_id',array('label'=> 'Graduate Degree (if applicable)',
														'type'=>'select',
														'options'=>$graduateDegrees,
														'empty' =>' -- Select Gred Degree --',
														'class' => 'net_select_gred_degree'
													));
				if(isset($graduateErrors)):?><div class="error-message"><?php echo $graduateErrors;?></div><?php endif; 
			?>
			
			<?php echo $form->input('Networker.graduate_university_id',array('label'=> 'Graduate University',
														'type'=>'select',
														'options'=>$universities,
														'empty' =>' -- Select Gred University --',
														'class' => 'net_select_gred_university'
													));
				if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
			?>													

			
	<?php  endif;?>
	<div class="signup_agree_condition">
		<?php	echo $form->input('agree_condition', array('label' => '<span class="agree_condition">Agree with </span><span class="terms">Terms and Conditions</span>',
															'type'  => 'checkbox',
															'name'  => "data[User][agree_condition]",
															)
									 );
		?>	
	
	</div>
	<div id="agree_condition_error"  class="error-message">
		<?php if(isset($tcErrors)): echo $tcErrors; endif; ?>
	</div>
	<?php echo $form->submit('Register',array('div'=>false,)); ?>
	<?php echo $form->end(); ?>
</div>
<div style="margin-top:50px;"><a href="/networkerInformation">Don't know about Networker</a> </div>
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
			  }
			});
	});
	function checkform() {
		var isAgreeCondition = $('input:checkbox[id=UserAgreeCondition]:checked').val();
		if(!isAgreeCondition){
			$("#agree_condition_error").removeClass().addClass("error").html("This is required field.");
			return false;
		}
		if(isAgreeCondition){
			$("#agree_condition_error").removeClass().html("");  
		}
	}
	
</script>
<script>
/*
	$(document).ready(function(){
		$("#UserUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					success: function( data ) {
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
				$('#NetworkerUniversity').val(ui.item.key);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});
	
	$(document).ready(function() {
		$( "#UserGraduateUniversity" ).autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
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
				$('#NetworkerGraduateUniversityId').val(ui.item.key);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});
	
	$(document).ready(function() {
		$("#UserGraduateDegreeId").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateDegrees/startWith:"+request.term,
					dataType: "json",
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
				$('#NetworkerGraduateDegreeId').val(ui.item.key);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});*/
	</script>
