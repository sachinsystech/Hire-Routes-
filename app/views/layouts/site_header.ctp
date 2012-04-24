<!--
<div>
	<div id="tabs" style="float:left;">
	  <ul style="float:left;">
		<li></li>
		<li><a href="/"><span> HOME </span></a></li>
		<li><a href="#"><span> JOBS </span></a></li>
		<li><a href="#"><span>ABOUT</span></a></li>
		
		
		<?php /*$current_user = $this->Session->read('Auth.User'); ?>
		
		<?php  if($current_user['id']==2):?>
		  <li><a href="/users/login"><span>LOG IN</span></a></li>
		  <li><a href="/users"><span>SIGN UP</span></a></li>
   	    <?php endif; ?>

	  </ul>
	</div>

	<div style="float:right; margin-top: 15px;">
		  <?php echo $databaseMenus->auth_links(); */?>
	</div>
</div>
-->
	<?php $current_user = $this->Session->read('Auth.User'); ?>


	<div id="tabs" style="clear:both;">
	  <ul style="float:left;">
		<li></li>
		<li><a href="/"><span> HOME </span></a></li>
		<li><a href="/jobs"><span> JOBS </span></a></li>
		<li><a href="#"><span>ABOUT</span></a></li>	
	  </ul>

	  <ul style="float:right;">
		<?php  if($current_user['id']==2 || !isset($current_user)):?>
		<?php require_once(APP_DIR.'/vendors/facebook/hr_facebook.php'); ?>
		<li><a href="<?php echo $facebook->getLoginUrl(array('scope' => 'email,read_stream')); ?>"><span>Facebook</span></a></li>
		<li><a href="/users/login"><span>LOG IN</span></a></li>
		<li><a href="/users"><span>SIGN UP</span></a></li>
		<li><a href="/contactUs"><span>CONTACT US</span></a></li>
   	    <?php endif; ?>

		<?php  if($current_user['id']==1):?>
		<li><a href="/users/firstTime"><span>MY ACCOUNT</span></a></li>
		<li><a href="/users/logout"><span>LOG OUT</span></a></li>
		<li><a href="/contactUs"><span>CONTACT US</span></a></li>
	    <?php endif; ?>

		<?php  if($current_user['id']>2):?>
		<li><a href="/users/myAccount"><span>MY ACCOUNT</span></a></li>
		<li><a href="/users/logout"><span>LOG OUT</span></a></li>
		<li><a href="/contactUs"><span>CONTACT US</span></a></li>
	    <?php endif; ?>
	  </ul>
	</div>

