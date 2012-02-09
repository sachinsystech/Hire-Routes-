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
<?php $fb_url = "https://www.facebook.com/dialog/oauth?client_id=169752649798619&redirect_uri=http%3A%2F%2F192.168.1.28%2Fusers%2FfacebookUser&state=23c99978af8b661972ec79ac2f55fdd2";?>


	<?php $current_user = $this->Session->read('Auth.User'); ?>

	<div id="tabs">
	  <ul style="float:left;">
		<li></li>
		<li><a href="/"><span> HOME </span></a></li>
		<li><a href="/jobs"><span> JOBS </span></a></li>
		<li><a href="#"><span>ABOUT</span></a></li>	
	  </ul>

	  <ul style="float:right;">
		<?php  if($current_user['id']==2 || !isset($current_user)):?>
		<!-- li><a style="background: none; margin: -4px 3px;" href="<?php echo $fb_url; ?>"><button class="facebook"></button></a></li -->
		<li><a href="/users/login"><span>LOG IN</span></a></li>
		<li><a href="/users"><span>SIGN UP</span></a></li>
   	    <?php endif; ?>

		<?php  if($current_user['id']>2):?>
		<li><a href="/users/firstTime"><span>MY ACCOUNT</span></a></li>
		<li><a href="/users/logout"><span>LOG OUT</span></a></li>
	    <?php endif; ?>
	  </ul>
	</div>
