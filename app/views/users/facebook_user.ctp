
<div style="font-weight:bold; font-size:27px;"><center>Facebook User!</center></div>


<div style="margin-top:35px">
	<div class="facebook-login">
		<div>
			<a href="<?php echo isset($FBloginlogoutUrl)?$FBloginlogoutUrl:""; ?>">
				<!--button class="<?php //echo $fbButtonClass; ?>"></button></a-->
		</div>	
		
	<div>
</div>
<?php if(isset($faceBookUserData)):?>
	<center><b>Welcome <?php echo $faceBookUserData['first_name']." ".$faceBookUserData['last_name']." !" ?></p>
		<img src="https://graph.facebook.com/<?php echo $faceBookUserData['facebook_id']; ?>/picture">
	</center>
<?php endif?>
