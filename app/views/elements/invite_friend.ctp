<?php
/**
* Share job element
*/
?>
<style>

.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
.ui-dialog-titlebar{
	display:none;
}
.friend_checkbox{
	margin-left:-15px;
	margin-top:2px;
	float:right;
	position:relative;
	*top:-5px;
}
.selectedFriends{
	border: 1px solid black;
	font-size: 13px;
	font-weight: bold;
	height: 260px;
	overflow: auto;
	padding: 10px;
	text-decoration: underline;
	width: 150px;
}
.selectedFriend{
	margin: 1px;
	margin-bottom: 3px;
	height: 30px;
}
.selectedFriendImage{
	height: 30px;
	width: 30px;
	margin: auto;
}
.selectedFriendCheckBox{
	position: absolute;
	top: 0px;
	left: 12px;
}
.selectedFriendName{
	font-size:.75em;
	text-align: left;
	float:left;
	width:100px;
	margin-left:1px;
}
.ui-dialog {
    overflow: visible;
    position: absolute;
}
.dialog-content{
	background:#F6F1E2;
}
.ui-autocomplete {
    font-size: 12px;
    max-height: 154px;
    max-width: 350px;
    overflow-x: hidden;
    overflow-y: auto;
}
#dialog{
	/* *height:600px;
	*position:absolute; */
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
* html .ui-autocomplete {
    height: 100px;
}
</style>

</style>
<script>
$(document).ready(function(){
	$(".about_popup_cancel_bttn").click(function(){
		$("#dialog" ).dialog( "close" );
		return false;
	});
});

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog" ).dialog({
		autoOpen: false,
		show: "blind",
		hide: "explode",
		width:900,
		height:700,
		closeOnEscape: false,
		resizable : false,
		modal:true
	});
	
	$( "#dialog" ).parent("div").css({"padding":"0","margin":"0px 0px 0px 0px","height":"600px !important",
	"overflow":"none","background":"none","border":"none"});
	$( "#opener" ).click(function() {
		$( "#dialog" ).dialog( "open" );
		return false;
	});
	
	$( "#dialog-message" ).dialog({
		modal: true,
		height:100,
		autoOpen: false,
		width:500,
		resizable : false
		/*buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}*/
	});
	$("#close_message_dialog").click(function(){
		$("#dialog-message").dialog( "close" );
	});
	$("#dialog-message").removeClass("ui-widget-content").addClass("dialog-content").parent("div").removeClass("ui-widget-content").addClass("dialog-content");
	$( "#dialog #inv-clear-all").click(function() {
		$("#dialog #InviteToEmail").val("");
		$("#dialog #ShareSubject").val("");
		$('#dialog #ShareMessage').val("");
		$('#autocompleteInviteEmail').val("");
		return false;
	});
	
});

function toggleAllChecked(status) {
	/*$("#dialog .friend_checkbox").each( function() {
		if($(this).parent("li").css('display')== "block"){
			$(this).attr("checked",status);
			var parentDiv = $(this).parent("li");
			if(status){
				parentDiv.css('opacity', 0.3);
			}
			else{
				parentDiv.css('opacity', 1.0);
			}
		}
	});
	*/
	if(status){
		$("#dialog .friend_checkbox").parent("li:visible").css('opacity', 0.3).children(".friend_checkbox").attr("checked",status);
	}else{
		$("#dialog .friend_checkbox").parent("li:visible").css('opacity', 1.0).children(".friend_checkbox").attr("checked",status);
	}
}

