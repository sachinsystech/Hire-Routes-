<?php
/**
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
<p>
	<?php
	echo $paginator->counter(array(
		'format' => __(
			'Page %page% of %pages%, showing %current% records out of %count% total,
				starting on record %start%, ending on %end%',
			true
		)
	));
	$paginator->options(array('url' => array($url)));
	?>
</p>