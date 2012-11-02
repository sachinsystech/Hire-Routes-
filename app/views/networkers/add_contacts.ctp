<div class="job_top-heading">
	<?php echo $this->element("welcome_name"); ?>
</div>
    <div class="job_container">
    	<div class="job_container_top_row">
			<!------------------------ Start Networker side menu ------------------------->
			<?php echo $this->element('side_menu');?>
			<!------------------------ End Networker side menu ------------------------->
            <div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left job-add-contact-p"> 
                    	<h2>ADD NEW CONTACTS</h2>
                    	<div class="job-gmail">Gmail<input class="job-import"type="button" onclick="importFromGmail();"/></div>
                       
                        <?php  echo $form->create('Contact', array('onsubmit'=>'return checkContact();',
																	'url' => array('controller' => 'networkers',
																				   'action' => 'addContacts'),
																	'type' =>'file',
												   		)
												);
						?>
						<div class="job-cv-part">
							<div class="job-cv">CSV</div>
							<div class="job-cv_right">
								<?php echo $form->file('CSVFILE',array('class'=>'required'));?>
							</div>
						</div>	
						<div class="clr"></div>	
						<div class="job-single-entry">
                        	<div class="job-single">Single Entry</div> 
                        	<div class="text-box-small"> 
                        		<?PHP $contact_name_value = isset($NetworkerContact['contact_name'])?$NetworkerContact['contact_name']:'Enter Name'?>
								<?php echo $form->input('contact_name', array('label' => false,
											'type'  => 'text',
											'div'	=>false,
											'value' =>$contact_name_value,
											'onblur' => "if(this.value==''){this.value='Enter Name'; this.style.color='#999999';}" ,
											'onfocus' => "if(this.value=='Enter Name'){this.value='';this.style.color='#000000';}" 
											));
								?>	
                        	</div>
                        	<div class="text-box-small"> 
        	                	<?PHP $contact_email_value = isset($NetworkerContact['contact_email'])?$NetworkerContact['contact_email']:'Enter E-mail'?>						
								<?php echo $form->input('contact_email', array('label' => false,
											'type'  => 'text',
											'div'	=> false,
											'value' => $contact_email_value,
											'onblur' => "if(this.value==''){this.value='Enter E-mail'; this.style.color='#999999';}",
											'onfocus' => "if(this.value=='Enter E-mail'){this.value='';this.style.color='#000000';}",
											));
								?>		
                        	</div>
   	                        <div><span id="name_error"></span></div>
							<div><label class='contact-error' style="clear: both;margin-left: 100px;width: 184px;"><?php echo isset($validationErrors['contact_name'])?$validationErrors['contact_name']:""; ?></label>
								<label class='contact-error' style='float:right'><?php echo isset($validationErrors['contact_email'])?$validationErrors['contact_email']:""; ?></label></div>
                        </div>
						<div style="display:none;">
							<?php //echo $form->submit('Add to contacts',array('div'=>false,'class'=>'add_contact_button')); ?>	
                        </div>
                        <div class="clr"></div>

						<?php if(isset($validationErrors['contact_email'])):?>
						<script>
							$("#ContactContactName").removeClass().addClass('networker_contact_text_blk');
							$("#ContactContactEmail").removeClass().addClass('net_cont_email_txt_bg_blk');
						</script>
						<?php endif; ?>
                        <div class="job-clear-all"><label id="clear" style="cursor:pointer;color:#4FA149 !important; text-decoration:underline;">Clear All</label></div>
                        <div class="login-button job-add-to">
    						<input type="submit" value="ADD TO CONTACTS"/>
    						<div class="clr"></div>
   						 </div>
   						 <?php echo $form->end(); ?>
                    </div>
                    
                    <div class="clr"></div>
                </div>
                
                <div class="job-right-bottom-right">
                	<div class="job_right_pagination job-sort-by contacts-sort-by">
                    	<div class="job_sort">Sort By:</div>
						<ul>
							<li style="width:16px;"><a class="link-button" href="/networkers/addContacts">All</a></li>	
							<?php
								foreach($alphabets AS $alphabet=>$count){
									$class = 'link-button';
									$url = "/networkers/addContacts/alpha:$alphabet";
									$urlLink = "<a href=".$url.">". $alphabet ."</a>";
									if($startWith ==$alphabet || $count<1){
										$class = 'current';
										$urlLink = $alphabet;
									}
							?>
							<li class="<?php echo $class; ?>" style="font:15px Arial,Helvetica,sans-serif;"><?php echo $urlLink; ?></a></li>
							<?php
							}
							?>
						</ul>
					</div>
					<div class="clr"></div>
					<?php if( isset($contacts) && $contacts!= null){ ?>       	
                    <div class="job-table-heading job-table-heading-border">
                    		<ul>
                            	<li class="job-table-name job-table-align2">Email</li>
                                <li class="job-table-status job-table-align2">Name</li>
                                <li class="job-table-source job-table-align2">Action</li>
                            </ul>
                    </div>
	                <?php foreach($contacts AS $contact):?>	
                    <div class="job-table-subheading job-table-heading-border">
                    		<ul>
                            	<li class="job-table-name"><?php echo $contact['NetworkerContact']['contact_email']?></li>
                            	<li class="job-table-status">&nbsp;<?php echo $contact['NetworkerContact']['contact_name']?></li>
                                <li class="job-table-source">
                                	<span onclick="return edit(<?php echo $contact['NetworkerContact']['id'] ?>,'<?php echo $contact['NetworkerContact']['contact_name']?>','<?php echo $contact['NetworkerContact']['contact_email']?>')" style="cursor:pointer;color:#4FA149 !important" >Edit / </span>
									<span onclick="return drop(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer;color:#4FA149 !important;" >Delete</span>
                                </li>
                            </ul>
                    </div>
                	<?php endforeach;?>
                	<?php }else{ ?>
                	<div class="job-empty-message">You don't have any contacts yet.</div>
                	<?php } ?>
                </div>
                <div class="clr"></div>
    			<?php if(isset($this->Paginator) && $this->Paginator->numbers()){?>
					<div class="contacts_pagination">
						<div class="networker_right_invitaion_pagination" style="width:643px !important;margin-top:5px;">
							<div>
								<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
											  
							<ul>
								<?php echo $this->Paginator->numbers(array('modulus'=>8,
																			'tag'=>'li',
																			'separator'=>false,)); ?>
							</ul>
								<?php echo $paginator->last(">>", array("class"=>"arrow_margin",
																		));?>
							</div>
						</div>
						<div class="networker_invitaion_preview_bttn"><?php echo $paginator->prev(''.__('', true), array(), null, array('class'=>'disabled'));?></div>
						<div class="networker_invitaion_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?></div>
					</div>
				<?php } ?> 
            </div>
       
        
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
</div>


