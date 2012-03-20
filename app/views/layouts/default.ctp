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
		echo $this->Html->css('hrStyle');
		echo $this->Html->css('jquery_accordion');
		

		echo $html->script('hr.js');

		echo $html->script('jquery_min.js');	
		echo $html->script('jquery-ui.min.js');
		
		//echo $html->script('jquery-latest.js');	
		echo $html->script('jquery.validate.js');
	
		echo $scripts_for_layout;
		if($session->check('Auth.User.id')){ 
	?>
	<script type="text/javascript" charset="utf-8">
		var is_ssl = ("https:" == document.location.protocol);
		var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
		document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
	</script>

	<script type="text/javascript" charset="utf-8">
		var feedback_widget_options = {};

		feedback_widget_options.display = "overlay";  
		feedback_widget_options.company = "hireroutes";
		feedback_widget_options.placement = "left";
		feedback_widget_options.color = "#222";
		feedback_widget_options.style = "idea";  
  

		var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
	</script>
	<?php }?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php //echo $this->Html->link(__('Hire Routes', true), '/'); ?></h1>
			<?php include("site_header.ctp");?>

		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php include("site_footer.ctp");?>
		</div>
	</div>
	<?php // echo $this->element('sql_dump'); ?>
</body>
</html>
