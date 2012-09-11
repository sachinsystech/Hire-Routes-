<?php $config_url = Configure::read('httpRootURL');?>
<?php if(isset($message['code'])&&!empty($message['code'])){
		$intermediateCode= "?intermediateCode=".$message['code'];
	}else{
		$intermediateCode="";
	}

	if(isset($message['ic_code'])&&!empty($message['ic_code']) && isset($message['code'])&&!empty($message['code'])){
		$ic_code= "&icc=".$message['ic_code'];
	}else if(isset($message['ic_code'])&&!empty($message['ic_code'])){
		$ic_code= "?icc=".$message['ic_code'];
		}else{
			$ic_code="";
	}
	
?>
<div style="width:725px; height:168px;"><img src="<?php echo $config_url;?>images/popup_bottom.jpg" alt="" border="0" 
align="right" usemap="#Map4" />
	<map name="Map4" id="Map4">
		<area shape="rect" coords="239,106,424,146" href="<?php echo $config_url.'contactUs/'.$intermediateCode.$ic_code;?>"/>
		<area shape="rect" coords="24,92,118,109" href="mailto:info@hireroutes.com" />
		<area shape="rect" coords="24,117,156,130" href="<?php echo $config_url.$intermediateCode.$ic_code;?>" />
	</map>
	<map name="Map4">
	<area shape="rect" coords="24,116,156,131" href="<?php echo $config_url.'contactUs/'.$intermediateCode.$ic_code;?>" />
	</map>
</div>
