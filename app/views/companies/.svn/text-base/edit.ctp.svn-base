<?php
/* SVN FILE: $Id$ */
/**
 * Edit setting view.
 *
 * Edit setting view for Bancer Control Panel Plugin.
 *
 * PHP version 5
 * 
 * (C) Copyright 2009, Valerij Bancer (http://bancer.sourceforge.net)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author        Valerij Bancer
 * @link          http://www.bancer.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="">
	<?php
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $form->value('Setting.id'), $form->value('Setting.name'));
	?>
</div>
<div class="settings form">
	<?php echo $form->create('Setting');?>
		<fieldset>
			<legend><?php __('Edit Setting');?></legend>
			<?php
			echo $form->input('id');
			include_once('form.inc');
			?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>