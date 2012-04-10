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
	echo $this->Html->link('Forgot password',array('controller'=>'users','action'=>'forgotPassword'),
											 array('style'=>'color: #1E7EC8;'));
?>
</div>
<script type="text/javascript">
$(document).ready(function(){

	$("#UserLoginForm").validate();	
	$("#UserLoginForm").submit(function(){ 
		if($("#UserRememberMe").is(':checked')){		
			saveCookie(); 
		}else{
			document.cookie = "username"+ "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
			document.cookie = "password"+ "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
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
	document.cookie="username="+escape(username)+(";expires="+exDate.toUTCString()+";security=true;");
	document.cookie="password="+escape(password)+(";expires="+exDate.toUTCString()+";security=true;");
	return ;
}

</script>
