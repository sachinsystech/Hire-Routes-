<?php

class NetworkerContact extends AppModel {
    var $name = 'NetworkerContact';
    var $useTable = 'networker_contacts';
    var $validate = array(
		'contact_email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Please provide a valid email address.'
            ),
        ),
		'contact_name' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Contact Name can not be blank.'
			),
			'minLength'=> array(
				'rule' => array('minLength', 3),
				'message' => 'Contact Name must be at least 3 characters long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'Contact Name not be longer that 255 characters.'
			)
		),
	
	);
    
}

?>
