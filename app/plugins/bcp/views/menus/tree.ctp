<?php
/* SVN FILE: $Id$ */
/**
 * Menus tree view.
 *
 * Menus tree view for Bancer Control Panel Plugin.
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
<div class="menus tree">
<h2><?php __('Menus Tree');?></h2>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('Name');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach($tree as $menuItem):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		?>
		<tr<?php echo $class;?>>
			<td class="tree"><?php echo $menuItem['Menu']['name']; ?></td>
			<td class="actions">
				<?php
				// Remove any html entities from the name
				$menuItem['Menu']['name'] = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $menuItem['Menu']['name']);
				echo $html->link(
					null,
					array('action' => 'moveup', $menuItem['Menu']['id']),
					array(
						'style' => 'background:url('.$this->webroot.'bcp/img/up_alt.png) no-repeat scroll center;',
						'title' => __('Move up', true).' '.$menuItem['Menu']['name'],
						'class' => 'bcp_actions'
					),
					sprintf(__('Are you sure you want to move up %s and all its children?', true), $menuItem['Menu']['name']),
					false
				);
				echo $html->link(
					null,
					array('action' => 'movedown', $menuItem['Menu']['id']),
					array(
						'style' => '
							background-image:url('.$this->webroot.'bcp/img/down_alt.png);
							background-repeat:no-repeat;
							margin-right: 10px;
							',
						'title' => __('Move down', true).' '.$menuItem['Menu']['name'],
						'class' => 'bcp_actions'
					),
					sprintf(__('Are you sure you want to move down %s and all its children?', true), $menuItem['Menu']['name']),
					false
				);
				echo $databaseMenus->makeMenu($actionsMenu, 'actions', $menuItem['Menu']['id'], $menuItem['Menu']['name']);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
</div>