function selectFriend2(checkedFriend){
	var parentDiv = $(checkedFriend).parent("li");
	
	if($(checkedFriend).is(':checked')){
		parentDiv.css('opacity', 0.3);
	}
	else{
		parentDiv.css('opacity', 1.0);
	}
	
	//var title =$(parentDiv).find('img:first').attr("title");
	//var src =$(parentDiv).find('img:first').attr("src");
	//$(parentDiv).find('input:checkbox:first').attr("disabled",true);
	//$('.selectedFriends').append('<div class="selectedFriend"><div style="position:relative;float:left;"><div class="selectedFriendImage"><img width="30" height="30" src="' +src+'" title="'+title+ '"/></div><div class="selectedFriendCheckBox"><input class="facebookfriend" value="'+$(checkedFriend).val()+'" type="checkbox" style="margin:0px;" checked onclick="return deSelectFriend(this);"></div></div><div class="selectedFriendName">'+((title.split(" ",2)).toString()).replace(","," ")+'</div></div>');
}

</script>


<div id="dialog-message"> 
	<div class="data"> 
	</div>
	<div class="mesaage-dialog-div">
		<button id="close_message_dialog" >OK </button> 
	</div>
</div>

<div id ="dialog" >	
	<!-- :: :: :: :: :: :: :: :: :: :: :: :: :: -->
	<div class="job-share-content">
        	<div class="about_popup_cancel_bttn_row1">
               	<div class="about_popup_cancel_bttn"><a href="#"></a></div>
       		</div>
            
            <div class="job-share-left">
            	<ul>
                	<li><a class="job-share-fb" onclick='showView(1);'></a></li>
                    <li><a class="job-share-in" onclick='showView(2);'></a></li>
                    <li><a class="job-share-twit" onclick='showView(3);'></a></li>
                    <li><a class="job-share-mail" onclick='showView(4);'></a></li>
                </ul>
            </div>
            
            <div class="job-share-right">
            	<!--<h2>SEND A JOB INVITE TO...</h2>-->
            	<h2>SEND A HIRE ROUTES INVITATION TO...</h2>
				<?php echo $form->create('Share', array('action'=>'job', 'onsubmit'=>'return validateEmail(InviteToEmail.value);')); ?>
                
				<?php echo $form->input('code', array('label' => '',
					'id'=>'code',
					'type' => 'hidden',
					'value'=>isset($intermediateCode)?$intermediateCode:"",
				));?>
				<?php echo $form->input('invitationCode', array('label' => '',
					'id'=>'invitationCode',
					'type' => 'hidden',
					'value'=>isset($invitationCode)?$invitationCode:"",
				));?>
				
				<div class="job-share-field" id="invite-e-mail">
                	<div class="job-share-text">EMAIL</div>
                	<?php if($this->Session->read("UserRole") == NETWORKER ){ ?>                	
                    <div style="display:none;">
                    	<input id="InviteToEmail" type="text" placeholder="Enter a friend's email address" />
                   	</div>
			       	<div class="job-share-tb">
                    	<input id="autocompleteInviteEmail" type="text" placeholder="Enter a friend's email address" />
                   	</div>
			       	<?php }else{ ?>
                    <div class="job-share-tb">
                    	<input id="InviteToEmail" type="text" placeholder="Enter a friend's email address" />
                   	</div>
                   	<?php } ?>
                    <div class="clr"></div>
                </div>
			
                <div class="job-share-field">
                	<div class="job-share-text job-share-margin">SUBJECT</div>
                    <div class="job-share-tb-top">
						<?php echo $form->input('subject', array('label' => '',
														'type' => 'text',
														//'class'=> 'required',
														'placeholder'=>"Subject ",
														'div' => false
														
						));?>
					</div>
                    <div class="clr"></div>
                </div>
                <div class="job-share-field">
                	<div class="job-share-text">MESSAGE</div>
                    <div class="job-share-tb1">
						<?php echo $form->input('message', array('label' => '',
							'type' => 'textarea',
							'class'=> 'msg_txtarear',
							'placeholder'=> 'Type message here ..',
							'value'=>"I'd like to invite you to join Hire Routes!",
						));?>
					</div>
                    <div class="clr"></div>
                </div>
				<div style="float:left" >
					<?php echo $form->input('filter_friends', array('label' => '',
								'type' => 'text',
								'id'=>'autocomplete',
								'class'=> 'searchfield',
								'div'=> false,
								'autocomplete'=> 'off',
								'value'=>'Search Friends Here...',
								'onfocus'=>"if(this.value=='Search Friends Here...') {this.value = '';}",
								'onblur'=>"if(this.value==''){this.value='Search Friends Here...';}"
					));?>
				</div>
				<div id='other_share_job'></div>
				
                <div class="job-share-ppl">
                	<ul>
                    	<li> <img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                        <li><img src="/images/icon_image.jpg" /></li>
                    </ul>
                    <div class="clr"></div>
                </div>
				
               	<div class="job-share-bottom">
                       <div class="js_invite">
							<div class="js_invite_all">Invite All</div>
							<div class="js-check-box-popup">
								<!-- span class="checkbox_selected" onclick="make_bg_change(this);"></span -->
								<input type="checkbox" class="styled" id="gender_checkbox" onclick="toggleAllChecked(this.checked)">                                         
							</div>
					   </div>
					   
                        <div class="js_clear_all"><a href="#"><input id="inv-clear-all" type="button" value="Clear All">Clear All</a></div>
				</div>
				
				<div id="submitLoaderImg" class="submitloader"></div>
				
                <div class="login-button pop-up-button">
						<input type="submit" value="SEND INVITE" id='share' >
						<div class="clr"></div>
				</div>
            </div>
        </div>
    </div>

