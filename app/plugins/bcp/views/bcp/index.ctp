<?php
/* SVN FILE: $Id$ */
/**
 * Index view.
 *
 * Index view for the home of Bancer Control Panel Plugin.
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
<div class="bcp index">
	<h2><?php __('Control Panel');?></h2>
	<ul class="bcp_home">
		<li>
			<?php
				echo $html->image($databaseMenus->image_path().'user64.png', array(
					"alt" => "Users",
					"title" => "Users",
					'url' => array('controller' => 'users', 'action' => 'index')
				));
				echo __('Users');
			?>
		</li>
		<li>
			<?php
				echo $html->image($databaseMenus->image_path().'group64.png', array(
					"alt" => "Groups",
					"title" => "Groups",
					'url' => array('controller' => 'groups', 'action' => 'index')
				));
				echo __('Groups');
			?>
		</li>
		<li>
			<?php
				echo $html->image($databaseMenus->image_path().'menu64.png', array(
					"alt" => "Menus",
					"title" => "Menus",
					'url' => array('controller' => 'menus', 'action' => 'index'),
				));
				echo __('Menus');
			?>
		</li>
		<li>
			<?php
				echo $html->image($databaseMenus->image_path().'settings64.png', array(
					"alt" => "Settings",
					"title" => "Settings",
					'url' => array('controller' => 'settings', 'action' => 'index'),
				));
				echo __('Settings');
			?>
		</li>
	</ul>
</div>