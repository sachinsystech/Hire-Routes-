
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="#"><span>My Jobs</span></a></li>
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
			<?php if(isset($contacts) && !isset($editContact)): ?>
			<div class="network_contact_middleBox">
				<?php echo $this->Form->create('deleteContacts', array('onsubmit'=>'return checkMultipleDelete();',
																	   'url' => array('controller' => 'networkers',
																					  'action' => 'deleteContacts',
																					  
																					  ),
																	   
																	   )
											   );
				?>
				<table style="width:85%;margin: auto;" class="contacts">
					<tr>
						<th style="width:8%;text-align:center"><input type="checkbox" onclick="toggleChecked(this.checked)"></th>
						<th style="width:35%;text-align:center"> Name </th>
						<th style="width:50%;text-align:center"> E-Mail </th>
						<th style="width:7%;text-align:center"></th>
					</tr>
					<?php $i=0;?>
					
					<?php foreach($contacts AS $contact):?>	
					<tr>
						<td>
							<?php	$i++;
									echo $form->input($contact['NetworkerContact']['id'], array(
																						'label' => "$i",
																						'type'  => 'checkbox',
																						'value' => $contact['NetworkerContact']['id'],
																						'class' => 'contact_checkbox'
																						)
													  );
							?>
						</td>
						<td><?php echo $contact['NetworkerContact']['contact_name']?></td>
						<td><?php echo $contact['NetworkerContact']['contact_email']?></td>
						<td>
							<img src="/img/media/b_edit.png" alt="Edit" onclick="return edit(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer" />
							<img src="/img/media/b_drop.png" alt="Delete" onclick="return drop(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer" />							
						</td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo $form->submit('Delete Selected',array('div'=>false,)); ?>
				<?php echo $form->end(); ?>
				<div style="clear:both;"></div>
				<div style="float:right;font-size: 93%;margin-right:50px"> < < < <?php echo $this->Paginator->numbers(); ?> > > ></div>
			</div>
			<?php endif;?>
			<?php if(isset($editContact)): ?>
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
												'class' => 'networker_contact_text_blk required',
												'value' => isset($editContact['contact_name'])?$editContact['contact_name']:""
												));
							?>					
						</div>
						<div style="float:left">
							<?php echo $form->input('contact_email', array('label' => '',
												'type'  => 'text',
												'class' => 'networker_contact_text_email required',
												'value' => isset($editContact['contact_email'])?$editContact['contact_email']:""
												));
							?>					
						</div>
					</div>
					<div style="clear:both"></div>
					<div style="float:right">
						<?php echo $form->submit('Update',array('div'=>false,)); ?>
					</div>
					<?php echo $form->end(); ?>
				</div>
			</div>
			<?php endif;?>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<?php
	$emailArray = array();
	foreach($contacts AS $value):
		$emailArray[$value['NetworkerContact']['id']] = $value['NetworkerContact']['contact_email'];
	endforeach;
?>

<script>

function edit(id){
	window.location.href="/networkers/personal/"+<?php echo $this->Session->read('Auth.User.id');?>+"/"+id;
}
function drop(ids){
	var r=confirm("Do you really want to delete this?");
	if (r==true){
		window.location.href="/networkers/deleteContacts/"+ids;
	}
	else
	{
		return false;
	}
}

function checkMultipleDelete(){
	var flag = false;
	var msg = "";
	$(".contact_checkbox").each( function() {
		if($(this).attr("checked")){
			//msg += "\n"+$(this).val();
			flag  = true;
		}
	})
	if(!flag){
		alert("You did not select any contact.");
		return false;
	}
	if(flag){
		var r = confirm("Do you really want to delete selected contact(s)?");
		if (r==true){
			window.location.href="/networkers/deleteContacts/"+ids;
		}
		else
		{
			return false;
		}
	}
}

function toggleChecked(status) {
	$(".contact_checkbox").each( function() {
		$(this).attr("checked",status);
	})
}
</script>