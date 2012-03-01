<?php

class Code extends AppModel {
    var $name = 'Code';
    var $useTable = 'registration_codes';
	var $validate = array(
		'user_type' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Select User-Type.'
			),			
		),
		'signups' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Enter Sign-ups.'
			),
			'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Enter number of signups'
            )
		),
        'code' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Code cant be left blank.'
			),
			'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This Code is already used.'
            )
            			
		),
	);


}

?>
