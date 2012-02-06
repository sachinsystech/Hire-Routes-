<?php
/* SVN FILE: $Id$ */
/**
 * User and groups tree view.
 *
 * User and groups tree view for Bancer Control Panel Plugin.
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
<div class="users tree">
	<h2><?php __('Groups And Users Tree');?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Name');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach($tree as $node):
			$class = null;
			if($i++ % 2 == 0){
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
				<td class="tree">
					<?php
					echo $html->image(
						$databaseMenus->image_path().strtolower($node['Aco']['model']).'.png',
						array('alt' => $node['Aco']['model'], 'title' => $node['Aco']['model'])
					);
					echo '&nbsp;'.$node['Aco']['name'];
					?>
				</td>
				<td class="actions">
					<?php
					// Remove any html entities from the name
					$node['Aco']['name'] = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $node['Aco']['name']);
					if($node['Aco']['model'] == 'Group'){
						$menu = $groupActionsMenu;
					}else{
						$menu = $actionsMenu;
					}
					echo $databaseMenus->makeMenu($menu, 'actions', $node['Aco']['id'], $node['Aco']['name']);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>