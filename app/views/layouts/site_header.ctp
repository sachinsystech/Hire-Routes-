<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		invite(0);
		//Code Starts
		$('.NewTab').click(function() {
    	    $(this).target = "_blank";
    	    window.open($(this).prop('href'));
    	    return false;
	   });
	
	});

	function invite( onclick ){
		$.ajax({
			type: 'POST',
			url: '/users/invitations',
			data: "&source="+onclick+"&invitaionUrl="+window.location.href,
			dataType: 'json',
			success: function(response){
				if(response['status'] == 1){
					showView(4);
					return;
				}
				if(response['status'] == 2){
					return;
				}
				if(response['status'] == 0){
					window.location.href= "/login" ;
				}
				if(response['status'] == 3){
					showView(4);
					return;
				}
				return;				
			}
		});
	}
</script>	
<style>
.feedback, .invite{
cursor:pointer;
}
.selected_menu{
	color : #50A947 !important;
	text-decoration:underline !important;
}
<?php
$class= "class='selected_menu'";
?>
</style>
	<!-- left Tags -->
	<div class="tegs">
		<div class="feedback" > </div>
		<div class="invite" onclick="return invite(1);" ></div>
	</div> 
  <!-- main-nav -->
  <?php $current_user = $this->Session->read('Auth.User'); ?>
	<div class="nav">
		<ul>
		  <li><a href="/" <?php if($this->action=="index" && $this->params['controller'] =="home") echo $class; ?> >home</a></li>
		  <li><a href="/about" <?php if($this->action=="about") echo $class; ?>>about us</a></li>
		  <li><a href="/jobs" <?php if(($this->action=="index" && $this->params['controller'] =="jobs") || $this->action=="jobDetail") echo $class; ?>>jobs</a></li>
		  <li><a href="/contactUs" <?php if($this->action=="contactUs") echo $class; ?>>contact us</a></li>
		</ul>
		<div class="clr"></div>
	</div>

	<!-- main-nav --> 
  
	<!-- main-nav -->
	<div class="nav" id="services">
		<ul>
			<li><a href="#fastFacts" <?php if($this->action=="#") echo $class; ?>>fast facts</a></li>
			<li class="how-works"><a href="/howItWorks" <?php if($this->action=="companyInformation" ||$this->action=="networkerInformation"||$this->action=="jobseekerInformation") echo $class; ?> >how it works</a></li>
		</ul>
		<div class="clr"></div>
	</div>
	<!-- main-nav -->
	<div class="login_signup">
		<?php  if($current_user['id']==2 || !isset($current_user)):?>
			<div class="login"> <a href="/login">Login</a></div>
			<div class="signup"><a href="/users">Sign up</a></div>
		<?php endif; ?>
		<?php  if($current_user['id']==1):?>
			<div class="login"> <a href="/users/firstTime">Account</a></div>
			<div class="signup"><a href="/users/logout">Logout</a></div>
		<?php endif; ?>
		<?php  if($current_user['id']>2):?>
			<div class="login"> <a href="/users/myAccount">Account</a></div>
			<div class="signup"><a href="/users/logout">Logout</a></div>		
		<?php endif; ?>
	</div>
  
	<div class="top">
		<?php echo $this->Session->flash(); ?>
		<div class="Hire-Routes"> </div>
		<div class="icons">
			<ul>
				<li> <a href="http://www.twitter.com/hireroutes" class="twit NewTab" title="Twitter"> </a> </li>
				<li> <a href="http://www.facebook.com/hireroutes" class="fb NewTab" title="Facebook"> </a></li>
				<li> <a href="http://www.linkedin.com/pub/austin-root/8/b29/163" class="in NewTab" title="Linkedin"> </a> </li>
			</ul>
		</div>
	</div>
