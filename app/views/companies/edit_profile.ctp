
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
					<h2>EDIT PROFILE</h2>
					<?php echo $this->Form->create('', array('url' => array('controller' => 'companies', 'action' => 'editProfile'))); ?>
					<div class="edit-profile-text-box">
					
					<?php echo $form->input('id', array('label' => '',
															'type'  => 'hidden',
															'value' => isset($payment['id'])?$payment['id']:""
															)
										 );
					?>
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
					
					<div class="clr"></div>
					<div class="edit-profile-text-box">							
						<?php	
								echo $form->input('Companies.company_name', array('label' => "<span>Company</span> ",
											'type'  => 'text',
											'class' => 'required',
											'value' => $company['company_name'],
											'div'=> false,
											)
							 );
						?>
					
					</div>
					<label class="error"><?php echo isset($company_error)?$company_error:null;?></label>
					<div class="clr"></div>
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('Companies.contact_name', array('label' => "<span>Company Name</span> ",
											'type'  => 'text',
											'class' => 'text_field_bg required alphabets',
											'value' => $company['contact_name'],
											'div'=> false,												
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-text-box">
						<?php	
								echo $form->input('Companies.contact_phone', array('label' => "<span>Contact Phone</span> ",
												'type'  => 'text',
												'class' => 'required number',
												'minlength' => '10',
												'value' => $company['contact_phone'],
												'div'=> false,												
											)
							 );
						?>					
					
					</div>
					<div class="clr"></div>
					
					<div class="edit-profile-clear-all">
						<label id="clearAll" onclick=" clear_fields();">Clear All</label>
					</div>
					<div class="save-profile-button">
						<?php echo $form->submit('Save Changes',array('div'=>false,)); ?>
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

<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
	$(document).ready(function(){
		$("#UserEditProfileForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				error.insertAfter(element)
				error.css({'margin-left':'170px','width':'290px','margin-top':'3px'});
			}
		});
	});     
	function clear_fields(){
		$('select, :text').val("");
		return false;
	}
</script>
