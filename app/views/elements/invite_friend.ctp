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
		closeOnEscape: false,
		modal:true
	});
	
	$( "#dialog" ).parent("div").css({"padding":"0","margin":"0px 0px 0px 0px","height":"600px","overflow":"none","top":"0","background":"none","border":"none"});
	$( "#opener" ).click(function() {
		$( "#dialog" ).css( "top" ,'-50');
		$( "#dialog" ).dialog( "open" );
		return false;
	});
	
	$( "#dialog-message" ).dialog({
		modal: true,
		autoOpen: false,
		width:500,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#inv-clear-all").click(function() {
		$("#ShareToEmail").val("");
		$("#ShareSubject").val("");
		$('#ShareMessage').val("");
		return false;
	});
	
});

function toggleAllChecked(status) {
	$(".friend_checkbox").each( function() {
		$(this).attr("checked",status);
	})
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


<div id="dialog-message"></div>

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
            	<h2>SEND A JOB INVITE TO...</h2>
				<?php echo $form->create('Share', array('action'=>'job', 'onsubmit'=>'return validateEmail(ShareToEmail.value);')); ?>
                
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
				
				<div class="job-share-field" id="e-mail">
                	<div class="job-share-text">EMAIL</div>
                    <div class="job-share-tb"><input id="ShareToEmail" type="text" placeholder="Enter a friend's email address" /></input></div>
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
							'value'=>"I'd like to bring a job opportunity to your attention. "
						));?>
					</div>
                    <div class="clr"></div>
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
	$("#ShareToEmail").val("");
	$("#ShareSubject").val("");
	$('#e-mail').hide();
	$('.js_invite').css("visibility", "visible");
	$('.job-share-ppl').show();
	
	$("#share").unbind();
	$("#autocomplete").unbind();
	$("#autocomplete").hide();
	$("#opener").click();
	$('#container').after("<div class='ui-widget-overlay' style='width: 1350px; height: 779px; z-index: 1001;'></div>");
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
			$('#e-mail').show();
			$('.js_invite').css("visibility", "hidden");
			$('.job-share-ppl').hide();
			setView('Email');
			$("#share").click(emailInvitaion);
			break;
	}
}

function setView(value)
{
	$('#message').hide();
	$('.api_menu li').removeClass('active');
	$('#li'+value).addClass('active');
	
	if(value=='Email')
	{
	$('#other').html("");
	$('#to').html("<div style='padding-bottom:10px;' class='s_j_email'><strong>Email:</strong><textarea id='ShareToEmail' name='toEmail' class='email_msg_txtarear' rows='1'></textarea></div>");
	}
	else
	{
	$('#to').html("");
	
	$('#other').html("<div style='padding-bottom:20px; padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right;margin-top:12px;' class='s_w_e'>Share with everyone<input style='float:right' type='checkbox'/></div><div id='filtered_friend'></div><div id='imageDiv'>");
	
	$('#imageDiv').html('<p><img src="/images/ajax-loader.gif" width="425" height="21" class="sharejob_ajax_loader"/></p>');
	}
	return false;
}

function validateEmail(elementValue){
	var mail=elementValue.split(",");
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	for(var i=0;i<mail.length;i++)
	if(!emailPattern.test(mail[i])){
		alert("Invalid Email addresses!");
		return false;
	}
	return true;
}

