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
	position: absolute;
	*right: 5px;
	right: 0px;
	*top:0px;
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
#shareJobDialog{
	font-family: Arial regular,Sans-serif !important;
	/* *height:600px;
	*position:absolute;*/
}
.ui-autocomplete {
    font-size: 12px;
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
		resizable : false,
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
	
	$( "#shareJobDialog #clear-all").click(function() {
		$("#shareJobDialog #ShareToEmail").val("");
		$("#shareJobDialog #ShareSubject").val("");
		$('#shareJobDialog #ShareMessage').val("");
		$("#autocompleteEmail").val("");
		return false;
	});
	
});

function toggleShareChecked(status) {
	/*$("#shareJobDialog .friend_checkbox").each( function() {
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
		$("#shareJobDialog .friend_checkbox").parent("li:visible").css('opacity', 0.3).children(".friend_checkbox").attr("checked",status);
	}else{
		$("#shareJobDialog .friend_checkbox").parent("li:visible").css('opacity', 1.0).children(".friend_checkbox").attr("checked",status);
	}
	
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
			       	<?php if($this->Session->read("UserRole") == NETWORKER ){ ?>                	
                    <div style="display:none;">
                    	<input id="ShareToEmail" type="text" placeholder="Enter a friend's email address" />
                   	</div>
			       	<div class="job-share-tb">
                    	<input id="autocompleteEmail" type="text" placeholder="Enter a friend's email address" />
                   	</div>
			       	<?php }else{ ?>
                    <div class="job-share-tb">
                    	<input id="ShareToEmail" type="text" placeholder="Enter a friend's email address" />
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
							'value'=>"I'd like to bring a job opportunity to your attention. "
						));?>
					</div>
                    <div class="clr"></div>
                </div>
				<div style="float:left" >
					<?php echo $form->input('filter_friends', array('label' => '',
								'type' => 'text',
								'id'=>'autocompleteFind',
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
							<div class="js_invite_all">Share All</div>
							<div class="js-check-box-popup">
								<!-- span class="checkbox_selected" onclick="make_bg_change(this);"></span -->
								<input type="checkbox" class="styled" id="gender_checkbox" onclick="toggleShareChecked(this.checked)">                                         
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
				$("#autocompleteFind").keyup(filterFriendListShareJob);
				break;
		case 2:
				setShareJobView('LinkedIn');
				$('.selectedFriends').show();
				fillLinkedinFriendShareJob();
				$('.job-share-ppl').show();
				$("#shareJob").click(linkedInComment);
				$("#autocompleteFind").keyup(filterFriendListShareJob);
				break;
		case 3:
				setShareJobView('Twitter');
				$('.selectedFriends').show();
				fillTwitterFriendShareJob();
				$('.job-share-ppl').show();
				$("#shareJob").click(TwitterComment);
				$("#autocompleteFind").keyup(filterFriendListShareJob);
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
	elementValue = $.trim(elementValue);
	if( elementValue.charAt(elementValue.length-1) == ","){
		elementValue = elementValue.substr(0,elementValue.length - 1);
	}
	var mail=elementValue.split(",");
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	for(var i=0;i<mail.length;i++)
	if(!emailPattern.test(mail[i])){
		alert("Invalid Email addresses!");
		return false;
	}
	
	return validateFormField();
}

function validateCheckedSJUser(){
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
	if($('#shareJobDialog #ShareSubject').val()==""){
		alert('Subject cant be empty.');
		return false;
	}
	if($('#shareJobDialog #ShareMessage').val()==""){
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
		//alert("Invalid Email addresses.");
		alert("Either email is invalid or its not separated by comma.");
		return false;
	}
	return true;
}
function createHTMLforFillingShareFriends(friends){

	var length = friends.length;
	
	html="";
	for(i=0;i<length;i++){
		//html += '<div class="contactBox"><div style="position:relative"><div class="contactImageShare"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend(this);"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
		html += '<li style="*width:50px;*height:50px;"> <img src="' + friends[i].url +'"  title="'+ friends[i].name + '" ><input class="friend_checkbox" value="'+friends[i].id+'" type="checkbox" title="'+friends[i].name+'" onclick="return selectFriend2(this);" style="*top:-3px;"></li>';
	}
	//$("#other_share_job").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong> </strong></div><div style='float:right' class='s_w_e'>Share with everyone<input style='float:right'type='checkbox' onclick='return checkAll(this); ' /></div><div id='shareJobImageDiv'>"+html+"</div>");
	
	$(".job-share-ppl").html("<ul>"+html+"<ul/><div class='no_friend_found'> No friends available at this time, Please try again later.</div>");
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

	$('#shareJobDialog #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$("#autocompleteFind").val("").blur();
	//get list of facebook friend from ajax request
	$('#shareJobDialog .job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/fbloader.gif" width="50px" />'+
	'<img src="/images/fb_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/facebook/getFaceBookFriendList',
		dataType: 'json',
		data: "&source=share_job",
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingShareFriends(response.data);
					$("#autocompleteFind").show();
					filterFriendListShareJob();
					if(jQuery.isEmptyObject(response.data)){
						$(".no_friend_found").css("display","block");
						$(".no_friend_found").text("No friends available at this time, Please try again later.")
					}
					break;
				case 1: // we don't have user's facebook token
					//alert(response.message);
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
	$('#shareJobDialog #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$("#autocompleteFind").val("").blur();
	$('#shareJobDialog .job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;"><img src="/images/liloader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	$.ajax({
		type: 'POST',
		url: '/linkedin/getLinkedinFriendList',
		data: "&source=share_job",
		dataType: 'json',
		success: function(response){
			switch(response.error){
				case 0: // success
					createHTMLforFillingShareFriends(response.data);
					$("#autocompleteFind").show();
					filterFriendListShareJob();
					$("#shareJobImageDiv").css({visibility: "hidden"});
					if(jQuery.isEmptyObject(response.data)){
						$(".no_friend_found").css("display","block");
						$(".no_friend_found").text("No friends available at this time, Please try again later.")
					}
					break;
				case 1: // we don't have user's linked token
					//alert(response.message);
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
			$('#shareJobDialog #submitLoaderImg').html('');
			$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
			$( "#dialog-messageshare" ).dialog("open");
			$( "#shareJobDialog" ).dialog( "close" );
		}
	});
}
/**************************** 3). Fill Twitter Friends ******************************/
function fillTwitterFriendShareJob(){
	$('#shareJobDialog #submitLoaderImg').hide();
	$("#gender_checkbox").attr("checked",false);
	$("#autocompleteFind").val("").blur();	
	$('.job-share-ppl').html('<p class="sharejob_ajax_loader" style="margin: 52px auto auto; width: 80px;" ><img src="/images/twitterLoader.gif" width="50px" />'+
	'<img src="/images/li_loading.gif" /></p>');
	$('#shareJobDialog .sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
	$.ajax({
		type: 'POST',
		url: '/twitter/getTwitterFriendList',
		data: "&source=share_job",
		dataType: 'json',
		success: function(response){
		switch(response.error){
			case 0: // success
				createHTMLforFillingShareFriends(response.data);
				$("#autocompleteFind").show();
				filterFriendListShareJob();
				if(jQuery.isEmptyObject(response.data)){
					$(".no_friend_found").css("display","block");
					$(".no_friend_found").text("No friends available at this time, Please try again later.")
				}
				break;
			case 1: // we don't have user's twitter token
				//alert(response.message);
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
	$('#shareJobDialog #submitLoaderImg').html('');
	$( "#dialog-messageshare" ).html("Something went wrong please try later or contact to site admin.");
	$( "#dialog-messageshare" ).dialog("open");
	$( "#shareJobDialog" ).dialog( "close" );
	}
	});
}
/************************* Email Sharing ***********************/
function shareEmail(){
	var to_email=$('#shareJobDialog #ShareToEmail').val();
	if(!validateEmail(to_email)){
		return false;
	}
	if(!validateFormField()){
		return false;
	}

	$('#shareJobDialog #submitLoaderImg').show();
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
			$('#shareJobDialog #submitLoaderImg').hide();
			switch(response.error){
				case 0:
					$("#ShareSubject").val("");				
					$( "#dialog-messageshare" ).html(" E-mail sent successfully.");
					$( "#dialog-messageshare" ).dialog("open");
					$('#shareJobDialog #ShareToEmail').val("");
					$("#autocompleteEmail").val("");
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
	$('#shareJobDialog .job-share-ppl li').css({"display":"none"});

	$("#shareJobDialog .job-share-ppl ul img[title]").filter(function(){ 
		if((this.title.toLowerCase()).indexOf(textValue)===0){
			$(".no_friend_found").css("display","none");
			return foundFrd=true;
		}
		else return false; 
	}).parent("li").css({"display":"block"});
	
	if(foundFrd === false)
		$("#shareJobDialog .no_friend_found").css("display","block");
		$("#shareJobDialog .no_friend_found").text(" Sorry, you don't have a friend whose name started with this letter or word.")
	

	return false;
}

function facebookComment(){
	if(!validateCheckedSJUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId = $("#shareJobDialog input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $(".contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#shareJobDialog #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/facebook/commentAtFacebook',
		dataType: 'json',
		data: "usersNames="+usersNames+
				"&usersId="+usersId+
				"&subject="+$("#ShareSubject").val()+
				"&message="+$("#shareJobDialog #ShareMessage").val()+
				"&jobId="+$("#shareJobDialog #ShareJobId").val()+
				"&code="+$('#shareJobDialog #code').val(),
		success: function(response){
			$('#shareJobDialog #submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					// show success message
					$("#ShareSubject").val("");
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
			alert(message);
		}
	});
	return false;
}
/****** linked in comment ******/

function linkedInComment(){
	if(!validateCheckedSJUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId = $("#shareJobDialog input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $("#shareJobDialog .contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
						return this.title;
					}
				}).get().join(",");

	$('#shareJobDialog #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/Linkedin/sendMessagetoLinkedinUser',
		dataType: 'json',
		data: "usersNames="+usersNames+
				"&usersId="+usersId+
				"&subject="+$("#ShareSubject").val()+
				"&message="+$("#ShareMessage").val()+
				"&jobId="+$("#ShareJobId").val()+
				"&code="+$('#code').val(),
				
		success: function(response){
			$('#submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$("#ShareSubject").val("");
					$( "#dialog-messageshare" ).html("Successfully sent a message to Linkedin users.");
					$( "#dialog-messageshare" ).dialog("open");
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
			alert(" something went wrong. Please try later or contact to site admin");
			$( "#shareJobDialog" ).dialog( "close" );
		}
	});
	return false;
}

/****** Twitter comment ******/

function TwitterComment(){
	if(!validateCheckedSJUser()){
		return false;
	}
	if(!validateFormField()){
		return false;
	}
	usersId = $("#shareJobDialog input[class=friend_checkbox]:checked").map(function () {return this.value;}).get().join(",");
	usersNames = $("#shareJobDialog .contactBox input[class=facebookfriend]:checked").map(function () {
					if(this.title){
							return this.title;
						}
					}).get().join(",");
	
	$('#shareJobDialog #submitLoaderImg').show();
	$.ajax({
		type: 'POST',
		url: '/twitter/sendMessageToTwitterFollwer',
		dataType: 'json',
		data: "usersId="+usersId+"&subject="+$("#ShareSubject").val()+"&message="+$("#ShareMessage").val()+"&jobId="+$("#ShareJobId").val(),
		success: function(response){
			$('#shareJobDialog #submitLoaderImg').hide();
			switch(response.error){
				case 0: // success
					$("#ShareSubject").val("");
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
$('#shareJobDialog .contactName').each(function(index){
	name[index] = $(this).html();
	alert(name[index]);
});

</script>

<script>
$(document).ready(function(){
	$("#ShareJobForm").validate();
	$("#autocompleteEmail").blur(function(){
		$('#ShareToEmail').val($(this).val());
	});
	$("#autocompleteEmail").submit(function(){
	    $('#InviteToEmail').val($(this).val());
	});
	$("#autocompleteEmail").autocomplete({
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
				//$('#ShareToEmail').val(ui.item.value);
				$('#ShareToEmail').val(ui.item.value);
				var terms = $("#autocompleteEmail").val()+ui.item.value;
				terms = terms.split(",");
				this.value = terms.join( "," );
				$("#autocompleteEmail").val(this.value+",");
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
