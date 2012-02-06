<?php
/* SVN FILE: $Id$ */
/**
 * Add user view.
 *
 * Add user view for Bancer Control Panel Plugin.
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
<div class="users form">
	<?php echo $form->create('User');?>
		<fieldset>
			<legend><?php __('Add User');?></legend>
			<?php include_once('form.inc'); ?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>