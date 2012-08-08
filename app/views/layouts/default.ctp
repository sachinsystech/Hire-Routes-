<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php //echo $this->Html->charset(); ?>
	<title>
		<?php __('Hire Routes'); ?>
		<?php echo $title_for_layout; ?>

	</title>

	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		$time = time();
		echo $this->Html->css('hrStyle.css?'.$time);
		echo $this->Html->css('jquery_accordion');
		echo $this->Html->css('jquery-ui');
		

		echo $html->script('hr.js');
		echo $html->script('hr_ajax.js');
		echo $html->script('jquery_min.js');	
		echo $html->script('jquery-ui.min.js');
		
		echo $html->script('jquery.validate.js');
	
		echo $scripts_for_layout;
	?>
	<script src= "/js/twitter.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";  
  feedback_widget_options.company = "hire-routes";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";
  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>

<script>
	function hideMessage(){
		$('.message').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.message');
		$('.success').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.success');
		$('.warning').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.warning');
	}
</script>

<script>

function invite(){
	$.ajax({
		type: 'POST',
		url: '/users/invitations',
		dataType: 'json',
		success: function(response){
			if(response['status'] == 1){
				showView(4);
			}else{
				window.location.href= "/users/login" ;
			}
			return;				
		}
	});
}
</script>
</head>
<body onload="hideMessage();">
	<div onclick="return invite();" id="invite_button" >

	</div>

	<div id="wrapper-top"> 
	  <!-- main-nav -->
	  <?php include("site_header.ctp");?>
	</div>
	<div id="content">
	<?php //echo "<pre>"; print_r($this->Session->read()); exit;?>
		<!-- ******		welcome User **** -->
		<?php if($this->Session->read('Auth.User.id')):?>
			<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<div style=" margin-left:10px">
					Welcome <span><?php echo ucfirst($this->Session->read('welcomeName'));?>,</span>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<!-- ******		End welcome User **** -->
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>

	</div>
	<div class="footer-wrap"> 
	  <!-- footer-content-->
	  <?php include("site_footer.ctp");?>
	  <!-- footer-content --> 
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
<div style= "display:hidden;"> 
<?php echo $this->element('invite_friend');?>
</div>
<script>
	$(document).ready(function() {

	});
</script>

