<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (Configure::read() == 0):
	$this->cakeError('error404');
endif;
?>


<!-- start content-->
<center>
<ul class="home-image">
	<li>
		<?php 
			echo $html->link($html->image("../img/media/1.png",array('width' => 240)), array('controller'=>'users', 'action' => 'companyRecruiterSignup'), array('escape' => false));
	
		?>
	</li>
	<li>
		<?php 
			echo $html->link($html->image("../img/media/2.png",array('width' => 240)), array('controller'=>'users', 'action' => 'networkerSignup'), array('escape' => false));
	
		?>
	</li>
	<li>
		<?php 
			echo $html->link($html->image("../img/media/3.png",array('width' => 240)), array('controller'=>'users', 'action' => 'jobseekerSignup'), array('escape' => false));
	
		?>
	</li>
<ul>

</center>

<!-- end content-->
<?php
	App::import('Core', 'Validation');
	if (!Validation::alphaNumeric('cakephp')) {
		echo '<p><span class="notice">';
		__('PCRE has not been compiled with Unicode support.');
		echo '<br/>';
		__('Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
		echo '</span></p>';
	}
?>
<?php
if (isset($filePresent)):
	if (!class_exists('ConnectionManager')) {
		require LIBS . 'model' . DS . 'connection_manager.php';
	}
	$db = ConnectionManager::getInstance();
	@$connected = $db->getDataSource('default');
?>

<?php endif;?>

