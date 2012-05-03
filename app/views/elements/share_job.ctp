<?php 
	/**
	 * Share job element
	 */
?>
<script>
$(function() {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
            width:900,
		});
		$( "#opener" ).click(function() {
			$( "#dialog" ).css( "top" ,'20');
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
	});
</script>
<?php if(isset($jobUrl)):?>
<div><input type="hidden" id="jobUrl" value="<?php echo  $jobUrl ?>"></div>
<div id="dialog-message"></div>
<div class="page">
<div id ="dialog" title="<?php echo ucfirst($jobTitle); ?>" >
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
						<?php echo $form->input('jobId', array('label' => '',
																'type'  => 'hidden',
																'value'=>$jobId
						));?>
					<div style="padding-bottom:0px; clear:both">
						<div  style="float:left"><strong>Subjet:</strong></div>
						<div style="float:right">
						<?php echo $form->input('subject', array('label' => '',
																'type'  => 'text',
																'class'=> 'subject_txt required',
																'value'=>'Job Recommendation :: '
						));?>
						</div>
					</div>
					<div style="padding-bottom:0px; clear:both" class='s_j_email'>
						<div  style="float:left"><strong style="margin-top:10px">Message:</strong></div>
						<?php echo $form->input('message', array('label' => '',
																'type'  => 'textarea',
																'class'=> 'msg_txtarear required',  
																'value'=>"Learn more about this job (".$jobUrl.")"
						));?>
					</div>
					<div id='other' style="padding-bottom:0px; clear:both">
					</div>
					<div style="padding-bottom:0px; clear:both">

						<div style='float:left;'>
							<?php echo $form->button('Clear', array('label' => '',
																	'type'  => 'reset',
																	'value' => 'Clear'
							));?>
						</div>	
						<div style='float:right;'>
							<div style='float:left;'>
							<?php echo $form->button('Share', array('label' => '',
																	'id' =>'share',
																	'type'  => 'submit',
																	'value' => 'Share',
							));?>
							<div id='submitLoaderImg' style='float:right;'></div>
						</div>
						<?php echo $form->input('code', array('label' => '',
															  'id'=>'code',
															  'type'  => 'hidden',
															  'value'=>isset($code)?$code:"",
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
<?php endif;?>
<script>
function showView(type){
    $("#share").unbind();
	$("#opener").click();
    switch(type){
        case 1:
            setView('Facebook');
            fillFacebookFriend();
            $("#share").click(facebookComment);
            break;
        case 2:
            setView('LinkedIn');
            fillLinkedinFriend();
            $("#share").click(linkedInComment);
            break;
        case 3:
            setView('Twitter');
			fillTwitterFriend();
            $("#share").click(TwitterComment);
            break;
        case 4:
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
		$('#other').html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong>Share with:</strong></div><div style='float:right'><strong>Share with everyone</strong><input style='float:right'type='checkbox'/></div><div id='imageDiv' style='border: 1px solid #000000;width:525px;height:220px;overflow:auto;'>");
		$('#imageDiv').html('<p><img src="/images/ajax-loader.gif" width="425" height="21" class="sharejob_ajax_loader"/></p>');
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
			flag  = true;
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
   
   length = friends.length;
   html="";        
   for(i=0;i<length;i++){
	   html += '<div class="contactBox"><div style="position:relative"><div class="contactImage"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox"></div></div><div class="contactName">'+((friends[i].name.split(" ",2)).toString()).replace(","," ")+'</div></div>';
   }
   $("#other").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong>Share with:</strong></div><div style='float:right'><strong>Share with everyone</strong><input style='float:right'type='checkbox' onclick='var flag=this.checked; $(\".facebookfriend\").each(function(){ this.checked = flag; });'/></div><div id='imageDiv' style='border: 1px solid #000000;width:525px;height:220px;overflow:auto;'>"+html+"</div>");
}

</script>

<script>

/************************** close**********************************/
function close(){
	$( "#dialog" ).dialog( "close" );
}

/****************************	1).Fill facebook Friends	******************************/

        function fillFacebookFriend(){
            //get list of facebook friend from ajax request
			$('#imageDiv').html('<p><img src="/images/fbloader.gif" class="sharejob_ajax_loader"/></p>');
            $.ajax({
                type: 'POST',
                url: '/facebook/getFaceBookFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFillingFriends(response.data);
                            break;
                        case 1: // we don't have user's facebook token
                            alert(response.message);
							window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            $( "#dialog-message" ).html("Something went wrong. Please try later or contact to site admin");
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

/****************************	2). Fill Linkedin Friends	******************************/
       
	   function fillLinkedinFriend(){
		   	$('#imageDiv').html('<p><img src="/images/liloader.gif" width="50px" height="50px" class="sharejob_ajax_loader"/></p>');
            $.ajax({
                type: 'POST',
                url: '/linkedin/getLinkedinFriendList',
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
		
/****************************	3). Fill Twitter Friends	******************************/
      
	   function fillTwitterFriend(){
		   	$('#imageDiv').html('<p><img src="/images/twitterLoader.gif" width="42px" height="60px" class="sharejob_ajax_loader"/></p>');
            $.ajax({
                type: 'POST',
                url: '/twitter/getTwitterFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFillingFriends(response.data);
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
/*************************	Email Sharing ***********************/
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
				data: {jobId : $('#ShareJobId').val(), jobUrl: $('#jobUrl').val(), toEmail : $('#ShareToEmail').val(), subject : $('#ShareSubject').val(), message : $('#ShareMessage').val(),code:$('#code').val()},
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
        
        function facebookComment(){
			if(!validateCheckedUser()){
				return false;
			}
			if(!validateFormField()){
					return false;				
			}
            usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
			$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
            $.ajax({
                type: 'POST',
                url: '/facebook/commentAtFacebook',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#ShareMessage").val()+"&jobId="+$("#ShareJobId").val(),
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
			$('#submitLoaderImg').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
            $.ajax({
                type: 'POST',
                url: '/Linkedin/sendMessagetoLinkedinUser',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#ShareMessage").val()+"&jobId="+$("#ShareJobId").val(),
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


    </script>

<script>
	$("#ShareJobForm").validate();
</script>

