<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li id='liFacebook'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='return setView("Facebook");'>Facebook</a></li>
				<li id='liLinkedIn'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='return setView("LinkedIn");'>LinkedIn</a></li>
				<li id='liTwitter'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='return setView("Twitter");'>Twitter</a></li>
				<li id='liEmail'class="active" ><a style="text-decoration: none;font-weight: normal;" href=# onclick='return setView("Email");'>Email</a></li>
				<li id='liOther'><a style="color: #000000;text-decoration: none;font-weight: normal;" href=# onclick='return setView("Other");'>Other</a></li>
			</ul>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conyent list -->

			<div class="middleBox">
				<div class='message' id='message'></div>
				<div class="setting_profile">
					<?php echo $form->create('Companies', array('action' => 'tst_share_job', 'onsubmit'=>'return validateEmail(CompaniesToEmail.value);')); ?>
					<div id='to'>
					</div>
					<div style="padding-bottom:20px"><strong>Subjet:</strong>
						<?php echo $form->input('subject', array('label' => '',
																'type'  => 'text'
						));?>
					</div>
					<div style="padding-bottom:20px"><strong>Message:</strong>
						<?php echo $form->input('message', array('label' => '',
																'type'  => 'textarea'
						));?>
					</div>
					<div id='other'>
					</div>
					<div style="">
						<?php echo $form->button('Share', array('label' => '',
																'type'  => 'button',
																'value' => 'Share',
																'onclick'=> 'return facebookComment();',
																'style' => 'float:right;'
						));?>
						<?php echo $form->button('Cancel', array('label' => '',
																'type'  => 'reset',
																'value' => 'Cancel'
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
<script>
setView('Facebook');
function setView(value)
{
	$('#message').hide();
	if(value=='Email')
	{
		$('li').removeClass('active');
		$('#li'+value).addClass('active');
		$('#other').html("");
		$('#to').html("<div style='padding-bottom:10px;'><strong>Email Address:</strong><textarea id='CompaniesToEmail' name='toEmail' rows='1'></textarea></div>");
	}
	else
	{	
		$('li').removeClass('active');
		$('#li'+value).addClass('active');
		$('#to').html("");
		$('#other').html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong>Share with:</strong></div><div style='float:right'><strong>Share with everyone</strong><input style='float:right'type='checkbox'/></div><div id='imageDiv' style='border: 1px solid #000000;width:400px;height:220px;overflow:auto;'>");
		for(var i=0;i<32;i++)
			$('#imageDiv').append("<img src='/img/left.png' style='border: 1px solid #000000;margin:1px;' width='50px' height='50px' alt='NA'/>");
		$('#imageDiv').after("</div>");
	}
	return false;
}

function share()
{
	var to_email=$('#CompaniesToEmail').val();
	if(to_email!=undefined)
		validateEmail(to_email);
	$.ajax({
		url: "/companies/shareJobByEmail",
		type: "post",
		data: {toEmail : $('#CompaniesToEmail').val(), subject : $('#CompaniesSubject').val(), message : $('#CompaniesMessage').val()},
  		success: function(response){
  				$('#message').show();
				$('#message').html(response);		
			},
		error:function(response)
		{
			$('#message').html("ERROR:");
		}
	});
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
</script>

    <script>

/*************************************************************/
       function fillLinkedinFriend(){
            //get list of facebook friend from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/companies/getLinkedinFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
                            break;
                        case 1: // we don't have user's facebook token
                            alert(response.message);
                            window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            alert(response.message);
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
            
        }
/**************************************************************/

        
        function facebookComment(){
            usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
            $.ajax({
                type: 'POST',
                url: '/companies/commentAtFacebook',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#message").val(),
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            // show success message
                            break;
                        case 1: // we don't have user's facebook token
                            // show error message
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
        }


/****** linked in comment ******/


        function linkedInComment(){
            usersId=$("input[class=facebookfriend]:checked").map(function () {return this.value;}).get().join(",");
            $.ajax({
                type: 'POST',
                url: '/companies/sendMessagetoLinkedinUser',
                dataType: 'json',
                data: "usersId="+usersId+"&message="+$("#message").val(),
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            // show success message
                            break;
                        case 1: // we don't have user's facebook token
                            // show error message
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
        }

/**********************/


        function fillFacebookFriend(){
            //get list of facebook friend from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/companies/getFaceBookFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
                            break;
                        case 1: // we don't have user's facebook token
                            alert(response.message);
                            window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            alert(response.message);
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
            
        }

    function createHTMLforFacebookFriends(friends){
       
       length = friends.length;
       html="";        
       for(i=0;i<length;i++){
           html += '<div class="contactBox"><div style="position:relative"><div class="contactImage"><img width="50" height="50" src="' + friends[i].url +'" title="'+ friends[i].name + '"/></div><div class="contactCheckBox"><input class="facebookfriend" value="'+friends[i].id+'" type="checkbox"></div></div></div>';
       }
       $("#other").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong>Share with:</strong></div><div style='float:right'><strong>Share with everyone</strong><input style='float:right'type='checkbox' onclick='var flag=this.checked; $(\".facebookfriend\").each(function(){ this.checked = flag; });'/></div><div id='imageDiv' style='border: 1px solid #000000;width:400px;height:220px;overflow:auto;'>"+html+"</div>");
    }

        fillFacebookFriend();
        //fillLinkedinFriend();
    </script>

