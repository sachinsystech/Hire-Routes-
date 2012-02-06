<?php
/* SVN FILE: $Id$ */
/**
 * Redundant menus view.
 *
 * Redundant menus view for Bancer Control Panel Plugin.
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
<div class="menus redundant">
	<h2><?php __('Redundant Menus');?></h2>
	<p>
		<?php __('The pages for menu items below do not exist. It is recommended to delete these menu items.');?>
	</p>
	<?php echo $form->create('Menu', array('class' => 'filter' ,'url'=>array('action'=>'redundant'))); ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php __('Id'); ?></th>
				<th><?php __('Type');?></th>
				<th><?php __('Name');?></th>
				<th><?php __('Parent');?></th>
				<th><?php __('Controller');?></th>
				<th><?php __('Method');?></th>
				<th><?php __('Published');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<?php
			$i = 0;
			foreach($menus as $menu):
				$class = null;
				if($i++ % 2 == 0){
					$class = ' class="altrow"';
				}
				?>
				<tr<?php echo $class;?>>
					<td>
						<?php echo $menu['Menu']['id']; ?>
					</td>
					<td>
						<?php echo $menu['Menu']['type']; ?>
					</td>
					<td>
						<?php echo $menu['Menu']['name']; ?>
					</td>
					<td>
						<?php
						echo $html->link(
							$menu['Parent']['name'],
							array('controller'=> 'menus', 'action'=>'view', $menu['Parent']['id'])
						);
						?> &nbsp;
					</td>
					<td>
						<?php echo $menu['Menu']['controller']; ?>
					</td>
					<td>
						<?php echo $menu['Menu']['method']; ?>&nbsp;
					</td>
					<td>
						<?php
						if($menu['Menu']['published'] == 1){
							echo __('Yes', true);
						}else{
							echo __('No', true);
						}
						?>
					</td>
					<td class="actions">
						<?php
						echo $databaseMenus->makeMenu($actionsMenu, 'actions', $menu['Menu']['id'], $menu['Menu']['name']);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php echo $form->end(); ?>
</div>