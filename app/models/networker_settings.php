<?php

class NetworkerSettings extends AppModel {
    var $name = 'NetworkerSettings ';
    var $useTable = 'networker_settings';
    
    var $validate=array(
		'industry' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'industry can not be blank.',
				'last'=>true,
			),
        ),
    );
}

?>
