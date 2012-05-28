
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
			<div class="middleBox">
				<div style="font-size:16px;font-weight:bold;padding:10px">Add New Contact(s)</div>
				
				<div class="add_contact_field_row">
					<div class="add_contact_label">1. Gmail</div>
					<div style="float:left">
						<button style="background:#00FF00; width: 150px;font-size: 12px;" onclick="importFromGmail();">Import from Gmail</button>
					</div>					
				</div>
				
				<div style="clear:both"></div>
				
				<div class="add_contact_field_row">
					<div class="add_contact_label">2. Hotmail</div>
					<div style="float:left"><button style="background:#00FF00; width: 150px;font-size: 12px;">Import from Hotmail</button></div>
				</div>
				<div style="clear:both"></div>
				
				<?php  echo $form->create('networkers', array('controller'=>'networkers','action' => 'importCsv', 'type' => 'file'));?>
				<div class="add_contact_field_row">
					<div class="add_contact_label">3. CSV File</div>
					<div style="float:left"><?php echo $form->file('CSVFILE',array('class'=>'csv_file_bg required'));?></div>					
					<div style="float:right"><?php echo $form->submit('Import CSV File',array('div'=>false,'class'=>'csv_file_button'));?></div>
				</div>
				<?php echo $form->end(); ?>				
				<div style="clear:both"></div>
				
				<div class="add_contact_field_row">
					<?php echo $this->Form->create('Contact', array('onsubmit'=>'return checkContact();',
																	'url' => array('controller' => 'networkers',
																				   'action' => 'addContacts',
																				   
																				   )
																	)
												   );
					?>
					<div class="add_contact_label">4. Single Entry</div>
					<div style="float:left">
						<?PHP $contact_name_value = isset($NetworkerContact['contact_name'])?$NetworkerContact['contact_name']:'Enter Name'?>
						<?php echo $form->input('contact_name', array('label' => '',
											'type'  => 'text',
											'class' => 'networker_contact_text',
											'value' =>$contact_name_value,
											'onblur' => "if(this.value==''){this.value='Enter Name'; this.style.color='#999999';this.style.fontStyle='italic';}" ,
											'onfocus' => "if(this.value=='Enter Name'){this.value='';this.style.color='#000000';this.style.fontStyle='normal';}" 
											));
						?>					
					</div>
					<div style="float:left">
						<?PHP $contact_email_value = isset($NetworkerContact['contact_email'])?$NetworkerContact['contact_email']:'Enter E-mail'?>						
						<?php echo $form->input('contact_email', array('label' => '',
											'type'  => 'text',
											'class' => 'net_cont_email_txt_bg',
											'value' => $contact_email_value,
											'onblur' => "if(this.value==''){this.value='Enter E-mail'; this.style.color='#999999';this.style.fontStyle='italic'}",
											'onfocus' => "if(this.value=='Enter E-mail'){this.value='';this.style.color='#000000';this.style.fontStyle='normal'}",
											));
						?>					
					</div>
					<div style="float:right">
						<?php echo $form->submit('Add to contacts',array('div'=>false,'class'=>'add_contact_button')); ?>				
					</div>
					<div style="clear:both"></div>
					<div><span id="name_error"></span></div>
					<div><label class='error' style='margin-left:92px'><?php echo isset($validationErrors['contact_name'])?$validationErrors['contact_name']:""; ?></label></div>
					<div><label class='error' style='margin-left:92px'><?php echo isset($validationErrors['contact_email'])?$validationErrors['contact_email']:""; ?></label></div>
					
					<?php if(isset($validationErrors['contact_email'])):?>
					<script>
						$("#ContactContactName").removeClass().addClass('networker_contact_text_blk');
						$("#ContactContactEmail").removeClass().addClass('net_cont_email_txt_bg_blk');
					</script>
					<?php endif; ?>
					<?php echo $form->end(); ?>
				</div>	
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->
<script>
function checkContact(){
	if($("#ContactContactName").val()=="Enter Name" || $("#ContactContactName").val()==""){
		$("#name_error").html("<label class='error' style='margin-left:92px'>This field is required.</label>");
		$("#ContactContactName").focus();
		return false;	
	}
	if($("#ContactContactEmail").val()=="Enter E-mail" || $("#ContactContactEmail").val()==""){
		$("#name_error").html("<label class='error' style='margin-left:253px'>Please enter Contact E-mail</label>");
		$("#ContactContactEmail").focus();
		return false;	
	}
	
	if(!validateEmail($("#ContactContactEmail").val())){
		$("#name_error").html("<label class='error' style='margin-left:253px'>Please enter valid E-mail</label>");
		$("#ContactContactEmail").focus();
		return false;			
	}
	
}
function validateEmail(elementValue){  
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
   return emailPattern.test(elementValue);  
} 
</script>
</div>

<script>
$(document).ready(function(){
	$("#networkersImportCsvForm").validate({
	rules: {
		'data[networkers][CSVFILE]': {
		  required: true,
		  accept: "csv"
		}
	  }
	});
});

</script>

<script>
function importFromGmail(){
	window.location.href="https://accounts.google.com/o/oauth2/auth?client_id=570913376629-e30ao1afv415iu3e8e1t1tatgqjpspm7.apps.googleusercontent.com&redirect_uri=http://qa.hireroutes.com/networkers/addContacts&scope=https://www.google.com/m8/feeds/&response_type=code";
}
</script>

<?php if(isset($GmailContacts)):?>
<div id="gmailContacts">

	<table style="font-size: 14px; margin: -3px 0 0 26px; width: 95%;" class="contacts">
		<tr>
			<th style="width:3%;text-align:center"><input type="checkbox" onclick="toggleChecked(this.checked)"></th>
			<th style="width:25%;text-align:center"> Name </th>
			<th style="width:72%;text-align:center"> E-Mail </th>
		</tr>
	</table>	
	<div style="height: 280px; margin: auto; overflow: auto;">
		<table style="font-size: 14px; margin-left: 26px; width: 95%;" class="contacts">
		
			<?php foreach($GmailContacts AS $contact):?>	
			<tr>
				<?php 
						$email = $contact->attributes()->address;
						$pieces = explode("@", $email);
						$contactName = explode(".", $pieces[0]);
						$contactName = preg_split('#([0-9])#i', $contactName[0]);
						$contactName =  ucfirst($contactName[0]);
					
				?>
				<td>
					<?php	
							echo $form->input($contactName, array(
																				'label' => '',
																				'type'  => 'checkbox',
																				'value' => $contact->attributes()->address,
																				'class' => 'contact_checkbox',
																				'css' => 'margin-left:4px;width:17px'
																				)
											  );
						
					?>
				</td>
			
				<td><?php echo $contactName; ?></td>
				<td><?php echo $email; ?></td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>
	<div style="clear:both;margin: 7px 23px;">
		<button style="font-size: 10px; font-weight: bold; width: 90px; float: right; margin: 3px;">Add Contacts</button>
	</div>	
</div>
<script>
	$("#gmailContacts").dialog({
		height:400,
		width:550,
		modal:true,
		resizable: false ,
		draggable: true,
		title:"Gmail Contacts: <br> ",
		show: { 
			effect: 'drop', 
			direction: "up" 
		},
	});
	
	function toggleChecked(status) {
		$(".contact_checkbox").each( function() {
			$(this).attr("checked",status);
		})
	}
</script>

<?php endif;?>
