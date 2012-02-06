<?php
/* SVN FILE: $Id$ */
/**
 * Settings index view.
 *
 * Settings index view for Bancer Control Panel Plugin.
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
<div class="settings index">
	<h2><?php __('Settings');?></h2>
	<?php echo $this->element('paginator_counter'); ?>
	<?php echo $form->create('Setting', array('class' => 'filter' ,'url' => array('action' => 'index')));
	//debug($settings);
	//debug($form->fieldset);
	//debug($form->inputs());
	//debug($form);
	?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $paginator->sort('id');?></th>
				<th><?php echo $paginator->sort('name');?></th>
				<th><?php echo $paginator->sort('category');?></th>
				<th><?php echo $paginator->sort('setting');?></th>
				<th><?php echo $paginator->sort('value');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $form->input('name', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('category', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('setting', array('label' => false, 'div' => false, 'type' => 'text')); ?></td>
				<td><?php echo $form->input('value', array('label' => false, 'div' => false, 'type' => 'text')); ?></td>
				<td class="actions"><?php echo $this->element('filter_buttons'); ?></td>
			</tr>
		<?php
		$i = 0;
		foreach ($settings as $setting):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $setting['Setting']['id']; ?></td>
				<td><?php echo $setting['Setting']['name']; ?></td>
				<td><?php echo $setting['Setting']['category']; ?></td>
				<td><?php echo $setting['Setting']['setting']; ?></td>
				<td><?php echo $setting['Setting']['value']; ?></td>
				<td class="actions">
					<?php
					echo $databaseMenus->makeMenu($actionsMenu, 'actions', $setting['Setting']['id'], $setting['Setting']['name']);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $form->end(); ?>
</div>
<?php echo $this->element('paginator_links'); ?>