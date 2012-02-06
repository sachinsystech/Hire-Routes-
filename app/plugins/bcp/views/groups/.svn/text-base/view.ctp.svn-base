<?php
/* SVN FILE: $Id$ */
/**
 * Display group view.
 *
 * Display group view for Bancer Control Panel Plugin.
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
<div class="bcp_act">
	<?php
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $group['Group']['id'], $group['Group']['name']);
	?>
</div>
<div class="groups view">
	<h2><?php __('Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			echo $html->link($parent['Group']['name'], array(
				'controller'=> 'groups', 'action'=>'view', $parent['Group']['id']
			));
			?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="">
	<?php
	echo $databaseMenus->makeMenu($usersExtraMenu, 'extra');
	?>
</div>
<div class="related">
	<h3><?php __('Related Users');?></h3>
	<?php if(!empty($group['User'])):?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php __('Id'); ?></th>
				<th><?php __('Username'); ?></th>
				<th><?php __('Last login'); ?></th>
				<th><?php __('Group Id'); ?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<?php
			$i = 0;
			foreach ($group['User'] as $user):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $user['id'];?></td>
					<td><?php echo $user['username'];?></td>
					<td><?php echo $user['last_login'];?></td>
					<td><?php echo $user['group_id'];?></td>
					<td class="actions">
						<?php
						echo $databaseMenus->makeMenu($usersActionsMenu, 'actions', $user['id'], $user['username']);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
