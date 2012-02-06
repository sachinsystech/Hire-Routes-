<?php
/* SVN FILE: $Id$ */
/**
 * Add group view.
 *
 * Add group view for Bancer Control Panel Plugin.
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
<div class="groups form">
	<?php echo $form->create('Group');?>
		<fieldset>
			<legend><?php __('Add Group');?></legend>
			<?php
			echo $form->input('name', array(
				'error' => array(
					'notEmpty' => __('This field must not be empty.', true),
					'isUnique' => __('This name has been already taken.', true),
				)
			));
			echo $form->input('parent_id', array('empty' => true));
			?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>