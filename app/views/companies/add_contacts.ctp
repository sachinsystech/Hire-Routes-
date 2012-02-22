
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/newJob"><span>My Jobs</span></a></li>
				<li class="active">My Network</li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/"><span>My Account</span></a></li>
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
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/companies/mynetwork"><span>My Network</span></a></li>
				<li class="active">Add Contact(s)</li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="middleBox">
				<div style="font-size:16px;font-weight:bold;padding:10px">Add New Contact(s)</div>
				<div style="margin-left:20px">
					<div class="setting_profile_row">
						<div class="setting_profile_field">1. Gmail</div>
						<div class="setting_profile_value"><button>Import from Gmail</button></div>
					</div>
				</div>
				<div style="margin-left:20px">
					<div class="setting_profile_row">
						<div class="setting_profile_field">2. Hotmail</div>
						<div class="setting_profile_value"><button>Import from Hotmail</button></div>
					</div>
				</div>
				<div style="margin-left:20px">
					<div class="setting_profile_row">
						<div class="setting_profile_field">3. CSV File</div>
						<div class="setting_profile_value"><input type="file" style="width:71%"><button>Import CSV file</button></div>
					</div>
				</div>
				<div style="margin-left:14px">
					<div>
						<?php echo $this->Form->create('Contact', array('url' => array('controller' => 'companies', 'action' => 'addContacts'))); ?>
						<div style="float:left">4. Single Entry</div>
						<div style="float:left">
							<?php echo $form->input('contact_name', array('label' => '',
												'type'  => 'text',
												'class' => 'company_contact_text required',
												));
							?>					
						</div>
						<div style="float:left">
							<?php echo $form->input('contact_email', array('label' => '',
												'type'  => 'text',
												'class' => 'company_contact_text required',
												));
							?>					
						</div>
						<div style="float:left">
							<?php echo $form->submit('Add to contacts',array('div'=>false,)); ?>				
						</div>

						<?php echo $form->end(); ?>
					</div>
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
</script>