</div>
<div id="opener"></div>

<script>
function showView(type){
	$("#InviteToEmail").val("");
	$("#dialog #ShareSubject").val("");
	$('#dialog #invite-e-mail').hide();
	$('#dialog .js_invite').css("visibility", "visible");
	$('#dialog .job-share-ppl').show();
	
	$("#dialog #share").unbind();
	$("#autocomplete").unbind();
	$("#autocomplete").hide();
	$("#autocomplete").hide();
	$("#opener").click();
	$('#dialog #container').after("<div class='ui-widget-overlay' style='width: 1350px; height: 779px; z-index: 1001;'></div>");
	$('.selectedFriends .selectedFriend').remove();
	switch(type){
		case 1:
			setView('Facebook');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillFacebookFriend();
			$("#share").click(facebookCommentInvitation);
			$('#autocomplete').val('Search Friends Here...');
			$('#ff_list').hide();
			$('#ff_list').html('');
			$("#autocomplete").keyup(filterFriendList);
			break;
		case 2:
			setView('LinkedIn');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillLinkedinFriend();
			$("#share").click(linkedInCommentInvitation);
			$('#autocomplete').val('Search Friends Here...');
			$('#ff_list').hide();
			$('#ff_list').html('');
			$("#autocomplete").keyup(filterFriendList);
			break;
		case 3:
			setView('Twitter');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillTwitterFriend();
			$("#share").click(TwitterCommentInvitation);
			$('#autocomplete').val('Search Friends Here...');
			$('#ff_list').hide();
			$('#ff_list').html('');
			$("#autocomplete").keyup(filterFriendList);
			break;
		case 4:
			$('#invite-e-mail').show();
			$('.js_invite').css("visibility", "hidden");
			$('.job-share-ppl').hide();
			setView('Email');
			$("#share").click(emailInvitaion);
			break;
	}
}

function setView(value)
{
	$('#dialog #message').hide();
	$('#dialog .api_menu li').removeClass('active');
	$('#dialog #li'+value).addClass('active');
	
	if(value=='Email')
	{
	$('#dialog #other').html("");
	$('#dialog #to').html("<div style='padding-bottom:10px;' class='s_j_email'><strong>Email:</strong><textarea id='InviteToEmail' name='toEmail' class='email_msg_txtarear' rows='1'></textarea></div>");
	}
	else
	{
	$('#dialog #to').html("");
	
	$('#dialog #other').html("<div style='padding-bottom:20px; padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right;margin-top:12px;' class='s_w_e'>Share with everyone<input style='float:right' type='checkbox'/></div><div id='filtered_friend'></div><div id='imageDiv'>");
	
	$('#dialog #imageDiv').html('<p><img src="/images/ajax-loader.gif" width="425" height="21" class="sharejob_ajax_loader"/></p>');
	}
	return false;
}

