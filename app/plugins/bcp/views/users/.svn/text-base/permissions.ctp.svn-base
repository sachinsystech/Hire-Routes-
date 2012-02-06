<?php
/* SVN FILE: $Id$ */
/**
 * User permissions view.
 *
 * User permissions view for Bancer Control Panel Plugin.
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
	echo $databaseMenus->makeMenu($actionsMenu, 'extra', $this->data['User']['id'], $this->data['User']['username']);
	?>
</div>
<div class="user permissions tree">
	<?php
	echo $form->create('User', array('action' => 'permissions'));
		echo $form->hidden('id');
		?>
		<h2>
			<?php
			echo $this->data['User']['username'].' ';
			__('User Permissions');
			?>
		</h2>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php __('Menu Item');?></th>
				<th><?php __('Permission');?></th>
				<th colspan="2" class="actions"><?php __('Actions');?></th>
			</tr>
			<?php
			$i = 0;
			foreach($acosTree as $id => $node):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				?>
			<tr<?php echo $class;?>>
				<td class="tree">
					<?php echo $node['name']; ?>
				</td>
				<td>
					<?php
					if($node['allowed'] == 1){
						echo $html->image('/bcp/img/unlock.png', array(
							'alt' => __('Allowed', true),
							'title' => __('Allowed', true)
						));
					}else{
						echo $html->image('/bcp/img/lock.png', array(
							'alt' => __('Denied', true),
							'title' => __('Denied', true)
						));
					}
					?>
				</td>
				<td class="actions">
					<?php
					if(isset($existingPermissions[$id])){
						$selected = $existingPermissions[$id];
					}else{
						$selected = null;
					}
					echo $form->hidden('Acos.'.$id.'.model', array('value' => $node[1]));
					echo $form->hidden('Acos.'.$id.'.foreign_key', array('value' => $node[2]));
					echo $form->hidden('Acos.'.$id.'.name', array('value' => str_replace('&middot;&nbsp;&nbsp;&nbsp;', '', $node['name'])));
					echo $form->radio(
						'Acos.'.$id.'.permission',
						array('1' => 'Allow', '-1' => 'Deny'),
						array('default' => $selected, 'legend' => false, 'separator' => '</td><td class="actions">')
					);
					?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php
		/* TODO: Debug: After "Clear" button is pressed and several permissions are selected and "Submit"
		 * button is pressed $this->data in the controller is empty. The form submits nothing.
		 * Fix it if possible.*/ ?>
		<div class="submit">
			<?php /*echo $form->button('Clear', array('type'=>'button', 'onclick' => 'clearForm();'));*/ ?>
			&nbsp;&nbsp;&nbsp;
			<?php echo $form->button('Reset', array('type'=>'reset')); ?>
			&nbsp;&nbsp;&nbsp;
			<?php echo $form->button('Submit', array('type'=>'submit')); ?>
		</div>
		<?php
		
	echo $form->end();
	?>
</div>