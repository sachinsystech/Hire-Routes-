<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		invite(0);
	});

	function invite( onclick ){
		$.ajax({
			type: 'POST',
			url: '/users/invitations',
			data: "&source="+onclick,
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
					window.location.href= "/users/login" ;
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
		  <li><a href="/">home</a></li>
		  <li><a href="/about">about us</a></li>
		  <li><a href="/jobs">jobs</a></li>
		  <li><a href="/contactUs">contact us</a></li>
		</ul>
		<div class="clr"></div>
	</div>

	<!-- main-nav --> 
  
	<!-- main-nav -->
	<div class="nav" id="services">
		<ul>
			<li><a href="#">fast facts</a></li>
			<li class="how-works"><a href="/howItWorks">how it works</a></li>
		</ul>
		<div class="clr"></div>
	</div>
	<!-- main-nav -->
	<div class="login_signup">
		<?php  if($current_user['id']==2 || !isset($current_user)):?>
			<div class="login"> <a href="/users/login">Login</a></div>
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
				<li> <a href="" class="twit"> </a> </li>
				<li> <a href="<?php echo $FBLoginUrl; ?>" class="fb" > </a></li>
				<li> <a href="<?php echo $LILoginUrl; ?>" class="in"> </a> </li>
			</ul>
		</div>
	</div>