function validateEmail(elementValue){
	elementValue = $.trim(elementValue);
	if( elementValue.charAt(elementValue.length-1) == ","){
		elementValue = elementValue.substr(0,elementValue.length - 1);
	}
	var mail=elementValue.split(",");
	
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	for(var i=0;i<mail.length;i++)
	if(!emailPattern.test(mail[i])){
		alert("Either email is invalid or its not separated by comma.");
		return false;
	}
	return true;
}

function validateCheckedUser(){
	var flag = false;
	$("#dialog .friend_checkbox").each( function() {
		if($(this).attr("checked")){
			flag = true;
			}
		})
		if(!flag){
		alert("Please Select at lease one friend.");
		return false;
	}
	return true;
}

function validateInviteFormField(){
	if($('#dialog #ShareSubject').val()==""){
		alert('Subject cant be empty.');
		return false;
	}
	if($('#dialog #ShareMessage').val()==""){
		alert('Please enter message.');
		return false;
	}
	return true;
}
/*
function createHTMLforFillingFriends(friends){

	$('.selectedFriends .selectedFriend').remove();
	var length = friends.length;
	
	html="";
	for(i=0;i<length;i++){
		html += '<div class="contactBox"><div style="position:relative"><div class="contactImage"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend(this);"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
	}
	$("#other").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right' class='s_w_e'>Invite All<input style='float:right'type='checkbox' onclick='return checkAll(this); ' /></div><div id='imageDiv'>"+html+"</div>");
}
*/
function createHTMLforFillingFriends(friends){
	$('#invite-e-mail').hide();
	var length = friends.length;
	html="";
	for(i=0;i<length;i++){
		html += '<li> <img src="' + friends[i].url +'"  title="'+ friends[i].name + '" ><input class="friend_checkbox" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend2(this);"></li>';
	}
	$(".job-share-ppl").html("<ul>"+html+"<ul/><div class='no_friend_found'></div>");
	//$(".job-share-ppl").html("<ul>"+html+"<ul/>");
}

function selectFriend(checkedFriend){
	var parentDiv=$($(checkedFriend).parent()).parent();
	var title =$(parentDiv).find('img:first').attr("title");
	var src =$(parentDiv).find('img:first').attr("src");
	$(parentDiv).parent().css('opacity', 0.3);
	$(parentDiv).find('input:checkbox:first').attr("disabled",true);
	$('.selectedFriends').append('<div class="selectedFriend"><div style="position:relative;float:left;"><div class="selectedFriendImage"><img width="30" height="30" src="' +src+'" title="'+title+ '"/></div><div class="selectedFriendCheckBox"><input class="facebookfriend" value="'+$(checkedFriend).val()+'" type="checkbox" style="margin:0px;" checked onclick="return deSelectFriend(this);"></div></div><div class="selectedFriendName">'+((title.split(" ",2)).toString()).replace(","," ")+'</div></div>');
}

function deSelectFriend(unCheckedFriend){
	$("#imageDiv .contactBox").filter(function(){ var opac=parseFloat($(this).css('opacity')); opac=opac.toFixed(1); return (opac==0.3)?true:false;}).each(function(){
		if($(this).find('input:checkbox:first').val()!=undefined && $(this).find('input:checkbox:first').val()==$(unCheckedFriend).val()){
			$(this).find('input:checkbox:first').attr("checked",false).attr("disabled",false);
			$(this).css('opacity',1.0);
		}
	});
	$($($(unCheckedFriend).parent()).parent()).parent().remove();
}

