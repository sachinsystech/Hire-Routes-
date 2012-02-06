<?php
/* SVN FILE: $Id$ */
/**
 * Add/Edit setting form view.
 *
 * Add/Edit setting form view for Bancer Control Panel Plugin.
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

echo $form->input('name', array( 
	'before' => '<div class="tip-message"> '.__('Enter the short human readable name of the setting.', true).'</div>',
	'error' => array(
		'notEmpty' => __("The name must not be empty.", true),
		'maxLength' => __("The name should not be longer than 255 characters.", true),
		'isUnique' => __('This name has already been taken.', true),
	)
));
echo $form->input('description', array( 
	'before' => '<div class="tip-message"> '.__('Enter the description of the setting. Be as specific as you want.', true).'</div>',
	'error' => array(
		'notEmpty' => __("The name must not be empty.", true),
	)
));

$categoryOptions = array( 
	'before' => '<div class="tip-message"> '.__("Enter the category of the setting to be used in the application's code. Use letters and numbers only.", true).'</div>',
	'error' => array(
		'notEmpty' => __("The category must not be empty.", true),
		'maxLength' => __("The category should not be longer than 255 characters.", true),
		'alphaNumeric' => __('The category should contain only letters and numbers.', true),
	)
);
if($form->value('Setting.id')){
	$categoryOptions['readonly'] = 'readonly';
}
echo $form->input('category', $categoryOptions);


$settingOptions = array( 
	'before' => '<div class="tip-message"> '.__("Enter the name of the setting to be used in the application's code. Use letters and numbers only.", true).'</div>',
	'error' => array(
		'notEmpty' => __("The setting must not be empty.", true),
		'maxLength' => __("The setting should not be longer than 255 characters.", true),
		'isUnique' => __('This name has already been taken.', true),
		'alphaNumericDashDotUnderscore' => __('The setting should contain only letters, dash, dot, underscore and numbers.', true),
	)
);
if($form->value('Setting.id')){
	$settingOptions['readonly'] = 'readonly';
}
echo $form->input('setting', $settingOptions);

$valuesOptions['error']['allowedValue'] = __("This value is not allowed.", true);
if($form->value('Setting.id') AND isset($values)){
	$valuesOptions['options'] = $values;
	$valuesOptions['selected'] = $form->value('Setting.value');
}
echo $form->input('value', $valuesOptions);
?>