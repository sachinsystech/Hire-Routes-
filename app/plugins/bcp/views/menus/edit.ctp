<?php
/* SVN FILE: $Id$ */
/**
 * Edit menu view.
 *
 * Edit menu view for Bancer Control Panel Plugin.
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
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $form->value('Menu.id'), $form->value('Menu.name'));
	?>
</div>
<div class="menus form">
<?php echo $form->create('Menu');?>
	<fieldset>
		<legend><?php __('Edit Menu');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('type', array(
			'options' => array(
				'main' => 'main',
				'extra' => 'extra',
				'actions' => 'actions',
				'manual' => 'manual'
			),
			'error' => array(
				'notEmpty' => __('This field must not be empty.', true),
				'maxLength' => __('The entry is too long. It should not be longer than 255 symbols.', true),
				'inList' => __('Only "main", "extra", "actions", "manual" values allowed.', true),
			)
		));
		echo $form->input('name', array(
			'error' => array(
				'notEmpty' => __('This field must not be empty.', true),
				'isUnique' => __('This name has been already taken.', true),
				'maxLength' => __('The entry is too long. It should not be longer than 255 symbols.', true),
			)
		));
		echo $form->input('parent_id', array('showParents' => true));
		echo $form->input('plugin', array(
			'readonly' => 'readonly',
			'error' => array(
				'maxLength' => __('The entry is too long. It should not be longer than 100 symbols.', true),
			)
		));
		echo $form->input('controller', array(
			'readonly' => 'readonly',
			'error' => array(
				'maxLength' => __('The entry is too long. It should not be longer than 100 symbols.', true),
			)
		));
		echo $form->input('method', array(
			'readonly' => 'readonly',
			'error' => array(
				'maxLength' => __('The entry is too long. It should not be longer than 100 symbols.', true),
			)
		));
		echo $form->input('published');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>