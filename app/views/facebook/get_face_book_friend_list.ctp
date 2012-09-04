<?php ?>
<script>
window.opener.fillFacebookFriendShareJob();

//window.opener.fillFacebookFriend();
<?php 
/*if($this->Session->read('apiSource') == "share_job")
   echo "window.opener.fillFacebookFriendShareJob();";
else
	echo "window.opener.fillFacebookFriend();";
	$this->Session->delete('apiSource')
*/
?>
    window.close();
</script>
