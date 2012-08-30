
<script>
	$(document).ready(function(){
		
		$("#UserLoginForm").validate({
			  errorClass: 'error_input_message',
			   errorPlacement: function (error, element) {
			       error.insertAfter(element)
            	}
		});
	});
</script>
	<h1 class="title-emp">Login to Hire Routes</h1>
    
    <div class="login_middle_main">
        <div class="login_middle_left_box">
        	<?php
				echo $this->Session->flash('auth');
				echo $this->Form->create('User');
			?>	

            <div class="text-box">
             <?php echo $this->Form->input('username',array('type'=>'text',
																'class'=>'required',
																'div'=>false,
																'label' => false,
																'placeholder' =>'Username'));
									?>
            </div>
            <div class="text-box text-box-below"> 
             <?php echo $this->Form->input('password',
																		array('class'=>'required',
																			'type'=>'password',
																			'div'=>false,
																			'label' => false,
																			'placeholder' =>'Password'));
																			?>
             </div>
             <div class="check-button">
             <div class="cross-button">
          	   <?php
		 			echo $this->Form->input('rememberMe', array('type' => 'checkbox',
		 													'div'=>false,
													 		'format' => array('before', 'input', 'after', 'error'),
													 		'class' =>'false',
		 					 )); 
				?>
             </div>
             <div class="remember-me">Remember me next time</div>
             </div>
             <div class="login-button">
                <input type="submit" value="LOGIN"/>
                <div class="clr"></div>
             </div>
             <div class="forgot-password"><a href="/users/forgotPassword">Forgot Password</a></div>
			<?php
				echo $this->Form->end();
			?>
        </div>
        <div class="login_middle_center_box"><strong>OR</strong></div>
        <div class="login_middle_right_box">
            <ul>
                <li><a class="job-share-fb" href="<?php echo $FBLoginUrl; ?>"></a></li>
                <li><a class="job-share-in" href="<?php echo $LILoginUrl; ?>"></a></li>
            </ul>
        </div>
		<div class="clr"></div>
	</div>


<script type="text/javascript">
$(document).ready(function(){
	$("#UserLoginForm").submit(function(){ 
		if($("#UserRememberMe").is(':checked')){		
			saveCookie(); 
		}else{
			document.cookie = "username"+ "=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
			document.cookie = "password"+ "=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
		}
	});

	if($("#UserUsername").val()==='' || $("#UserUsername").val()===null ){
		var data=getCookie();
		if(data!=undefined){
			$("#UserUsername").val(data[0]);
			$("#UserPassword").val(data[1]);
			$("#UserRememberMe").attr('checked',true);		
		}
	}
});     

function getCookie(){
	var i=0,x,y,cookieArray=document.cookie.split(";");
	var cookieLength = cookieArray.length;
	var username ,password,equalPos;
	var data= new Array();
	var cookieName = new Array();
	for (i=0;i<cookieLength ;i++){
		equalPos = cookieArray[i].indexOf("=");	
		cookieName[i]=cookieArray[i].substr(0,equalPos);
		data[i]=cookieArray[i].substr(equalPos+1);
		data[i]=unescape(data[i]);
	}
	if(cookieName[0]==="username"){
		username=data[0];
		password=data[1];
		return [username,password];
	}
	return;
}

function saveCookie(){		
	var username=$("#UserUsername").val();
	var password=$("#UserPassword").val();
	var exDate=new Date();
	exDate.setDate(exDate.getDate()+2);
	document.cookie="username="+escape(username)+("; expires="+exDate.toUTCString()+"; security=true;");
	document.cookie="password="+escape(password)+("; expires="+exDate.toUTCString()+"; security=true;");
	return ;
}
</script>

