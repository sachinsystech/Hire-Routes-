<?php //echo "<pre>"; print_r($this->Paginator); exit;?>

<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>My Jobs</span></a></li>
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/"><span>My Account</span></a></li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle content top menu start -->
		<div class="topMenu">
			<ul style="float:left">
				<li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>Personal</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/addContacts"><span>Add Contact(s)</span></a></li>
				<li>Data</li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="network_contact_edit_middleBox">
				<div class="edit_contact_form">
					<?php echo $this->Form->create('editContact', array('url' => array('controller' => 'networkers', 'action' => 'editContact'))); ?>
					<?php echo $form->input('id', array('label' => '',
											'type'  => 'hidden',
											'value' => isset($editContact['id'])?$editContact['id']:""
											));
					?>
					<div>
						<div style="float:left">
							<?php echo $form->input('contact_name', array('label' => '',
												'type'  => 'text',
												'class' => 'networker_contact_text_blk required alphabet',
												'value' => isset($editContact['contact_name'])?$editContact['contact_name']:""
												));
							?>					
						</div>
						<div style="float:left">
							<?php echo $form->input('contact_email', array('label' => '',
												'type'  => 'text',
												'class' => 'networker_contact_text_email required email',
												'value' => isset($editContact['contact_email'])?$editContact['contact_email']:""
												));
							?>					
						</div>
						<div><?php echo isset($validationErrors)?$validationErrors:""; ?> </div>
					</div>
					<div style="clear:both"></div>
					<div style="float:right">
						<?php echo $form->submit('Update',array('div'=>false,)); ?>
					</div>
					<?php echo $form->end(); ?>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
<script>
$(document).ready(function(){
	$("#editContactEditPersonalContactForm").validate();
});

</script>