<!---------- Personal Contacts ----->

<!---------- End Personal Contacts  -------->

<!------------                             -------------->
<script>
function checkContact(){
	
	if( ($("#ContactContactEmail").val()=="Enter E-mail" || $("#ContactContactEmail").val()=="" ) && $("#ContactCSVFILE").val()== "" || $("#ContactCSVFILE").val()== null ){
		alert("Please fill at least one field in CSV or User Email");
		$("#ContactContactEmail").focus();
		return false;	
	}
	
	if($("#ContactContactEmail").val()!="Enter E-mail" && $("#ContactContactEmail").val()!="" && ($("#ContactContactName").val()=="Enter Name" || $("#ContactContactName").val()=="")  ){
		$("#name_error").html("<label class='error' style='margin-left:100px'>Please enter Contact Name</label>");
		$("#ContactContactName").focus();
//		$("#name_error").html("<label class='error' style='margin-left:293px'>Please enter Contact E-mail</label>");
//		$("#ContactContactEmail").focus();
		return false;	
	}
	
	if($("#ContactContactEmail").val()!="Enter E-mail" && $("#ContactContactEmail").val()!="" && !validateContactEmail($("#ContactContactEmail").val())){
		$("#name_error").html("<label class='error' style='margin-left:293px'>Please enter valid E-mail</label>");
		$("#ContactContactEmail").focus();
		return false;			
	}
	
}
function validateContactEmail(elementValue){  
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
   return emailPattern.test(elementValue);  
} 
</script>
</div>

<script>
$(document).ready(function(){

	
	$("#clear").click(function(){
		$("input[type=text]").val("");
		$("input[type=file]").val("");
	});
	$("#networkersImportCsvForm").validate({
	rules: {
		'data[networkers][CSVFILE]': {
		  required: true,
		  accept: "csv"
		}
	  }
	});
});

