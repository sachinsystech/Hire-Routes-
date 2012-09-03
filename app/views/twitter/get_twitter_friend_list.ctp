<?php ?>
<script>
<?php 
if($this->Session->read('apiSource') == "share_job")
   echo "window.opener.fillTwitterFriendShareJob();";
else
	echo "window.opener.fillTwitterFriend();";
	$this->Session->delete('apiSource')
?>
  window.close();
</script>
