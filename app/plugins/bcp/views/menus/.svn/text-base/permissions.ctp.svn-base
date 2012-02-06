<?php
/* SVN FILE: $Id$ */
/**
 * Menu permissions view.
 *
 * Menu permissions view for Bancer Control Panel Plugin.
 *
 * PHP version 5
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
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $menu['Menu']['id'], $menu['Menu']['name']);
	?>
</div>
<div class="menu permissions tree">
	<h2><?php echo $menu['Menu']['name'].' '; __('Menu Permissions');?></h2>
		<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Permission');?></th>
			<th><?php __('Groups And Users');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach($tree as $aro):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php
					if($aro['allowed'] == 1){
						$img = 'unlock.png';
					}else{
						$img = 'lock.png';
					}
					echo $html->image($databaseMenus->image_path().$img, array(
						'alt' => __('Denied', true),
						'title' => __('Denied', true)
					));
					echo $html->image(
							$databaseMenus->image_path().strtolower($aro[1]).'.png',
							array('alt' => $aro[1], 'title' => $aro[1])
						);
					?>
				</td>
				<td class="tree"><?php echo ' '.$aro[0].$aro['name']; ?></td>
				<td class="actions">
					<?php
					$aro['name'] = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $aro['name']);
						if($aro[1] == 'Group'){
							$menu = $groupActionsMenu;
						}else{
							$menu = $userActionsMenu;
						}
						echo $databaseMenus->makeMenu($menu, 'actions', $aro[2], $aro['name']);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>