function edit(id, contact_name, email){
	$(document).ready(function(){
		$("a#closeEditBox").click(function(){
			$("#editContacts label.error").remove();
			$("#editContacts" ).dialog( "close" );
			return false;
		});
		$("#editContacts").dialog({
			height:430,
			hide: "explode",		
			modal:true,
			resizable: false ,
			draggable: true
		});
		$( "#editContacts" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 	0px","opacity":"0.9","height":"230px","left":"222px","width":"630px","display":"block", "background":"none","border":"none"});
		$("#editContactId").val(id);
		$("#editContactContactName").val(contact_name);
		$("#editContactContactEmail").val(email);		
		$("#editContactAddContactsForm").validate({
			errorPlacement: function (error, element) {
				error.insertAfter(element)
				error.css({'margin-left':'172px','width':'236px'});
			}
		});
//		$("#editContactAddContactsForm").submit(function(){
	//		$("#editContactAddContactsForm").validate();
		//});
		
	});
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
	//$(".contact_checkbox").each( function() {
		//$(this).attr("checked",status);
	//})
}
</script>

<script>
function importFromGmail(){
	window.location.href="https://accounts.google.com/o/oauth2/auth?client_id=79643144563-rck00gk919jbv7enntdj5edin5tdjjbm.apps.googleusercontent.com&redirect_uri=http://www.hireroutes.com/networkers/addContacts&scope=https://www.google.com/m8/feeds/&response_type=code";
}
</script>
<?php if(isset($GmailContacts)){?>
<div style="display:none;" id = "gmailContacts">
	<div class="gmail-share-content">
    	<div class="gmail_popup_cancel_bttn">
           	<div class="payment_popup_cancel_bttn"><a href="#" id ="close"></a></div>
   		</div>
		 <div class="gmail-content">
			<?php  echo $this->Form->create('gmailContact', array('url' => array('controller' => 'networkers', 
																			 'action' => 'addContacts')));?>
		<?php if(isset($GmailContacts) && !empty($GmailContacts)) {?>								 
		<div style="margin-top: 8px; border-bottom:1px solid">
			<div style="float:left;width:178px;margin-top:-5px;" class= ""> 
				<input type="checkbox" onclick="toggleCheckedBox(this.checked)" id="checkAllBtn">
			</div>
			<div> <h2>E-Mail </h2> </div>
		</div>
   	    <div class="clr"></div>
		<div class="edit_contact_popup">
		<?php	
			echo $form->input("addGmailContact", array(	'class'=>'contact_checkbox',
															'label' => '',
															'type'  => 'select',
															'multiple' => 'checkbox',
															'options'=>$GmailContacts,
															'class' => 'contact_checkbox',
															'css' => 'margin-left:4px;width:17px'
													)
								  );
		  
		  
		?>
		</div>
		<div style="clear:both;margin: 7px 23px;">
			<input type="submit" value="ADD CONTACTS" onclick="return checkGmailCheckbox()" class="gmail-submit">
			<?php }
			else{ ?>
				<div style="text-align:center;margin-top:18px;">
					<span >No Contacts Found.</sapn> 
				</div>
			<?php } ?>
			<?php echo $form->end(); ?>
    	    <div class="clr"></div>
    		</div>
	    </div>
	</div>
</div>
<?php }?>  
<script>
	function toggleCheckedBox(status) {
		$('input[id^="GmailContactAddGmailContact"]').each(function() {
			$(this).attr({"checked":status});
			$(this).trigger('change');
		});
	}
	
	function checkGmailCheckbox(){
		var count = $(":checkbox:checked").length;
		
		if(count ==0 ){
			alert("Please select contact from list");
			return false;
		}
		else
			return true;
	}
</script>
<style>
.ez-checkbox-green{
float:left;
}
.contact_checkbox label{
	float: left;
    margin-left: 20px;
    margin-top: 8px;
}
.ui-dialog-titlebar { display:none; }
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
.payment_popup_cancel_bttn {

    background: url("/images/popup_cancel_bttn.png") no-repeat scroll 0 0 transparent;
    height: 72px;
    position: absolute;
    right: -31px;
    top: -28px;
    width: 72px;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
	$("a#close").click(function(){
		$("#gmailContacts" ).dialog( "close" );
		return false;
	});
	$("#gmailContacts").dialog({
		height:430,
		hide: "explode",		
		modal:true,
		resizable: false ,
		draggable: true
	});
	$( "#gmailContacts" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","opacity":"0.9","height":"500px","top":"100","left":"222px","width":"630px", "background":"none","border":"none"});

	<?php if(isset($GmailContacts)){?>
		$( "#about-dialog").show();
	<?php } ?>
	
});
</script>

<!-------------- Pop up for edit contacts ------------->
<div style="display:none;" id = "editContacts">
	<div class="gmail-edit-content">
    	<div class="gmail_popup_cancel_bttn">
           	<div class="payment_popup_cancel_bttn"><a href="#" id ="closeEditBox"></a></div>
   		</div>
		<div class="edit_contact_popup_box">
			<?php echo $this->Form->create('editContact', array('url' => array('controller' => 'networkers', 'action' => 'editContact'))); ?>
			<div style="display:none;" >
			<?php echo $form->input('id', array('label' => '',
											'type'  => 'text',
											'id' 	=> 'editContactId'
											));
					?>			 
			</div>
			<div class="job-right-top-left job-profile">
		    	<h2>EDIT CONTACT</h2>
		    	<div class="edit_contect_box">
					<div class="edit-profile-text-box">
					<?php echo $form->input('contact_name', array('label' => "<span>Name</span>",
											'type'  => 'text',
											'class' => 'networker_contact_text_blk required alphabet',
											'div'=> false,
											)
							 );
						?>
					</div>
					<div class="clr"></div>
					<div class="edit-profile-text-box">							
						<?php echo $form->input('contact_email', array('label' => "<span>Email</span> ",
											'type'  => 'text',
											'class' => 'networker_contact_text_email required email',
											'div'=> false,
											)
							 );
						?>
					</div>
					<div><?php echo isset($validationErrors['contact_email'])?$validationErrors['contact_email']:""; ?> </div>
				</div>
			</div>		
			<div class="edit_conact_button">
				<?php echo $form->submit('UPDATE',array('div'=>false,'class'=>'gmail-submit')); ?>
			</div>
			<div class="clr"></div>
			<?php echo $form->end(); ?>			
		</div>
	</div>
</div>

