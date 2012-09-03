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
</style>
<style>
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
#ui-dialog{
	top:20px;
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
		$("#shareJobDialog" ).dialog( "close" );
		return false;
	});
});

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#shareJobDialog" ).dialog({
		autoOpen: false,
		show: "blind",
		hide: "explode",
		width:900,
		closeOnEscape: false,
		modal:true
	});
	
	$( "#shareJobDialog" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","height":"600px","top":"0","background":"none","border":"none"});
	
	$( "#jobShareOpener" ).click(function() {
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
			}
		}
	});
	
	$( "#clear-all").click(function() {
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
</script>


<?php if(isset($jobUrl)):?>
<div><input type="hidden" id="jobUrl" value="<?php echo $jobUrl ?>"></div>
<div id="dialog-messageshare"></div>
<div id ="shareJobDialog" title="<?php echo ucfirst($jobTitle); ?>" >
	
	
	<!-- :: :: :: :: :: :: :: :: :: :: :: :: :: -->
	<div class="job-share-content">
        	<div class="about_popup_cancel_bttn_row1">
               	<div class="about_popup_cancel_bttn"><a href="#"></a></div>
       		</div>
            
            <div class="job-share-left">
            	<ul>
                	<li><a class="job-share-fb" onclick='shareJobShowView(1);'></a></li>
                    <li><a class="job-share-in" onclick='shareJobShowView(2);'></a></li>
                    <li><a class="job-share-twit" onclick='shareJobShowView(3);'></a></li>
                    <li><a class="job-share-mail" onclick='shareJobShowView(4);'></a></li>
                </ul>
            </div>
            
            <div class="job-share-right">
            	<h2>SHARE A JOB...</h2>
				<?php echo $form->create('Share', array('action'=>'job', 'onsubmit'=>'return validateForm(ShareToEmail.value);')); ?>
                <?php echo $form->input('jobId', array('label' => '',
												'type' => 'hidden',
												'value'=>$jobId
					));
				?>
				<?php echo $form->input('code', array('label' => '',
					'id'=>'code',
					'type' => 'hidden',
					'value'=>isset($intermediateCode)?$intermediateCode:"",
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
							'value'=>"I'd like to bring a job opportunity to your attention. - (".$jobUrl.")"
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
					   
                        <div class="js_clear_all"><a href="#"><input id="clear-all" type="button" value="Clear All">Clear All</a></div>
				</div>
				
				<div id="submitLoaderImg" class="submitloader"></div>
				
                <div class="login-button pop-up-button">
						<input type="submit" value="SHARE JOB" id='shareJob' >
						<div class="clr"></div>
				</div>
            </div>
        </div>
    </div>
	
	<!-- :: :: :: :: :: :: :: :: :: :: :: :: :: -->
	
	
</div>

<div id="jobShareOpener"></div>
<?php endif;?>
<script>
function shareJobShowView(type){
	$("#ShareToEmail").val("");
	$("#ShareSubject").val("");
	$('#e-mail').hide();
	$('.js_invite').css("visibility", "visible");
	$('.job-share-ppl').show();
	$("#shareJob").unbind();
	$("#autocompleteFind").unbind();
	$("#autocompleteFind").hide();
	$("#jobShareOpener").click();
	switch(type){		
		case 1:
				setShareJobView('Facebook');
				$('.selectedFriends').show();
				fillFacebookFriendShareJob();
				$('.job-share-ppl').show();
				$("#shareJob").click(facebookComment);
				break;
		case 2:
				setShareJobView('LinkedIn');
				$('.selectedFriends').show();
				fillLinkedinFriendShareJob();
				$('.job-share-ppl').show();
				$("#shareJob").click(linkedInComment);
				break;
		case 3:
				setShareJobView('Twitter');
				$('.selectedFriends').show();
				fillTwitterFriendShareJob();
				$('.job-share-ppl').show();
				$("#shareJob").click(TwitterComment);
				break;
		case 4:
				$('#e-mail').show();
				$('.js_invite').css("visibility", "hidden");
				$('.job-share-ppl').hide();
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
		
		//$('#other_share_job').html("<div style='padding-bottom:20px; padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right;margin-top:12px;' class='s_w_e'>Share with everyone<input style='float:right' type='checkbox'/></div><div id='filtered_friend'></div><div id='shareJobImageDiv'>");
		
	}
	return false;
}

function validateForm(elementValue){
	var mail=elementValue.split(",");
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	for(var i=0;i<mail.length;i++)
	if(!emailPattern.test(mail[i])){
		alert("Invalid Email addresses!");
		return false;
	}
	
	return validateFormField();
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
function validateEmail(elementValue){
	var mail=elementValue.split(",");
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	for(var i=0;i<mail.length;i++)
	if(!emailPattern.test(mail[i])){
		alert("Invalid Email addresses.");
		return false;
	}
	return true;
}
function createHTMLforFillingShareFriends(friends){

	//$('.selectedFriends .selectedFriend').remove();
	var length = friends.length;
	
	html="";
	for(i=0;i<length;i++){
		//html += '<div class="contactBox"><div style="position:relative"><div class="contactImageShare"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend(this);"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
		html += '<li> <img src="' + friends[i].url +'"  title="'+ friends[i].name + '" ><input class="friend_checkbox" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend2(this);"></li>';
	}
	//$("#other_share_job").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right' class='s_w_e'>Share with everyone<input style='float:right'type='checkbox' onclick='return checkAll(this); ' /></div><div id='shareJobImageDiv'>"+html+"</div>");
	
	$(".job-share-ppl").html("<ul>"+html+"<ul/>");
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

	$('#submitLoaderImg').hide();
	//get list of facebook friend from ajax request
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/fbloader.gif" width="50px" />'+
	'<img src="/images/fb_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/facebook/getFaceBookFriendList',
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingShareFriends(response.data);
					//filterFriendListShareJob();
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
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/liloader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	//$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');

	$.ajax({
		type: 'POST',
		url: '/linkedin/getLinkedinFriendList',
		data: "&source=share_job",
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingShareFriends(response.data);
					//filterFriendListShareJob();
					$("#autocompleteFind").show();
					$("#shareJobImageDiv").css({visibility: "hidden"});
					break;
				case 1: // we don't have user's linked token
					alert(response.message);
					window.open(response.URL);
					break;
				case 2: // something went wrong when we connect with facebook.Need to login by facebook
					$( "#dialog-messageshare" ).html(" Something went wrong. Please try later or contact to site admin");
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
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;" ><img src="/images/twitterLoader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
	$.ajax({
		type: 'POST',
		url: '/twitter/getTwitterFriendList',
		data: "&source=share_job",
		dataType: 'json',
		success: function(response){
		switch(response.error){
			case 0: // success
				createHTMLforFillingShareFriends(response.data);
				//filterFriendListShareJob();
				//$("#autocompleteFind").show();
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

	$('#submitLoaderImg').show();
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
					$('#ShareToEmail').val("");
					$('#submitLoaderImg').hide();
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
			$('#submitLoaderImg').hide();
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
	usersId = $("input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#submitLoaderImg').show();
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
	usersId = $("input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#submitLoaderImg').show();
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
	usersId = $("input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
							return this.title;
						}
					}).get().join(",");
	
	$('#submitLoaderImg').show();
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
