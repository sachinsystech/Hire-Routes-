<?php

?>

<div style="font-weight:bold;"><center>Please select what type of user you are!</center></div>
<div class="selection-button">
<center>
	<button onclick="registrationInto(2);">Job Seeker</button>
	<button onclick="registrationInto(3);">Networker</button>
</center>
</div>

<script>
function registrationInto(redirect){
	switch(redirect){
		case 2:
			window.location.href="/users/saveFacebookUser/2";			
			break;

		case 3:
			fillUniversity();
			//window.location.href="/users/saveFacebookUser/3";			
			break;
	}
}
</script>

<style>
	body { font-size: 70%; }
	#ui-dialog-title-dialog-form { padding:5px; }
	fieldset { padding:0; border:0; margin-top:25px; }
</style>
	
<div id="dialog-form" style="display:none;padding:12px">
	<?php echo $this->Form->create('Networkers', array('url' => array('controller' => 'users', 'action' => 'saveFacebookUser','3'))); ?>
	<fieldset>
		<div style="margin:auto;">
			<div class="required" >
			<div style="clear:both"></div>
			<div class="required">
				<?php echo $form->input('Users.university',array('label'=> 'University',
															'type'=>'text',
															'class' => 'text_field_bg required',
															'div'=>'text_field',
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
									'div'=>'text_field',
									)
					 );
				?>
			</div>
			<div>
			<?php echo $form->input('Users.graduate_university',array('label'=> 'Graduate University',
														'type'=>'text',
														'class' => 'text_field_bg',
														'div'=>'text_field',
													));
				if(isset($graduateUniErrors)):?><div class="error-message"><?php echo $graduateUniErrors;?></div><?php endif; 
			?>
			</div>
			<div style="display:none;">
			<?php
					echo $form->input('Networkers.graduate_university_id',array('type'=>'text', 'value'=>''));
					echo $form->input('Networkers.university',array('type'=>'text','value'=>''));
				
			?>
			<?php echo $form->submit('Save',array('div'=>false,)); ?>
			</div>
		</div>
	</fieldset>
	<?php echo $form->end(); ?>
</div>

<script type="text/javascript">
	$("#NetworkersFacebookUserSelectionForm").validate({
		  errorClass: 'error_input_message',
		   errorPlacement: function (error, element) {
		       error.insertAfter(element)
		       error.css({'overflow':'auto','width':'208px','margin-left':'220px'});
        	}
	});

	function fillUniversity(){
		$(document).ready(function(){
			$("#dialog-form").dialog({
				height:300,
				width:500,
				modal:true,
				resizable: false ,
				draggable: true,
				title:"User Information",
				show: { 
					effect: 'drop', 
					direction: "up" 
				},
				buttons: {
					"Save": function() {
							var i=0;
							var flag = true;
							$("input[type=text]").css({'color':'','border':''});
							$("input[type=submit]").click();
					},
					"Cancel": function() {
						$(this).dialog( "close" );
					}
				},
			});
		});
		
	}
	
	$(document).ready(function(){
		$("#UsersUniversity").autocomplete({
			minLength:1,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getUniversities/startWith:"+request.term,
					dataType: "json",
					beforeSend: function(){
				 		$('#UsersUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#UsersUniversity').parent("div").css({"float":"left","width":"420px"});
				 		$('#UsersUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

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
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" );
			}
		});
	});
	
	$(document).ready(function() {
		$("#NetworkersGraduateDegreeId").change( function(){ 	
			$("#UsersGraduateUniversity").trigger('keydown');
		});	
		$( "#UsersGraduateUniversity" ).autocomplete({
			minLength:0,
			source: function( request, response ) {
				$.ajax({
					url: "/Utilities/getGraduateUniversities/startWith:"+request.term+"/degree_id:"+$("#NetworkersGraduateDegreeId").val(),
					dataType: "json",
					beforeSend: function(){
				 		$('#UsersGraduateUniversity').parent("div").parent("div").css({"float":"left","width":"450px"});
				 		$('#UsersGraduateUniversity').parent("div").parent("div").append('<div class="loader"><img src="/img/ajax-loader.gif" border="0" alt="Loading, please wait..."  /></div>');

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
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
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
