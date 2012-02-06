<?php
/* SVN FILE: $Id$ */
/**
 * Login user view.
 *
 * Login user view for Bancer Control Panel Plugin.
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

echo $form->create('User', array(/*'plugin' => 'bcp', 'controller' => 'users',*/ 'action' => 'login'));
echo $form->inputs(array(
	'legend' => __('Login', true),
	'account_email',
	'password'
));
echo $form->end('Login');
?>
