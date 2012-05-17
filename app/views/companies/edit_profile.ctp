<?php ?>
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
					<?php echo $this->Form->create('', array('url' => array('controller' => 'companies', 'action' => 'editProfile'))); ?>
						<div>
							<?php	echo $form->input('User.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $user['id']
																	)
														 );
							?>
							<?php	echo $form->input('Companies.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $company['id']
																	)
														 );
							?>
						</div>						
						<div style="clear:both"></div>
						
						<div class='required'>
							<?php	echo $form->input('Companies.company_name', array('label' => 'Company:',
												'type'  => 'text',
												'class' => 'text_field_bg required alphabets',
												'value' => $company['company_name'],
												)
								 );
							?>
						</div>
						<label class="error"><?php echo isset($company_error)?$company_error:null;?></label>	
						<div style="clear:both"></div>
												
						<div>
							<?php	echo $form->input('Companies.contact_name', array('label' => 'Company Name:',
												'type'  => 'text',
												'class' => 'text_field_bg required alphabets',
												'value' => $company['contact_name'],
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('Companies.contact_phone', array('label' => 'Contact Phone:',
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $company['contact_phone'],
												)
								 );
							?>
						</div>

						<div style="clear:both"></div>

						<div class="company_profile_field_row">
							<div style="float:right;margin-top:20px">
								<?php echo $form->submit('Save Changes',array('div'=>false,)); ?>	
							</div>
						</div>
						<div style="clear:both"></div>						

					<?php echo $form->end(); ?>	
				</div>
				
			</div>
			
			
			
			
			<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
	$(document).ready(function(){
		$("#UserEditProfileForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				error.insertAfter(element)
				error.css({'margin-left':'120px','width':'230px'});
			}
		});
	});     
	
</script>
