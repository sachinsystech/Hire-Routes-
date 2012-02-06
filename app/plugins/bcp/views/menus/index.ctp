<?php
/* SVN FILE: $Id$ */
/**
 * Edit menu view.
 *
 * Edit menu view for Bancer Control Panel Plugin.
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
<div class="menus index">
	<h2><?php __('Menus');?></h2>
	<?php echo $this->element('paginator_counter'); ?>
	<?php echo $form->create('Menu', array('class' => 'filter' ,'url' => array('action' => 'index'))); ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>
					<?php echo $paginator->sort(__('Id', true), 'id', array('url' => array($url))); ?>
				</th>
				<th><?php echo $paginator->sort('type');?></th>
				<th><?php echo $paginator->sort('name');?></th>
				<th><?php echo $paginator->sort('Parent','Parent.name');?></th>
				<th><?php echo $paginator->sort('plugin');?></th>
				<th><?php echo $paginator->sort('controller');?></th>
				<th><?php echo $paginator->sort('method');?></th>
				<th><?php echo $paginator->sort('published');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo $form->input('type', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('name', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('Parent.name', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('plugin', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('controller', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('method', array('label' => false, 'div' => false)); ?></td>
				<td><?php echo $form->input('published', array('label' => false, 'div' => false)); ?></td>
				<td class="actions"><?php echo $this->element('filter_buttons'); ?></td>
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
					<td><?php echo $menu['Menu']['id']; ?></td>
					<td><?php echo $menu['Menu']['type']; ?></td>
					<td><?php echo $menu['Menu']['name']; ?></td>
					<td>
						<?php
						echo $html->link(
							$menu['Parent']['name'],
							array('controller'=> 'menus', 'action'=>'view', $menu['Parent']['id'])
						);
						?> &nbsp;
					</td>
					<td><?php echo $menu['Menu']['plugin']; ?></td>
					<td><?php echo $menu['Menu']['controller']; ?></td>
					<td><?php echo $menu['Menu']['method']; ?>&nbsp;</td>
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
<?php echo $this->element('paginator_links'); ?>