<?php
/* SVN FILE: $Id$ */
/**
 * Verify menus tree view.
 *
 * Verify menus tree view for Bancer Control Panel Plugin.
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
<div class="menus verify">
<h2><?php __('Menus Tree Errors');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Id');?></th>
	<th><?php __('Error Type');?></th>
	<th><?php __('Menu Name');?></th>
	<th><?php __('Error Message');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach($errors as $nr => $err):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php
			if(isset($treeErrors[$nr][0]['Menu']['id'])){
				echo $treeErrors[$nr][0]['Menu']['id'];
			}
			?>
		</td>
		<td>
			<?php echo $err[0]; ?>
		</td>
		<td>
			<?php
			if(isset($treeErrors[$nr][0]['Menu']['name'])){
				echo $treeErrors[$nr][0]['Menu']['name'];
			}
			?>
		</td>
		<td>
			<?php echo $err['message']; ?>
		</td>
		<td class="actions">
			<?php
			echo $html->link(
				$html->image($databaseMenus->image_path().'run.png', array(
					'alt' => __('Recover Tree', true),
					'title' => __('Recover Tree', true)
				)),
				array('action' => 'recover'),
				array('escape' => false),
				__('Are you sure you want to recover the tree?\nThe changes are irreversible.\nBack up the database first.', true),
				false
			);
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>