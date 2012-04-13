<?php /*Job Details*/?>

<script type="text/javascript"> 
	
    function showDescription(){
	    $('#full_description').show();
            $('#short_description').hide();
            $('#more_info').hide();
	}
</script>
		
<!-- ------------------------ PARTICULAR JOB DETAIL ---------------------->	
	
<?php if(isset($job)): ?>	
<div class="page">
	<!--left section start-->
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!--left section end-->
	<!-- middle section start -->
	<div class="rightBox" style="width:690px;" >
		<!--middle conyent top menu start-->
			<div class='top_menu'>
				<?php echo $this->element('top_menu');?>
			</div>
		<!--middle conyent top menu end-->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); ?>
			<div class="jobDetail_middleBox">
				<table>
					<tr>
						<td>
							<div>
								<div class="logo">
									<img src="" alt="Company Logo" title="company logo" />
								</div>
								<div>
									<div class="title"><?php echo ucfirst($job['Job']['title']); ?></div>
									<div class="detail">
										<strong>By Company :</strong> <?php echo $job['comp']['company_name']."<br>"; ?>

                                        <strong>Website : </strong><?php	echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?>
                                        <br>

                                        <strong>Published in :</strong> 
											<?php echo $job['ind']['industry_name']." - ".$job['spec']['specification_name'].", "; ?>
											<?php  echo $time->timeAgoInWords($job['Job']['created'])."<br><br>";?>
									</div>
								</div>
								<div>
									<div class="about_job"><strong>About the Job</strong></div>
                                    <div class="other_detail">
                                    	<strong>Location :</strong> 
											<?php echo $job['city']['city'].", ".$job['state']['state']."<br>"; ?>
										<strong>Annual Salary Range ($):</strong> 
											<?php echo "<b>".number_format($job['Job']['salary_from']/(1000),1)."K - ".number_format($job['Job']['salary_to']/(1000),1)."K</b><br>"; ?>
										<strong>Type :</strong> 
											<?php echo $job_array[$job['Job']['job_type']]."<br>"; ?>
									</div>
									<div class="desc">
										<?php echo $job['Job']['short_description']."<br>";?>
									</div>
								</div>
								<div class="company_detail">
									<span>
										<strong><?php echo $job['comp']['company_name']; ?></strong></span> - 
												<?php echo $job['city']['city'].", ".$job['state']['state']."<br>"; ?>
                                                <?php echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?><br><br>
											<div class="description" id="short_description">
											<?php $desc = $job['Job']['description'];
													if($desc!=''){
                                                    	$explode = explode(' ',$desc);
														$string  = '';
														$dots = '...';
														if(count($explode) <= 20){
															$dots = '';
														}
														$count  = count($explode)>= 20 ? 20 :count($explode) ;
														for($i=0;$i<$count;$i++){
															$string .= $explode[$i]." ";
														}
														if($dots){
															$string = substr($string, 0, strlen($string));
														}
														echo $string.$dots;
													}?>
											</div>
											<div class="description" id="full_description" style="display:none;">
												<?php echo $job['Job']['description'];?>
											</div>
										</div>
										<?php if(str_word_count($desc)>20){?>
											<div id="more_info">
												<a onclick="showDescription();">More Info</a>
											</div>
										<?php }?>
									</div>
								<div>
							</div>
							<?php if(isset($userrole) && $userrole['role_id']==2 && !isset($jobapply)){?>
                            	

                            <div id="apply" style="padding:20px;">
								<div class="selection-button">
									  <button style="width:200px" onclick='window.location.href="/jobs/applyJob/<?php echo $job['Job']['id'];?>"'><a style="text-decoration: none;">Apply for this job</a></button>
								</div>

							</div>
							<?php }?>
						</td>
					</tr>
				</table>

			</div>
		</div>	
            <?php //echo $this->element("jobRight"); ?>
		<!-- middle conyent list -->
	</div>

	<div style="font-size:1.2em;float:right;width:215px;text-align:center;margin-right:30px;">
		<div style="font-weight:bold;">
			<div style="font-size:1.4em;">
				Total Reward <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
			</div>
			<div>
				Your reward is up to <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
			</div>
		</div>
		<div style="font-size:1.2em;">
			<a href='/howItWorks'>See how it works >></a>
		</div>

		<?php if(empty($userrole['role'])){?>
			<div style="margin-top:20px;">
				<div >
					Know the perfact candidate for this job?
				</div>
				<div >
					<a href='/users/login'><b>Login</b></a>
					OR
					<a href='/users/networkerSignup'><b>Register</b></a>
				</div>
				<div >
					To share and get a Reward
				</div>
			</div>
			<div style="margin-top:20px;">
				<div >
					Are you the perfact candidate for this job?
				</div>
				<div >
					<a href='/users/login'><b>Login</b></a>
					OR
					<a href='/users/jobseekerSignup'><b>Register</b></a>
				</div>
					To apply
			</div>
		<?php }else{
		?>
			<div style="text-align:left">
				<div> Share your unique URL </div>
				<?php $jobId = $job['Job']['id'];?>
				<?php $job_url = Configure::read('httpRootURL').'jobs/jobDetail/'.$jobId.'/';
					  if(isset($code)){
							$job_url = $job_url.'?code='.$code;
					  }
				?>						
			<div><input type="" value="<?php echo  $job_url ?>"></div>

	<div style="clear:both;margin-top:5px;padding: 5px;">
		<img src="/img/mail_it.png" style="float: left;cursor:pointer" onclick='showView(4);'/>
		<span>Mail It</span>
	</div>

	<div style="clear:both;margin-top: 5px;padding: 5px;">
		<img src="/img/facebook_post.png" style="float: left;cursor:pointer" onclick='showView(1);'/>
		<span>Share It on Facebook</span>
	</div>

	<div style="clear:both;margin-top: 5px;padding: 5px;">
		<img src="/img/linkedin_post.png" style="float: left;cursor:pointer" onclick='showView(2);'/>
		<span>	Post on LinkedIn</span>
	</div>

	<div style="clear:both;margin-top: 5px;padding: 5px;">
		<img src="/img/tweeter_post.png" style="float: left;cursor:pointer" onclick='showView(3);'/>
		<span>Tweet It</span>
	</div>
	<?php	} ?>
	</div>
	<!-- middle section end -->
