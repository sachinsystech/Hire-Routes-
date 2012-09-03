<?php 

?>
<script>
<?php 
if($this->Session->read('apiSource') == "share_job")
   echo "window.opener.fillLinkedinFriendShareJob();";
else
	echo "window.opener.fillLinkedinFriend();";
	$this->Session->delete('apiSource')
?>
    window.close();
</script>
