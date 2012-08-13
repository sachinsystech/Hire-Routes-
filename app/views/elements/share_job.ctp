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
$( "#shareJobDialog" ).dialog({
autoOpen: false,
show: "blind",
hide: "explode",
width:900,
closeOnEscape: false
});
$( "#jobShareOpener" ).click(function() {
$( "#shareJobDialog" ).css( "top" ,'-50');
$( "#shareJobDialog" ).dialog( "open" );
return false;
});

$( "#dialog-messageshare" ).dialog({
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



</script>
<?php if(isset($jobUrl)):?>
<div><input type="hidden" id="jobUrl" value="<?php echo $jobUrl ?>"></div>
<div id="dialog-messageshare"></div>
<div class="page">
<div id ="shareJobDialog" title="<?php echo ucfirst($jobTitle); ?>" >
<!-- left section start -->
<div class="leftPanel">
<div class="sideMenu">
<ul class='api_menu top_mene_hover'>
<li id='liFacebookShare'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='shareJobShowView(1);'>Facebook</a></li>
<li id='liLinkedInShare'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='shareJobShowView(2);'>LinkedIn</a></li>
<li id='liTwitterShare'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='shareJobShowView(3);'>Twitter</a></li>
<li id='liEmailShare'class="active" ><a style="text-decoration: none;font-weight: normal;" href=# onclick='shareJobShowView(4);'>Email</a></li>
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
<div id='toEmail' style="padding-bottom:0px; clear:both"></div>
<?php echo $form->input('jobId', array('label' => '',
'type' => 'hidden',
'value'=>$jobId
));?>
<div style="padding-bottom:0px; clear:both">
<div style="float:left"><strong>Subjet:</strong></div>
<div style="float:right">
<?php echo $form->input('subject', array('label' => '',
'type' => 'text',
'class'=> 'subject_txt required',
'value'=>'Job Recommendation :: '
));?>
</div>
</div>
<div style="padding-bottom:0px; clear:both" class='s_j_email'>
<div style="float:left"><strong style="margin-top:10px">Message:</strong></div>
<?php echo $form->input('message', array('label' => '',
'type' => 'textarea',
'class'=> 'msg_txtarear required',
'value'=>"Learn more about this job (".$jobUrl.")"
));?>
</div>
<!-- Added for filter friends -->
<div style="padding-bottom:0px; clear:both;float: left;">
<div style="float:right">
<?php echo $form->input('filter_friends', array('label' => '',
'type' => 'text',
'id'=>'autocompleteFind',
'class'=> 'subject_txt searchfield',
'value'=>'Search Friends Here...',
'onfocus'=>"if(this.value=='Search Friends Here...') {this.value = '';}",
'onblur'=>"if(this.value==''){this.value='Search Friends Here...';}"
));?>
</div>
</div>
<div id="ff_list_share_job" style="display:none"></div>
<!-- End -->
<div id='other_share_job' style="padding-bottom:0px;margin-top: 58px;">
</div>
<div style="padding-bottom:0px; clear:both;margin-top: 16px;">

<div style='float:left;'>
<?php echo $form->button('Clear', array('label' => '',
'type' => 'reset',
'value' => 'Clear'
));?>
</div>
<div style='float:right;'>
<div style='float:left;'>
<?php echo $form->button('Share', array('label' => '',
'id' =>'shareJob',
'type' => 'submit',
'value' => 'Share',
));?>
<div id='submitLoaderImg' style='float:right;'></div>
</div>
<?php echo $form->input('code', array('label' => '',
'id'=>'code',
'type' => 'hidden',
'value'=>isset($intermediateCode)?$intermediateCode:"",
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
<div id="jobShareOpener"></div>
<?php endif;?>
<script>
function shareJobShowView(type){
	$("#shareJob").unbind();
	$("#autocompleteFind").unbind();
	$("#autocompleteFind").hide();
	$("#jobShareOpener").click();
	$('.ui-dialog-titlebar-close').click(closeUi);
	$('.ui-widget-overlay').remove();
	$('#container').after("<div class='ui-widget-overlay' style='width: 1350px; height: 779px; z-index: 1001;'></div>");
	$('.selectedFriends .selectedFriend').remove();
	switch(type){
		case 1:
			setShareJobView('Facebook');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillFacebookFriendShareJob();
			$("#shareJob").click(facebookComment);
			$('#autocompleteFind').val('Search Friends Here...');
			$('#ff_list_share_job').hide();
			$('#ff_list_share_job').html('');
			$("#autocompleteFind").keyup(filterFriendListShareJob);
			break;
		case 2:
			setShareJobView('LinkedIn');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillLinkedinFriendShareJob();
			$("#shareJob").click(linkedInComment);
			$('#autocompleteFind').val('Search Friends Here...');
			$('#ff_list_share_job').hide();
			$('#ff_list_share_job').html('');
			$("#autocompleteFind").keyup(filterFriendListShareJob);
			break;
		case 3:
			setShareJobView('Twitter');
			$('.s_w_e').hide();
			$('.selectedFriends').show();
			fillTwitterFriendShareJob();
			$("#shareJob").click(TwitterComment);
			$('#autocompleteFind').val('Search Friends Here...');
			$('#ff_list_share_job').hide();
			$('#ff_list_share_job').html('');
			$("#autocompleteFind").keyup(filterFriendListShareJob);
			break;
		case 4:
			$('#ff_list_share_job').hide();
			$('.selectedFriends').hide();
			$('#shareJobImageDiv').hide();
			setShareJobView('Email');
			$("#shareJob").click(shareEmail);
			break;
	}
}

function setShareJobView(value)
{
$('#message').hide();
$('.api_menu li').removeClass('active');
$('#li'+value+'Share').addClass('active');

if(value=='Email')
{
$('#other_share_job').html("");
$('#toEmail').html("<div style='padding-bottom:10px;' class='s_j_email'><strong>Email:</strong><textarea id='ShareToEmail' name='toEmail' class='email_msg_txtarear' rows='1'></textarea></div>");
}
else
{
$('#toEmail').html("");

$('#other_share_job').html("<div style='padding-bottom:20px; padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right;margin-top:12px;' class='s_w_e'>Share with everyone<input style='float:right' type='checkbox'/></div><div id='filtered_friend'></div><div id='shareJobImageDiv'>");

$('#shareJobImageDiv').html('<p><img src="/images/ajax-loader.gif" width="425" height="21" class="sharejob_ajax_loader"/></p>');
}
return false;
}

function validateEmail(elementValue){
var mail=elementValue.split(",");
var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
for(var i=0;i<mail.length;i++)
if(!emailPattern.test(mail[i]))
{
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

function createHTMLforFillingShareFriends(friends){

	$('.selectedFriends .selectedFriend').remove();
	var length = friends.length;
	
	html="";
	for(i=0;i<length;i++){
		html += '<div class="contactBox"><div style="position:relative"><div class="contactImageShare"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend(this);"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
	}
	$("#other_share_job").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right' class='s_w_e'>Share with everyone<input style='float:right'type='checkbox' onclick='return checkAll(this); ' /></div><div id='shareJobImageDiv'>"+html+"</div>");
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
$("#shareJobImageDiv .contactBox").filter(function(){ var opac=parseFloat($(this).css('opacity')); opac=opac.toFixed(1); return (opac==0.3)?true:false;}).each(function(){
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
$(".selectedFriends").append($('#shareJobImageDiv').html());
$("#shareJobImageDiv .contactBox:visible").css('opacity',0.3).find('input:checkbox:first').attr("checked",true).attr("disabled",true);
$(".selectedFriends .contactBox").removeClass('contactBox').addClass('selectedFriend').find('img:first').attr("width",30).attr("height",30).parent().removeClass('contactImageShare').addClass('selectedFriendImage').parent().css('float','left').find('input:checkbox:first').attr("checked",true).css("margin",'0').attr("onClick","return deSelectFriend(this)").parent().removeClass('contactCheckBox').addClass('selectedFriendCheckBox');
$(".selectedFriends .contactName").removeClass('contactName').addClass('selectedFriendName');
}else{
$(".selectedFriend").remove();
$("#shareJobImageDiv .contactBox ").filter(function(){ var opac=parseFloat($(this).css('opacity')); opac=opac.toFixed(1); return (opac==0.3)?true:false;}).css('opacity',1.0).find('input:checkbox:first').attr("checked",false).attr("disabled",false);
}
}


</script>

<script>

/************************** close**********************************/
function close(){
$( "#shareJobDialog" ).dialog( "close" );
}

/**************************** 1).Fill facebook Friends ******************************/

function fillFacebookFriendShareJob(){
//get list of facebook friend from ajax request
$('#shareJobImageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/fbloader.gif" width="50px" />'+
'<img src="/images/fb_loading.gif" /></p>');
$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
$.ajax({
	type: 'POST',
	url: '/facebook/getFaceBookFriendList',
	dataType: 'json',
	success: function(response){
		switch(response.error){
			case 0: // success
				createHTMLforFillingShareFriends(response.data);
				filterFriendListShareJob();
				$("#autocompleteFind").show();
				//$("#shareJobImageDiv").css({visibility: "hidden"});
				break;
			case 1: // we don't have user's facebook token
				alert(response.message);
				window.open(response.URL);
				break;
			case 2: // something went wrong when we connect with facebook.Need to login by facebook
				if(response.message){
					$( "#dialog-messageshare" ).html(response.message);
				}
				else{
					$( "#dialog-messageshare" ).html("Something went wrong. Please try later or contact to site admin");
				}
				$( "#dialog-messageshare" ).dialog("open");
				$( "#shareJobDialog" ).dialog( "close" );
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
function fillLinkedinFriendShareJob(){
$('#shareJobImageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/liloader.gif" width="50px" />'+
'<img src="/images/li_loading.gif" /></p>');
$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
$.ajax({
type: 'POST',
url: '/linkedin/getLinkedinFriendList',
dataType: 'json',
success: function(response){
switch(response.error){
case 0: // success
createHTMLforFillingShareFriends(response.data);
filterFriendListShareJob();
$("#autocompleteFind").show();
$("#shareJobImageDiv").css({visibility: "hidden"});
break;
case 1: // we don't have user's linked token
alert(response.message);
window.open(response.URL);
break;
case 2: // something went wrong when we connect with facebook.Need to login by facebook
$( "#dialog-messageshare" ).html(" something went wrong. Please try later or contact to site admin");
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
break;
case 3:
alert(response.message);
location.reload();
break;
default :
$( "#dialog-messageshare" ).html(" something went wrong. Please try later or contact to site admin");
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
break;
}
},
error: function(message){
$('#submitLoaderImg').html('');
$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
}
});
}
/**************************** 3). Fill Twitter Friends ******************************/
function fillTwitterFriendShareJob(){
	$('#shareJobImageDiv').html('<p class="sharejob_ajax_loader"><img src="/images/twitterLoader.gif" width="50px" />'+'<img src="/images/li_loading.gif" /></p>');
	$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
	$.ajax({
		type: 'POST',
		url: '/twitter/getTwitterFriendList',
		dataType: 'json',
		success: function(response){
		switch(response.error){
			case 0: // success
				createHTMLforFillingShareFriends(response.data);
				filterFriendListShareJob();
				$("#autocompleteFind").show();
				//$("#shareJobImageDiv").css({visibility: "hidden"});
				break;
			case 1: // we don't have user's twitter token
				alert(response.message);
				window.open(response.URL);
				break;
			case 2: // something went wrong when we connect with facebook.Need to login by facebook
				$( "#dialog-messageshare" ).html("something went wrong.Please contact to site admin");
				$( "#dialog-messageshare" ).dialog("open");
				$( "#shareJobDialog" ).dialog( "close" );
				break;
			case 3:
				alert(response.message);
				location.reload();
				break;
		}
	},
	error: function(message){
	$('#submitLoaderImg').html('');
	$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
	$( "#dialog-messageshare" ).dialog("open");
	$( "#shareJobDialog" ).dialog( "close" );
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
		url: "/jobsharing/shareJobByEmail",
		type: "post",
		dataType: 'json',
		data: {
				jobId : $('#ShareJobId').val(),
				jobUrl: $('#jobUrl').val(),
				toEmail : $('#ShareToEmail').val(),
				subject : $('#ShareSubject').val(),
				message : $('#ShareMessage').val(),
				code:$('#code').val()
			},
		success: function(response){
			$('#submitLoaderImg').html('');
			switch(response.error){
				case 0:
					$( "#dialog-messageshare" ).html(" E-mail send successfully.");
					$( "#dialog-messageshare" ).dialog("open");
					setShareJobView('Email');
					break;
				case 1:
					$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
					$( "#dialog-messageshare" ).dialog("open");
					$( "#shareJobDialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-messageshare" ).html(response.message);
					$( "#dialog-messageshare" ).dialog("open");
					$( "#shareJobDialog" ).dialog( "close" );
					break;
				case 3:
					alert(response.message);
					location.reload();
					break;
			}
		},
		error:function(response){
			$('#submitLoaderImg').html('');
			$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-messageshare" ).dialog("open");
			$( "#shareJobDialog" ).dialog( "close" );
		}
	});
	return false;
}
function filterFriendListShareJob(){
	var textValue = $('#autocompleteFind').val();
	var user = jQuery.makeArray();
	$('.s_w_e input:checked').attr('checked', false);
	var foundFrd=false;
	$('#ff_list_share_job').css("display","none");
	if(textValue=='' || textValue=='Search Friends Here...'){
		$("#shareJobImageDiv").css("visibility","visible");
		$('#shareJobImageDiv .contactBox').css({"display":"block","visibility":"visible"});
		lastTextValue="";
		return false;
	}
	textValue = textValue.toLowerCase();
	$('#shareJobImageDiv .contactBox').css({"display":"none"});

	$(".contactImageShare img[title]").filter(function(){ if((this.title.toLowerCase()).indexOf(textValue)===0)
	return foundFrd=true;else return false; }).parents(".contactBox").css({"display":"block"});
	if(foundFrd === false)
		$("#ff_list_share_job").css("display","block").html("<div align='center'>No result found</div>");

	return false;
}

function facebookComment(){
	if(!validateCheckedUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId=$(".contactBox input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
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
					$( "#dialog-messageshare" ).html("Successfully sent a message to facebook users.");
					$( "#dialog-messageshare" ).dialog("open");
					fillFacebookFriendShareJob();
					break;
				case 1:
					$( "#dialog-messageshare" ).html("Something went wrong. Please try later or contact to site admin.");
					$( "#dialog-messageshare" ).dialog("open");
					$( "#shareJobDialog" ).dialog( "close" );
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
	usersId=$(".contactBox input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
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
					$( "#dialog-messageshare" ).html("Successfully sent a message to Linkedin users.");
					$( "#dialog-messageshare" ).dialog("open");
					$('#submitLoaderImg').html('');
					fillLinkedinFriendShareJob();
					break;
				case 1:
					$( "#dialog-messageshare" ).html(" something went wrong.Please try later or contact to site admin");
					$( "#dialog-messageshare" ).dialog("open");
					$( "#shareJobDialog" ).dialog( "close" );
					break;
				case 2:
					$( "#dialog-messageshare" ).html(response.message);
					$( "#dialog-messageshare" ).dialog("open");
					$( "#shareJobDialog" ).dialog( "close" );
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
	usersId=$(".contactBox input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
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
$( "#dialog-messageshare" ).html("Successfully sent a message to Twitter follower.");
$( "#dialog-messageshare" ).dialog("open");
$('#submitLoaderImg').html('');
fillTwitterFriendShareJob();
break;
case 1:
$( "#dialog-messageshare" ).html(" something went wrong.Please try later or contact to site admin");
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
break;
case 2:
$( "#dialog-messageshare" ).html(response.message);
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
break;
case 3:
alert(response.message);
location.reload();
break;
}
},
error: function(message){
$('#submitLoaderImg').html('');
$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
$( "#dialog-messageshare" ).dialog("open");
$( "#shareJobDialog" ).dialog( "close" );
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
