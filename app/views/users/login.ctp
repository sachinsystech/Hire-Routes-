<?php echo $this->Session->flash(); ?>

<div style="width:350px;margin:auto;">
<div class="sigup_heading"><u>Login</u></div>
<?php
	echo $this->Session->flash('auth');
	echo $this->Form->create('User');
	echo "<div class='required'>".$this->Form->input('username',array("class"=>'text_field_bg required'))."</div>";
	echo "<div class='required'>".$this->Form->input('password',array("class"=>'text_field_bg required'))."</div>";
	echo $this->Form->input('rememberMe', array('label' => 'Remember me next time', 'type' => 'checkbox', )); 
	echo $this->Form->end('Login');
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#UserLoginForm").validate();	
	// Check user login page redirect again or not.
	if($("#UserUsername").val()==='' || $("#UserUsername").val()===null ){
		var data=getCookie();
		if(data!=undefined){
			fillCookieOnForm();
		}
	}
	// On submit create cookie.
	$("#UserLoginForm").submit(function(){ 
		if($("#UserRememberMe").is(':checked')){		
			saveCookie(); 
		}else{
			var data=getCookie();
			if(data!=undefined && data[0]===$("#UserUsername").val()){
				// Delete cookie if not check the check box.
				 document.cookie = "username"+ "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
			}
		}
	});

});     

function getCookie(){
	var i=0,x,y,cookieArray=document.cookie.split(";");
	for (i=0;i<cookieArray.length;i++){
		x=cookieArray[i].substr(0,cookieArray[i].indexOf("="));
		y=cookieArray[i].substr(cookieArray[i].indexOf("=")+1);
		var data=unescape(y);
		if (x=='username' && data!=undefined){
			var pos= data.indexOf(",");
			var username=data.substring(0,pos);
			var password=data.substring(pos+1,data.length);
			return [username,password];
		}
	}
	return;
}

function saveCookie(){		
	var username=$("#UserUsername").val();
	var password=$("#UserPassword").val();
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+1);
	var cookie_value=escape(username+','+password)+(";expires="+exdate.toUTCString()+";security=true");
	document.cookie="username=" + cookie_value;
	return ;
}

function fillCookieOnForm(){
	var data=getCookie();
	if(data!=undefined){
		$("#UserUsername").val(data[0]);
		$("#UserPassword").val(data[1]);
		$("#UserRememberMe").attr('checked',true);		
	}
	return;
}
</script>
