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