</div>
<?php  endif; ?>

<div></div>

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
<div id="dialog-message"></div>
<div class="page">
<div id ="dialog" title="<?php echo ucfirst($job['Job']['title']); ?>" >
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul class='api_menu'>
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
					<?php echo $form->create('Companies', array('action' => 'shareJobByEmail', 'onsubmit'=>'return validateEmail(CompaniesToEmail.value);')); ?>
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
																'value'=>"Learn more about this job (".$job_url.")"
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
<div id="opener" ></div>
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
		$('#to').html("<div style='padding-bottom:10px;' class='s_j_email'><strong>Email:</strong><textarea id='CompaniesToEmail' name='toEmail' class='email_msg_txtarear' rows='1'></textarea></div>");
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
	if($('#CompaniesSubject').val()==""){
		alert('Subject cant be empty.');
		return false;
	}
	if($('#CompaniesMessage').val()==""){
		alert('Please enter message.');
		return false;
	}
	return true;
}



</script>

<script>


/****************************	Fill Twitter Friends	******************************/
       function fillTwitterFriend(){
            //get list of twitter friends from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/twitter/getTwitterFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
                            break;
                        case 1: // we don't have user's twitter token
                            alert(response.message);
                            window.open(response.URL);
                            break;
                        case 2: // something went wrong when we connect with facebook.Need to login by facebook 
                            $( "#dialog-message" ).html(" something went wrong.Please contact to site admin");
                            $( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
                            break;
                   }
            
                },
                error: function(message){
                    alert(message);
                }
            });
            
        }


/*************************************************************/
       function fillLinkedinFriend(){
            //get list of linkedin friends from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/linkedin/getLinkedinFriendList',
                dataType: 'json',
                success: function(response){
                   switch(response.error){
                        case 0: // success
                            createHTMLforFacebookFriends(response.data);
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
						default :
							$( "#dialog-message" ).html(" something went wrong. Please try later or contact to site admin");
							$( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
							break;
                   }
            
                },
                error: function(message){
                    alert('something went wrong. Please try later or  contact to site admin');
					$( "#dialog" ).dialog( "close" );
                }
            });
            
        }
