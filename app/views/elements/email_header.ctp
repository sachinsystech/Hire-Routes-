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
	<img src="<?php echo $config_url;?>images/popup_top_header.jpg" alt="" border="0" align="" usemap="#Map" />
	<map name="Map" id="Map">
	  <area shape="rect" coords="304,34,408,136" href="<?php echo $config_url.$intermediateCode.$ic_code; ?>" />
	  <area shape="rect" coords="462,73,485,94" href="https://www.twitter.com/hireroutes" />
	  <area shape="rect" coords="517,68,531,94" href="http://www.facebook.com/hireroutes" />
	  <area shape="rect" coords="565,71,587,93" href="http://www.linkedin.com/pub/austin-root/8/b29/163" />
	</map>
