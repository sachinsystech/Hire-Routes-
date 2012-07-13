<?php
/**
* Share job element
*/
?>
<style>
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
$(function() {
$( "#dialog:ui-dialog" ).dialog( "destroy" );
$( "#dialog" ).dialog({
autoOpen: false,
show: "blind",
hide: "explode",
width:900,
closeOnEscape: false
});
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
$('.ui-widget-overlay').hide();
}
}
});
$('.ui-dialog-titlebar-close').click(closeUi);
});


function closeUi(){
$('.ui-widget-overlay').hide();
}

showView(4);

</script>


<div id="dialog-message"></div>
<div class="page">
<div id ="dialog" >
<!-- left section start -->
<div class="leftPanel">
<div class="sideMenu">
<ul class='api_menu top_mene_hover'>
<li id='liFacebook'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='showView(1);'>Facebook</a></li>
<li id='liLinkedIn'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='showView(2);'>LinkedIn</a></li>
<li id='liTwitter'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='showView(3);'>Twitter</a></li>
<li id='liEmail'class="active" ><a style="text-decoration: none;font-weight: normal;" href=# onclick='showView(4);'>Email</a></li>
</ul>
</div>
<div class='selectedFriends'>
	<div>Selected Friends</div>
</div>
</div>
<!-- left section end -->

<!-- middle section start -->
<div class="share_rightBox" >
	<!-- middle conyent list -->
	<div class="middleBox">
		<div id='message'></div>
		
		<div class="share_middle_setting">
		
		<?php echo $form->create('Share', array('action'=>'job', 'onsubmit'=>'return validateEmail(ShareToEmail.value);')); ?>
		<div id='to' style="padding-bottom:0px; clear:both"></div>
		
		<!-- 
		<div style="padding-bottom:0px; clear:both">
			<div style="float:left"><strong>Subjet:</strong></div>
			<div style="float:right">
				<?php /*echo $form->input('subject', array('label' => '',
				'type' => 'text',
				'class'=> 'subject_txt required',
				'value'=>'Job Recommendation :: '
				)); */ ?>
			</div>
		</div>
		-->
		<div style="padding-bottom:0px; clear:both" class='s_j_email'>
			<div style="float:left"><strong style="margin-top:10px">Message:</strong></div>
				<?php echo $form->input('message', array('label' => '',
				'type' => 'textarea',
				'class'=> 'msg_txtarear required',
				'value'=>"Learn more about this $invitationCode"
				));?>
			</div>
			<!-- Added for filter friends -->
			<div style="padding-bottom:0px; clear:both;float: left;">
				<div style="float:right">
					<?php echo $form->input('filter_friends', array('label' => '',
					'type' => 'text',
					'id'=>'autocomplete',
					'class'=> 'subject_txt searchfield',
					'value'=>'Search Friends Here...',
					'onfocus'=>"if(this.value=='Search Friends Here...') {this.value = '';}",
					'onblur'=>"if(this.value==''){this.value='Search Friends Here...';}"
					));?>
				</div>
			</div>
			<div id="ff_list" style="display:none"></div>
			<!-- End -->
			<div id='other' style="padding-bottom:0px;margin-top: 58px;"></div>
			<div style="padding-bottom:0px; clear:both;margin-top: 16px;">
			
				<div style='float:left;'>
				<?php echo $form->button('Clear', array('label' => '',
				'type' => 'reset',
				'value' => 'Clear'
				));?>
				</div>
				<div style='float:right;'>
					<div style='float:left;'>
						<?php echo $form->button('Invite Now', array('label' => '',
						'id' =>'share',
						'type' => 'submit',
						'value' => 'Invite Now',
						));?>
						<div id='submitLoaderImg' style='float:right;'></div>
					</div>
					<?php echo $form->input('invitationCode', array('label' => '',
					'id'=>'invitationCode',
					'type' => 'hidden',
					'value'=>isset($invitationCode)?$invitationCode:"",
					));?>
				</div>
				<?php echo $form->end(); ?>
			</div>
		</div>
	</div>
	<!-- middle conyent list -->

</div>
<!-- middle section end -->
</div>
</div>
<div id="opener"></div>