function validateCheckedUser(){
	var flag = false;
	$(".friend_checkbox").each( function() {
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

function validateFormField(){
	if($('#ShareSubject').val()==""){
		alert('Subject cant be empty.');
		return false;
	}
	if($('#ShareMessage').val()==""){
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
	$('#e-mail').hide();
	var length = friends.length;
	html="";
	for(i=0;i<length;i++){
		html += '<li> <img src="' + friends[i].url +'"  title="'+ friends[i].name + '" ><input class="friend_checkbox" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend2(this);"></li>';
	}
	$(".job-share-ppl").html("<ul>"+html+"<ul/>");
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
	$('#submitLoaderImg').hide();
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
					//filterFriendList();
					$("#autocomplete").show();
					break;
				case 1: // we don't have user's facebook token
					alert(response.message);
					window.open(response.URL);
					break;
				case 2: // something went wrong when we connect with facebook.Need to login by facebook
					if(response.message){
					$( "#dialog-message" ).html(response.message);
					}
					else{
						$( "#dialog-message" ).html("Something went wrong. Please try later or contact to site admin");
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
	$('#submitLoaderImg').hide();
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
					break;
				case 1: // we don't have user's linked token
					alert(response.message);
					window.open(response.URL);
					break;
				case 2: // something went wrong when we connect with facebook.Need to login by facebook
					$( "#dialog-message" ).html(" something went wrong. Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
				default :
					$( "#dialog-message" ).html(" something went wrong. Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
			}
		},
		error: function(message){
			$('#submitLoaderImg').html('');
			$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
}
/**************************** 3). Fill Twitter Friends ******************************/
function fillTwitterFriend(){
	$('#submitLoaderImg').hide();
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
					break;
				case 1: // we don't have user's twitter token
					alert(response.message);
					window.open(response.URL);
					break;
				case 2: 
					$( "#dialog-message" ).html("something went wrong.Please contact to site admin");
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
			$('#submitLoaderImg').html('');
			$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
}
/************************* Email Sharing ***********************/
function emailInvitaion(){
	var to_email=$('#ShareToEmail').val();
	if(!validateEmail(to_email)){
		return false;
	}
	if(!validateFormField()){
		return false;
	}

	$('#submitLoaderImg').show();
	$.ajax({
		url: "/jobsharing/sendEmailInvitaion",
		type: "post",
		dataType: 'json',
		data: {
				toEmail : $('#ShareToEmail').val(),
				message : $('#ShareMessage').val(),
				invitationCode:$('#invitationCode').val()
			},

		success: function(response){
			$('#submitLoaderImg').hide();
			switch(response.error){
				case 0:
					$( "#dialog-message" ).html(" E-mail send successfully.");
					$( "#dialog-message" ).dialog("open");
					$('#ShareToEmail').val("");
					$('#submitLoaderImg').hide();
					setView('Email');
					break;
				case 1:
					$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message" ).html(response.message);
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
			$('#submitLoaderImg').html('');
			$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-message" ).dialog("open");
			$( "#dialog" ).dialog( "close" );
		}
	});
	return false;
}
function filterFriendList(){
	var textValue = $('#autocomplete').val();
	var user = jQuery.makeArray();
	$('.s_w_e input:checked').attr('checked', false);
	var foundFrd=false;
	$('#ff_list').css("display","none");
	if(textValue=='' || textValue=='Search Friends Here...'){
		$("#imageDiv").css("visibility","visible");
		$('#imageDiv .contactBox').css({"display":"block","visibility":"visible"});
		lastTextValue="";
		return false;
	}
	textValue = textValue.toLowerCase();
	$('#imageDiv .contactBox').css({"display":"none"});
	
	$(".contactImage img[title]").filter(function(){ if((this.title.toLowerCase()).indexOf(textValue)===0)
	return foundFrd=true;else return false; }).parents(".contactBox").css({"display":"block"});
	
	if(foundFrd === false)
		$("#ff_list").css("display","block").html("<div align='center'>No result found</div>");
	
	return false;
}

function facebookCommentInvitation(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateFormField()){
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
	$('#submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/facebook/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&message="+$("#ShareMessage").val()+
				"&invitationCode="+$('#invitationCode').val(),
				

		success: function(response){
			$('#submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					// show success message
					$( "#dialog-message" ).html("Your invitation has been sent successfully to facebook users.");
					$( "#dialog-message" ).dialog("open");
					fillFacebookFriend();
					break;
				case 1:
					$( "#dialog-message" ).html("Something went wrong. Please try later or contact to site admin.");
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
			$('#submitLoaderImg').html('');
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
	if(!validateFormField()){
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

	$('#submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/Linkedin/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&message="+$("#ShareMessage").val()+
				"&invitationCode="+$('#invitationCode').val(),
				
		success: function(response){
			$('#submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$( "#dialog-message" ).html("SYour invitation has been sent successfully to Linkedin users.");
					$( "#dialog-message" ).dialog("open");
					$('#submitLoaderImg').html('');
					fillLinkedinFriend();
					break;
				case 1:
					$( "#dialog-message" ).html(" something went wrong.Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message" ).html(response.message);
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
			$('#submitLoaderImg').html('');
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
	if(!validateFormField()){
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
	
	$('#submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/twitter/sendInvitation',
		dataType: 'json',
		data: 
				"&user="+JSON.stringify(user)+
				"&message="+$("#ShareMessage").val()+
				"&invitationCode="+$('#invitationCode').val(),
				
		success: function(response){
			$('#submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$( "#dialog-message" ).html("Your invitation has been sent successfully to Twitter follower.");
					$( "#dialog-message" ).dialog("open");
					$('#submitLoaderImg').html('');
					fillTwitterFriend();
					break;
				case 1:
					$( "#dialog-message" ).html(" something went wrong.Please try later or contact to site admin");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-message" ).html(response.message);
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
			$('#submitLoaderImg').html('');
			$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
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
});
</script>
