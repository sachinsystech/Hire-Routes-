
<?php $confirmation_link = Configure::read('httpRootURL')."users/accountConfirmation/".$userId."/".$confirmCode; ?>
<p></p><b>
<center>
	<span>Please wait, You are redirecting now.......</span><p>
	<?php	echo $html->image("../img/media/ajax-loader.gif"); ?>
</center>
<script>
	window.location.href='<?php echo $confirmation_link; ?>';
</script>