<script>
function showView(type){
	$("#share").unbind();
	$("#autocomplete").unbind();
	$("#autocomplete").hide();
	$("#opener").click();
	$('.ui-dialog-titlebar-close').click(closeUi);
	$('.ui-widget-overlay').remove();
	$('#container').after("<div class='ui-widget-overlay' style='width: 1350px; height: 779px; z-index: 1001;'></div>");
	$('.selectedFriends .selectedFriend').remove();
	switch(type){
		case 1:
			setView('Facebook');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillFacebookFriend();
			$("#share").click(facebookComment);
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
			$("#share").click(linkedInComment);
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
			$("#share").click(TwitterComment);
			$('#autocomplete').val('Search Friends Here...');
			$('#ff_list').hide();
			$('#ff_list').html('');
			$("#autocomplete").keyup(filterFriendList);
			break;
		case 4:
			$('#ff_list').hide();
			$('.selectedFriends').hide();
			$('#imageDiv').hide();
			setView('Email');
			$("#share").click(shareEmail);
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
	$(".facebookfriend").each( function() {
		if($(this).attr("checked")){
		flag = true;
	}
	})
	if(!flag){
		alert("You did not select any friend.");
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

function createHTMLforFillingFriends(friends){

	$('.selectedFriends .selectedFriend').remove();
	var length = friends.length;
	
	html="";
	for(i=0;i<length;i++){
		html += '<div class="contactBox"><div style="position:relative"><div class="contactImage"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend(this);"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
	}
	$("#other").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right' class='s_w_e'>Invite All<input style='float:right'type='checkbox' onclick='return checkAll(this); ' /></div><div id='imageDiv'>"+html+"</div>");
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
}

/**************************** 1).Fill facebook Friends ******************************/

function fillFacebookFriend(){
//get list of facebook friend from ajax request
$('#imageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/fbloader.gif" width="50px" />'+
'<img src="/images/fb_loading.gif" /></p>');
$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
$.ajax({
type: 'POST',
url: '/facebook/getFaceBookFriendList',
dataType: 'json',
success: function(response){
switch(response.error){
case 0: // success
createHTMLforFillingFriends(response.data);
filterFriendList();
$("#autocomplete").show();
//$("#imageDiv").css({visibility: "hidden"});

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
$('#imageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/liloader.gif" width="50px" />'+
'<img src="/images/li_loading.gif" /></p>');
$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
$.ajax({
type: 'POST',
url: '/linkedin/getLinkedinFriendList',
dataType: 'json',
success: function(response){
switch(response.error){
case 0: // success
createHTMLforFillingFriends(response.data);
filterFriendList();
$("#autocomplete").show();
$("#imageDiv").css({visibility: "hidden"});
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
$('#imageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/twitterLoader.gif" width="50px" />'+
'<img src="/images/li_loading.gif" /></p>');
$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
$.ajax({
type: 'POST',
url: '/twitter/getTwitterFriendList',
dataType: 'json',
success: function(response){
switch(response.error){
case 0: // success
createHTMLforFillingFriends(response.data);
filterFriendList();
$("#autocomplete").show();
//$("#imageDiv").css({visibility: "hidden"});
break;
case 1: // we don't have user's twitter token
alert(response.message);
window.open(response.URL);
break;
case 2: // something went wrong when we connect with facebook.Need to login by facebook
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
function shareEmail(){
	var to_email=$('#ShareToEmail').val();
	if(!validateEmail(to_email)){
		return false;
	}
	if(!validateFormField()){
		return false;
	}

	$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
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
			$('#submitLoaderImg').html('');
			switch(response.error){
				case 0:
					$( "#dialog-message" ).html(" E-mail send successfully.");
					$( "#dialog-message" ).dialog("open");
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

function facebookComment(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $("input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
	$.ajax({
		type: 'POST',
		url: '/facebook/commentAtFacebook',
		dataType: 'json',
		data: "usersNames="+usersNames+
				"&usersId="+usersId+
				"&message="+$("#ShareMessage").val()+
				"&jobId="+$("#ShareJobId").val()+
				"&code="+$('#code').val(),
		success: function(response){
			$('#submitLoaderImg').html('');
			switch(response.error){
				case 0: // success
					// show success message
					$( "#dialog-message" ).html("Successfully sent a message to facebook users.");
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

function linkedInComment(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $("input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
	$.ajax({
		type: 'POST',
		url: '/Linkedin/sendMessagetoLinkedinUser',
		dataType: 'json',
		data: "usersNames="+usersNames+
				"&usersId="+usersId+
				"&message="+$("#ShareMessage").val()+
				"&jobId="+$("#ShareJobId").val()+
				"&code="+$('#code').val(),
				
		success: function(response){
			$('#submitLoaderImg').html('');
			switch(response.error){
				case 0: // success
					$( "#dialog-message" ).html("Successfully sent a message to Linkedin users.");
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

function TwitterComment(){
if(!validateCheckedUser()){
return false;
}
if(!validateFormField()){
return false;
}
	usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $("input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
$.ajax({
type: 'POST',
url: '/twitter/sendMessageToTwitterFollwer',
dataType: 'json',
data: "usersId="+usersId+"&message="+$("#ShareMessage").val()+"&jobId="+$("#ShareJobId").val(),
success: function(response){
$('#submitLoaderImg').html('');
switch(response.error){
case 0: // success
$( "#dialog-message" ).html("Successfully sent a message to Twitter follower.");
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
$("#ShareJobForm").validate();
</script>
