
<?php $confirmation_link = Configure::read('httpRootURL')."users/accountConfirmation/".$userId."/".$confirmCode; ?>
<p></p><b>
<div class="clr"></div>
<div style="margin-top:20px;">
<center>
	<span>Please wait, You are redirecting now.......</span><p>
	<?php	echo $html->image("../img/media/ajax-loader.gif"); ?>
</center>
</div>
<script>
	window.location.href='<?php echo $confirmation_link; ?>';
</script>




