<?php
/* SVN FILE: $Id$ */
/**
 * Edit user view.
 *
 * Edit user view for Bancer Control Panel Plugin.
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
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $form->value('User.id'), $form->value('User.username'));
	?>
</div>
<div class="users form">
	<?php echo $form->create('User');?>
		<fieldset>
			<legend><?php __('Edit User');?></legend>
			<?php
			echo $form->input('id');
			include_once('form.inc');
			?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>