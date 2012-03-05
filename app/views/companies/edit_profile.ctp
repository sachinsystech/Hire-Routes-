<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li>My Network</li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies">My Account</a></li>

				<li>My Employees</li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/">Profile</a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/paymentInfo">Payment Info</a></li>
				<li>Payment History</li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/editProfile"><span>Edit</span></a></li>
			</ul>
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
							<?php	echo $form->input('Company.id', array('label' => '',
																	'type'  => 'hidden',
																	'value' => $company['id']
																	)
														 );
							?>
						</div>						
						<div style="clear:both"></div>
						
						<div>
							<?php	echo $form->input('Company.company_name', array('label' => 'Company:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $company['company_name'],

												)
								 );
							?>
						</div>		
						<div style="clear:both"></div>
												
						<div>
							<?php	echo $form->input('Company.contact_name', array('label' => 'Company Name:',
												'type'  => 'text',
												'class' => 'text_field_bg required',
												'value' => $company['contact_name'],
												)
								 );
							?>
						</div>						
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('Company.contact_phone', array('label' => 'Contact Phone:',
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
		$("#UserEditProfileForm").validate();
	});     
</script>
