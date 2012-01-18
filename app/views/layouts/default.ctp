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

		echo $html->script('hr.js');

//		echo $html->script('jquery.js');
		echo $html->script('jquery-latest.js');	
		echo $html->script('jquery.validate.js');
			
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php //echo $this->Html->link(__('Hire Routes', true), '/'); ?></h1>
			<?php include("site_header.ctp");?>
		</div>
		<div id="content">
<<<<<<< HEAD
<?php /*<div id="bcpMainMenuContainer"><?php echo $databaseMenus->makeMenu($mainMenu); ?></div> */ ?>
=======

>>>>>>> f936c6bf0cbec9e05bd8755a5f0b45115c750d67
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php include("site_footer.ctp");?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
