<?php
/* SVN FILE: $Id$ */
/**
 * Add/Edit user form view.
 *
 * Add/Edit user form view for Bancer Control Panel Plugin.
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
<?php
echo $form->input('username', array( 
	'before' => '<div class="tip-message"> '.__('Enter the name that will be used for login', true).'</div>',
	'error' => array(
		'between' => __('The username should be from 5 to 30 characters long.', true),
		'alphaNumeric' => __('The username should contain only letters and numbers.', true),
		'isUnique' => __('This username has been already taken.', true),
	)
));
echo $form->input('confirm_password', array(
	'label' => __('Password', true),
	'type' => 'password',
	'error' => array(
		'comparePasswords' => __('Typed passwords did not match.', true),
		'minLength' => __('The password should be at least 8 characters long.', true),
		'notEmpty' => __('The password must not be empty.', true)
	)
));
echo $form->input('password', array(
	'label' => __('Repeat Password', true)
));
echo $form->input('group_id', array(
	'empty' => '['.__('Select one from the list', true).']',
	'error' => array(
		'numeric' => __('One group must be selected.', true)
	)
));
?>