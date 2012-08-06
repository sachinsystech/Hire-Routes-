<?php 
	/**
	  * Edit personal contacts
	  */
?>

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
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle content list -->
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
