
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
				<li><a href="/networkers/setting">Settings/Subscription</a></li>	
                <li class="active"><a href="/networkers">Profile</a></li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="middleBox">
				<div class="company_edit_form">
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
                                    echo $form->input('Networkers.contact_name', array('label' => 'Contact Name',
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
                                    echo $form->input('Networkers.address', array('label' => 'Address',
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
                                    echo $form->input('Networkers.city', array('label' => 'City',
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
                                    echo $form->input('Networkers.state', array('label' => 'State',
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
                                    echo $form->input('Networkers.contact_phone', array('label' => 'Contact Phone',
												'type'  => 'text',
												'class' => 'text_field_bg required number',
												'minlength' => '10',
												'value' => $phone,

												)
								 );
							?>
						</div>
						<div style="clear:both"></div>

						<div>
							<?php	echo $form->input('User.account_email', array('label' => 'Account Email',
												'type'  => 'text',
												'class' => 'text_field_bg required email',
												'value' => $user['account_email'],

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
