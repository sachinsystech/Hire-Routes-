<?php
/* SVN FILE: $Id$ */
/**
 * Change password view.
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
<div class="changePassword form">
	<?php echo $form->create('User', array('action' => 'changePassword'));?>
		<fieldset>
			<legend><?php __('Change Password');?></legend>
			<?php
			echo $form->input('id');
			echo $form->input('username', array('type' => 'hidden'));
			echo $form->input('group_id', array('type' => 'hidden'));
			echo $form->input('confirm_password', array(
				'label' => __('New password', true),
				'type' => 'password',
				'error' => array(
					'comparePasswords' => __('Typed passwords did not match.', true),
					'minLength' => __('The password should be at least 8 characters long.', true),
					'notEmpty' => __('The password must not be empty.', true)
				)
			));
			echo $form->input('password', array(
				'label' => __('Repeat New Password', true)
			));
			?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>