/***************	Email Sharing ,,,,,,,,,********************************/
		function shareEmail(){
			
				var to_email=$('#CompaniesToEmail').val();
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
				data: {jobId : $('#CompaniesJobId').val(), toEmail : $('#CompaniesToEmail').val(), subject : $('#CompaniesSubject').val(), message : $('#CompaniesMessage').val()},
				success: function(response){
					$('#submitLoaderImg').html('');
					switch(response.error){
						case 0:
							$( "#dialog-message" ).html(" E-mail send successfully.");
							$( "#dialog-message" ).dialog("open");
							setView('Email');
							
							break;
						case 1:
							$( "#dialog-message" ).html("Something went wromg please try later or contact to site admin.");
							$( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
							break;
						case 2:
							$( "#dialog-message" ).html(response.message);
							$( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
							break;	
					}
				},
				error:function(response){
					$('#submitLoaderImg').html('');
					$('#message').html("ERROR:");
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
                data: "usersId="+usersId+"&message="+$("#CompaniesMessage").val()+"&jobId="+$("#CompaniesJobId").val(),
                success: function(response){
				    $('#submitLoaderImg').html('');
                    switch(response.error){
                        case 0: // success
                            // show success message
                            $( "#dialog-message" ).html("Successfully sent a message to facebook users.");
                            $( "#dialog-message" ).dialog("open");
							
                            break;
                        case 1:  
                                $( "#dialog-message" ).html("Something went wrong. Please try later or contact to site admin.");
                                $( "#dialog-message" ).dialog("open");
								$( "#dialog" ).dialog( "close" );
                            break;
                    }
            
                },
                error: function(message){
					$('#submitLoaderImg').html('');
                    alert(message);
                }
            });
			fillFacebookFriend();
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
                data: "usersId="+usersId+"&message="+$("#CompaniesMessage").val()+"&jobId="+$("#CompaniesJobId").val(),
                success: function(response){
					$('#submitLoaderImg').html('');
                    switch(response.error){
                        case 0: // success
                            $( "#dialog-message" ).html("Successfully sent a message to Linkedin users.");
                            $( "#dialog-message" ).dialog("open");
							$('#submitLoaderImg').html('');
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
                   }
            
                },
                error: function(message){
					$('#submitLoaderImg').html('');
                    alert(" something went wrong. Please try later or contact to site admin");
                }
            });
			fillLinkedinFriend();
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
                data: "usersId="+usersId+"&message="+$("#CompaniesMessage").val()+"&jobId="+$("#CompaniesJobId").val(),
                success: function(response){
				    $('#submitLoaderImg').html('');
                    switch(response.error){
                        case 0: // success
                            $( "#dialog-message" ).html("Successfully sent a message to Twitter follower.");
                            $( "#dialog-message" ).dialog("open");
							
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

                   }
            
                },
                error: function(message){
					$('#submitLoaderImg').html('');
                    alert(message);
                }
            });
			
			fillTwitterFriend();
			return false;
        }

/**********************/


        function fillFacebookFriend(){
            //get list of facebook friend from ajax request
            $("#facebook").html("<img src='/img/loading.gif'>");
            $.ajax({
                type: 'POST',
                url: '/facebook/getFaceBookFriendList',
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
                            $( "#dialog-message" ).html("Something went wrong. Please try later or contact to site admin");
                            $( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
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
       $("#other").html("<div style='padding-bottom:20px padding-left:20px; display:inline; '><strong>Share with:</strong></div><div style='float:right'><strong>Share with everyone</strong><input style='float:right'type='checkbox' onclick='var flag=this.checked; $(\".facebookfriend\").each(function(){ this.checked = flag; });'/></div><div id='imageDiv' style='border: 1px solid #000000;width:525px;height:220px;overflow:auto;'>"+html+"</div>");
    }

        //fillFacebookFriend();
        //fillLinkedinFriend();
    </script>

<script>
	$("#CompaniesShareJobByEmailForm").validate();
</script>