function checkAll(field){
	var flag=field.checked;
	if(flag){
		$(".selectedFriends").append($('#imageDiv').html());
		$("#imageDiv .contactBox:visible").css('opacity',0.3).find('input:checkbox:first').attr("checked",true).attr("disabled",true);
		$(".selectedFriends .contactBox").removeClass('contactBox').addClass('selectedFriend').find('img:first').attr("width",30).attr("height",30).parent().removeClass('contactImage').addClass('selectedFriendImage').parent().css('float','left').find('input:checkbox:first').attr("checked",true).css("margin",'0').attr("onClick","return deSelectFriend(this)").parent().removeClass('contactCheckBox').addClass('selectedFriendCheckBox');
		$(".selectedFriends .contactName").removeClass('contactName').addClass('selectedFriendName');
	}else{
		$(".selectedFriend").remove();
		$("#imageDiv .contactBox ").filter(function(){ var opac=parseFloat($(this).css('opacity')); opac=opac.toFixed(1); return (opac==0.3)?true:false;}).css('opacity',1.0).find('input:checkbox:first').attr("checked",false).attr("disabled",false);
	}
}


</script>

<script>

/************************** close**********************************/
function close(){
$( "#dialog" ).dialog( "close" );
window.location.href = jQuery(location).attr('href');
}

/**************************** 1).Fill facebook Friends ******************************/

function fillFacebookFriend(){
	$('#dialog #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/fbloader.gif" width="50px" />'+
	'<img src="/images/fb_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/facebook/getFaceBookFriendList',
		data: "&source=invitation",
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingFriends(response.data);
					$("#autocomplete").show();
					filterFriendList();
					if(jQuery.isEmptyObject(response.data)){
						$(".no_friend_found").css("display","block");
						$(".no_friend_found").text("No friends available at this time, Please try again later.")
					}
					break;
				case 1: // we don't have user's facebook token
					window.open(response.URL);
					break;
				case 2: // something went wrong when we connect with facebook.Need to login by facebook
					if(response.message){
					$( "#dialog-message .data" ).html(response.message);
					}
					else{
						$( "#dialog-message .data" ).html("Something went wrong. Please try later or contact to site admin");
					}
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error: function(message){
			alert(message);
		}
	});
}

