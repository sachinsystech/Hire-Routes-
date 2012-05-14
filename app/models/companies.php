<?php

class Companies extends AppModel {
    var $name = 'Companies';
    var $useTable = 'companies';
    var $validate = array(
    	'company_name' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This can not be blank.'
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z ]*$|',
				'message' => 'This can only be letters.'
			),
			'minLength'=> array(
				'rule' => array('minLength', 3),
				'message' => 'This must be at least 3 characters long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'This can not be longer that 255 characters.'
			)
		),
		'contact_name' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This can not be blank.'
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z ]*$|',
				'message' => 'This can only be letters.'
			),
			'minLength'=> array(
				'rule' => array('minLength', 3),
				'message' => 'This must be at least 3 characters long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'This can not be longer that 255 characters.'
			)
		),
		'contact_phone' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This can not be blank.'
			),
			'allowedCharacters'=> array(
				'rule' => '|^[0-9-]*$|',
				'message' => 'This can only be numbers(dashe also allowed).'
			),
			'minLength'=> array(
				'rule' => array('minLength', 10),
				'message' => 'This must be at least 10 digits long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'This can not be longer that 255 characters.'
			)
		),
	);
}

?>
