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
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Hire Routes'); ?>
		<?php echo $title_for_layout; ?>

	</title>

	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		$time = time();
		echo $this->Html->css('default.css?'.$time);
		echo $this->Html->css('template.css?'.$time);
		//echo $this->Html->css('jquery_accordion');
		echo $this->Html->css('jquery-ui');
		echo $html->script('hr.js');
		echo $html->script('hr_ajax.js');
		echo $html->script('jquery_min.js');	
		echo $html->script('jquery-ui.min.js');
		echo $html->script('jquery.validate.js');
		echo $html->script('html5placeholder.jquery.js');		
		echo $scripts_for_layout;
	?>
<script src= "/js/twitter.js" type="text/javascript"></script>
<!-- script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));

	var feedback_widget_options = {};
	feedback_widget_options.display = "overlay";  
	feedback_widget_options.company = "hire-routes";
	feedback_widget_options.placement = "left";
	feedback_widget_options.color = "#222";
	feedback_widget_options.style = "idea";
	var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script -->
	
<script type="text/javascript" charset="utf-8">
	function hideMessage(){
		$('.message').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.message');
		$('.success').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.success');
		$('.warning').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.warning');
	}

</script>
</head>
<body onload="hideMessage();">
	<div id="wrapper-top"> 
	  <!-- main-nav -->
	  <?php include("site_header.ctp");?>
	</div>
	<!-- Wrapper-middle -->
	<div id="wrapper-middle">
		<div class="middle">
		<!-- Hire Route -->
			
			<!-----------------------  Content for layout ---------------------------->
				<!-- ******		welcome User **** -->
				<!-- ******		End welcome User **** -->
				<?php echo $content_for_layout; ?>
			<!--------------------- End content for layout -------------------------->
		</div>
	</div>
	<!-- wrapper-middle end -->
	<div class="footer-wrap"> 
		<!-- footer-content-->
		<?php include("site_footer.ctp");?>
		<!-- footer-content --> 
	</div>
	<div style= "display:hidden;"> 
		<?php //echo $this->element('invite_friend');?>
	</div>
</body>
</html>
<script type="text/javascript">
   $("document").ready(function(){
		$(".feedback").click(function(){
			$("#fdbk_tab").click();
		});
		
		$("#menu_show").click();
	});
		$(function(){
$(':input[placeholder]').placeholder();
}); 
</script>

