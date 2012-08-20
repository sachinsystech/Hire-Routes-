<?php

class InvitaionCode extends AppModel {
    var $name = 'InvitaionCode';
    var $useTable = 'invitaion_codes';
	var $validate = array(
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
        'invitaion_code' => array(
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