/**************************** 2). Fill Linkedin Friends ******************************/
function fillLinkedinFriend(){
	$('#dialog  #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/liloader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/linkedin/getLinkedinFriendList',
		data: "&source=invitation",
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingFriends(response.data);
					$("#autocomplete").show();
					filterFriendList();
					if(jQuery.isEmptyObject(response.data)){
						$(".no_friend_found").css("display","block");
						$(".no_friend_found").text("No friends available at this time, Please try again later.")
					}
					break;
				case 1: // we don't have user's linked token
					window.open(response.URL);
					break;
				case 2: // something went wrong when we connect with facebook.Need to login by facebook
					$( "#dialog-message .data" ).html(" something went wrong. Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
				default :
					$( "#dialog-message .data" ).html(" something went wrong. Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
			}
		},
		error: function(message){
			$('#dialog  #submitLoaderImg').html('');
			$( "#dialog-message .data" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
}
/**************************** 3). Fill Twitter Friends ******************************/
function fillTwitterFriend(){
	$('#dialog  #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;" ><img src="/images/twitterLoader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/twitter/getTwitterFriendList',
		data: "&source=invitation",
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingFriends(response.data);
					$("#autocomplete").show();
					filterFriendList();
					if(jQuery.isEmptyObject(response.data)){
						//$("#autocomplete").click();
						$(".no_friend_found").css("display","block");
						$(".no_friend_found").text("No friends available at this time, Please try again later.")
					}
					break;
				case 1: // we don't have user's twitter token
					window.open(response.URL);
					break;
				case 2: 
					$( "#dialog-message .data" ).html("something went wrong.Please contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error: function(message){
			$('#dialog  #submitLoaderImg').html('');
			$( "#dialog-message .data" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
}
/************************* Email Sharing ***********************/
function emailInvitaion(){
	var to_email=$('#InviteToEmail').val();
	if(!validateEmail(to_email)){
		return false;
	}
	if(!validateInviteFormField()){
		return false;
	}

	$('#dialog #submitLoaderImg').show();
	$.ajax({
		url: "/jobsharing/sendEmailInvitaion",
		type: "post",
		dataType: 'json',
		data: {
				toEmail : $('#InviteToEmail').val(),
				message : $('#dialog #ShareMessage').val(),
				subject : $('#dialog #ShareSubject').val(),
				invitationCode:$('#invitationCode').val()
			},

		success: function(response){
			$('#dialog  #submitLoaderImg').hide();
			switch(response.error){
				case 0:
					$("#ShareSubject").val("");				
					$( "#dialog-message .data" ).html(" E-mail sent successfully.");
					$( "#dialog-message" ).dialog("open");
					$('#InviteToEmail').val("");
					$("#autocompleteInviteEmail").val("");
					$('#dialog  #submitLoaderImg').hide();
					setView('Email');
					break;
				case 1:
					$( "#dialog-message .data" ).html("Something went wrong please try later or contact to site admin.");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message .data" ).html(response.message);
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error:function(response){
			$('#dialog  #submitLoaderImg').html('');
			$( "#dialog-message .data" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
	return false;
}
function filterFriendList(){
	var textValue = $('#autocomplete').val();
	var user = jQuery.makeArray();
	//$('.s_w_e input:checked').attr('checked', false);
	var foundFrd=false;
	//$('#ff_list_share_job').css("display","none");
	if(textValue=='' || textValue=='Search Friends Here...'){
		$('.job-share-ppl li').css({"display":"block"});
		//$("#shareJobImageDiv").css("visibility","visible");
		//$('#shareJobImageDiv .contactBox').css({"display":"block","visibility":"visible"});
		$(".no_friend_found").css("display","none");
		lastTextValue="";
		return false;
	}
	
	textValue = textValue.toLowerCase();
	$('.job-share-ppl li').css({"display":"none"});

	$(".job-share-ppl ul img[title]").filter(function(){ 
		if((this.title.toLowerCase()).indexOf(textValue)===0){
			$(".no_friend_found").css("display","none");
			return foundFrd=true;
		}
		else return false; 
	}).parent("li").css({"display":"block"});
	
	if(foundFrd === false)
		$(".no_friend_found").css("display","block");
		$(".no_friend_found").text(" Sorry, you don't have a friend whose name started with this letter or word.")

	return false;
}

function facebookCommentInvitation(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateInviteFormField()){
		return false;
	}
	var i=0;
	var user = [];
	$("input[class=friend_checkbox]:checked").each(function (i){
		var o = {};
		o.id = $(this).attr("value");
		o.name = $(this).attr("title");
		user.push(o);
	});
	$('#dialog  #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/facebook/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&subject="+$("#dialog #ShareSubject").val()+
				"&message="+$("#dialog #ShareMessage").val()+
				"&invitationCode="+$('#invitationCode').val(),
				

		success: function(response){
			$('#dialog  #submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					// show success message
					$("#ShareSubject").val("");					
					$( "#dialog-message .data" ).html("Your invitation has been sent successfully to facebook users.");
					$( "#dialog-message" ).dialog("open");
					fillFacebookFriend();
					break;
				case 1:
					$( "#dialog-message .data" ).html("Something went wrong. Please try later or contact to site admin.");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message .data" ).html(response.message);
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error: function(message){
			$('#dialog  #submitLoaderImg').html('');
			alert(message);
		}
	});
	return false;
}
/****** linked in comment ******/

function linkedInCommentInvitation(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateInviteFormField()){
		return false;
	}
	
	var i=0;
	var user = [];

	$("input[class=friend_checkbox]:checked").each(function (i){
		var o = {};
		o.id = $(this).attr("value");
		o.name = $(this).attr("title");
		user.push(o);
	});

	$('#dialog  #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/Linkedin/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&subject="+$("#ShareSubject").val()+
				"&message="+$("#dialog #ShareMessage").val()+
				"&invitationCode="+$('#invitationCode').val(),
				
		success: function(response){
			$('#dialog  #submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$("#ShareSubject").val("");				
					$( "#dialog-message .data" ).html("Your invitation has been sent successfully to Linkedin users.");
					$( "#dialog-message" ).dialog("open");
					$('#dialog  #submitLoaderImg').html('');
					fillLinkedinFriend();
					break;
				case 1:
					$( "#dialog-message .data" ).html(" something went wrong.Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message .data" ).html(response.message);
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error: function(message){
			$('#dialog  #submitLoaderImg').html('');
			alert(" something went wrong. Please try later or contact to site admin");
		}
	});
	return false;
}

/****** Twitter comment ******/

function TwitterCommentInvitation(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateInviteFormField()){
		return false;
	}
	var i=0;
	var user = [];

	$("input[class=friend_checkbox]:checked").each(function (i){
		var o = {};
		o.id = $(this).attr("value");
		o.name = $(this).attr("title");
		user.push(o);
	});
	
	$('#dialog  #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/twitter/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&subject="+$("#ShareSubject").val()+
				"&message="+$("#dialog #ShareMessage").val()+
				"&invitationCode="+$('#dialog #invitationCode').val(),
				
		success: function(response){
			$('#dialog  #submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$("#ShareSubject").val("");				
					$( "#dialog-message .data" ).html("Your invitation has been sent successfully to Twitter follower.");
					$( "#dialog-message" ).dialog("open");
					$('#dialog  #submitLoaderImg').html('');
					fillTwitterFriend();
					break;
				case 1:
					$( "#dialog-message .data" ).html(" something went wrong.Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message .data" ).html(response.message);
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error: function(message){
			$('#dialog  #submitLoaderImg').html('');
			$( "#dialog-message .data" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
	return false;
}

/**********************/
var name = jQuery.makeArray();
var name_array = jQuery.makeArray();
$('.contactName').each(function(index){
name[index] = $(this).html();
alert(name[index]);
});

</script>

<script>
$(document).ready(function(){
	$("#ShareJobForm").validate();
	$("#autocompleteInviteEmail").blur(function(){
	    $('#InviteToEmail').val($(this).val());
	});
	$("#autocompleteInviteEmail").submit(function(){
	    $('#InviteToEmail').val($(this).val());
	});
	$("#autocompleteInviteEmail").autocomplete({
			minLength:1,
			source: function( request, response ) {
				var key_term;
				if(request.term.lastIndexOf(",") != -1){
					key_term =  request.term.substring(request.term.lastIndexOf(",") + 1);
				}else{
					key_term = request.term;
				}
				$.ajax({
					url: "/Utilities/networkerContacts/startWith:"+key_term,
					dataType: "json",
					beforeSend: function(){
				 		/*$('#UserUniversity').parent("div").parent("div").append('<div class="loader"><img src="/images/loading_transparent2.gif" border="0" alt="Loading, please wait..."  / ></div>');*/
			   		},
			   		complete: function(){
			   	    	$('.loader').remove();
			   		},
					success: function( data ) {
						if(data == null) return;
						response( $.map( data, function(item) {
							if(data == null) return;
							return {
								value: item.user_name,
								key: item.id
							}
						}));
					}
				});
			},
			select: function( event, ui ) {
				//alert($('#InviteToEmail').val());
				$('#InviteToEmail').val(ui.item.value);
				var terms = $("#autocompleteInviteEmail").val()+ui.item.value;
				terms = terms.split(",");
				this.value = terms.join(",");
				$("#autocompleteInviteEmail").val(this.value+",");
                return false;
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-all" );
			}
		});
});
</script>
