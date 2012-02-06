<?php
/* SVN FILE: $Id$ */
/**
 * Index user view.
 *
 * Index user view for Bancer Control Panel Plugin.
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
<div class="users index">
	<h2><?php __('Users');?></h2>
	<?php echo $this->element('paginator_counter'); ?>
	<?php echo $form->create('User', array('class' => 'filter' ,'url' => array('action' => 'index'))); ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $paginator->sort('id');?></th>
				<th><?php echo $paginator->sort('username');?></th>
				<th><?php echo $paginator->sort('group_id');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $form->input('username', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('Group.name', array('label' => false, 'div' => false)); ?></td>
				<td class="actions"><?php echo $this->element('filter_buttons'); ?></td>
			</tr>
		<?php
		$i = 0;
		foreach ($users as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php echo $user['User']['id']; ?>
				</td>
				<td>
					<?php echo $user['User']['username']; ?>
				</td>
				<td>
					<?php
						echo $html->link(
							$user['Group']['name'],
							array('controller'=> 'groups', 'action'=>'view', $user['Group']['id'])
						);
					?>
				</td>
				<td class="actions">
					<?php
					echo $databaseMenus->makeMenu($actionsMenu, 'actions', $user['User']['id'], $user['User']['username']);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $form->end(); ?>
</div>
<?php echo $this->element('paginator_links'); ?>