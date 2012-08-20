<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
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
                    	<div class="job-gmail">Gmail: <input class="job-import"type="button" onclick="importFromGmail();"/></div>
                       
                        <?php  echo $form->create('Contact', array('onsubmit'=>'return checkContact();',
																	'url' => array('controller' => 'networkers',
																				   'action' => 'addContacts'),
																	'type' =>'file',
												   		)
												);
						?>
						<div class="job-cv-part">
							<div class="job-cv">CSV:</div>
							<div class="job-cv_right">
								<?php echo $form->file('CSVFILE',array('class'=>'required'));?>
							</div>
						</div>	

						<div class="job-single-entry">
                        	<div class="job-single">Single Entry:</div> 
                        	<div class="text-box-small"> 
                        		<?PHP $contact_name_value = isset($NetworkerContact['contact_name'])?$NetworkerContact['contact_name']:'Enter Name'?>
								<?php echo $form->input('contact_name', array('label' => false,
											'type'  => 'text',
											'div'	=>false,
											'value' =>$contact_name_value,
											'onblur' => "if(this.value==''){this.value='Enter Name'; this.style.color='#999999';this.style.fontStyle='italic';}" ,
											'onfocus' => "if(this.value=='Enter Name'){this.value='';this.style.color='#000000';this.style.fontStyle='normal';}" 
											));
								?>	
                        	</div>
                        	<div class="text-box-small"> 
        	                	<?PHP $contact_email_value = isset($NetworkerContact['contact_email'])?$NetworkerContact['contact_email']:'Enter E-mail'?>						
								<?php echo $form->input('contact_email', array('label' => false,
											'type'  => 'text',
											'div'	=> false,
											'value' => $contact_email_value,
											'onblur' => "if(this.value==''){this.value='Enter E-mail'; this.style.color='#999999';this.style.fontStyle='italic'}",
											'onfocus' => "if(this.value=='Enter E-mail'){this.value='';this.style.color='#000000';this.style.fontStyle='normal'}",
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
                	<div class="job_right_pagination job-sort-by">
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
                            	<li class="job-table-status"><?php echo $contact['NetworkerContact']['contact_name']?></li>
                                <li class="job-table-source">
                                	<span onclick="return edit(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer;color:#4FA149 !important" >Edit</span>
									<span onclick="return drop(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer;color:#4FA149 !important;" >Delete</span>
                                </li>
                            </ul>
                    </div>
                	<?php endforeach;?>
                </div>
    
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
		alert("Please fill atleast one in CSV or User Email");
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
	
	if($("#ContactContactEmail").val()!="Enter E-mail" && $("#ContactContactEmail").val()!="" && !validateEmail($("#ContactContactEmail").val())){
		$("#name_error").html("<label class='error' style='margin-left:293px'>Please enter valid E-mail</label>");
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
	$("#clear").click(function(){
	
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

function edit(id){
	window.location.href="/networkers/editPersonalContact/"+id;
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

<script>
function importFromGmail(){
	window.location.href="https://accounts.google.com/o/oauth2/auth?client_id=570913376629-e30ao1afv415iu3e8e1t1tatgqjpspm7.apps.googleusercontent.com&redirect_uri=http://qa.hireroutes.com/networkers/addContacts&scope=https://www.google.com/m8/feeds/&response_type=code";
}
</script>
<?php if(isset($GmailContacts)){?>
<div id="gmailContacts" >
	<?php  echo $this->Form->create('gmailContact', array('url' => array('controller' => 'networkers', 
																		 'action' => 'addContacts')));?>
	<?php if(isset($GmailContacts) && !empty($GmailContacts)) {?>								 
	<div style="border-bottom:1px solid">
		<div style="float:left;width:178px;margin-left:5px;"> 
			<input type="checkbox" onclick="toggleChecked(this.checked)">
		</div>
		<div> <b> E-Mail </b> </div>
	</div>
	<div style="height: 280px; margin: auto; overflow: auto;">
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
		<input type="submit" style="font-size:10px;font-weight:bold;width:90px;float:right;margin:3px;"
			value="Add Contacts" onclick="return checkGmailCheckbox()">
		<?php }
		else{ ?>
			<div style="text-align:center;">
				<span >No contacts Found</sapn> 
			</div>
		<?php } ?>
	<?php echo $form->end(); ?>
	<?php }?>
	
	</div>	
</div>
<script>
	$("#gmailContacts").dialog({
		height:430,
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
		$("input:checkbox").each( function() {
			$(this).attr("checked",status);
		})
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

