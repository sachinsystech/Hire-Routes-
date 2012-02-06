<?php
/* SVN FILE: $Id$ */
/**
 * Index group view.
 *
 * Index group view for Bancer Control Panel Plugin.
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
<div class="groups index">
<h2><?php __('Groups');?></h2>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('Name');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach($tree as $group):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		?>
		<tr<?php echo $class;?>>
			<td class="tree"><?php echo $group['Group']['name']; ?></td>
			<td class="actions">
				<?php
				echo $databaseMenus->makeMenu($actionsMenu, 'actions', $group['Group']['id'], $group['Group']['name']);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
</div>