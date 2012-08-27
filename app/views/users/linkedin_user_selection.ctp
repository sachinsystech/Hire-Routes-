<!------- Starts contents for linkedin user selection -------->
<h1 class="title-emp">What type of user are you? </span></h1>
<div class="button"> <a href="/networkerInformation">DON'T KNOW? </a> </div>
<div class="content">
    <div class="box box1" onclick="registrationInto(3);">
      <div class="box-content network-up"> <img src="/images/network_1.png" />
        <div class="clr"></div>
      </div>
      <div class="button-network" > <a href="#" onclick="registrationInto(3);">NETWORKERS </a></div>
      <div class="clr"></div>
    </div>
    
    <div class="box box1" onclick="registrationInto(2);">
      <div class="box-content job-up"> <img src="/images/job_1.png" />
      </div>
      <div class="clr"></div>
      <div class="button-jobseeker" > <a href="#" onclick="registrationInto(2);">JOB SEEKER </a></div>
    </div>
  </div>
<div class="clr"></div>

<script>
function registrationInto(redirect){
	switch(redirect){
		case 2:
			window.location.href="/users/saveLinkedinUser/2";			
			break;

		case 3:
			fillUniversity();
			//window.location.href="/users/saveLinkedinUser/3";			
			break;
	}
}
</script>


<style>
	body { font-size: 70%; }
	#ui-dialog-title-dialog-form { padding:5px; }
	fieldset { padding:0; border:0; margin-top:25px; }
	#dialog-form { background: none repeat scroll 0 0 transparent;overflow: hidden;}
</style>
	
<div id="dialog-form" style="display:none;">
	<div class="networker_popup_inner_content">
		<div class="network_university_popup_cancel_bttn">
		   	<div class="network_popup_cancel_bttn"> <a href="#" id ="closeEditBox"></a> </div>
		</div>
		<div style="clear:both"></div>
	<?php echo $this->Form->create('Networkers', array('url' => array('controller' => 'users', 'action' => 'saveLinkedinUser','3'))); ?>
		<fieldset>
			<div style="margin:auto;">
				<div style="clear:both"></div>
				<div class="required network_popup_row">
					<?php echo $form->input('Users.university',array('label'=> 'University',
																'type'=>'text',
																'class' => 'text_field_bg required ',
																'div'=>'text_field',
															));
						if(isset($uniErrors)):?><div class="error-message"><?php echo $uniErrors;?></div><?php endif; 
					?>
				</div>

				<div style="clear:both"></div>
				<div class="network_popup_row">
					<?php	echo $form->input('Networkers.graduate_degree_id', array('label' => 'Graduate Degree',
										'type'  => 'select',
										'options'=>$graduateDegrees,
										'empty' =>'Select Graduate Degree',
										'class' => 'networker_select_bg',
										'div'=>'text_field',
										)
						 );
					?>
				</div>
			
				<div style="clear:both"></div>
				<div class="network_popup_row">
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
				</div>
				<div class="edit_conact_button">
					<?php echo $form->submit('Save',array('div'=>false,'class'=>'networker-popup-submit')); ?>
				</div>
	
				
			</div>
		</fieldset>
	</div>
	<?php echo $form->end(); ?>
</div>

<script type="text/javascript">
	$("#NetworkersLinkedinUserSelectionForm").validate({
		  errorClass: 'error_input_message',
		   errorPlacement: function (error, element) {
		       error.insertAfter(element)
		       error.css({'overflow':'auto','width':'208px','margin-left':'132px'});
        	}
	});

	function fillUniversity(){
		$(document).ready(function(){
			$("#dialog-form").dialog({
				height:300,
				width:500,
				modal:true,
				top:50,
				resizable: false ,
				draggable: true,
				title:"User Information",
				show: { 
					effect: 'drop', 
					direction: "up" 
				},
			});

			$( "#dialog-form" ).parent("div").css({"padding":"0","opacity":"0.9","top":"100px","left":"222px", "background":"none","border":"none","width":"528px"});
	
			$("a#closeEditBox").click(function(){
				$("#dialog-form" ).dialog( "close" );
				return false;
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
<style>
.ui-dialog-titlebar { display:none; }
</style>
