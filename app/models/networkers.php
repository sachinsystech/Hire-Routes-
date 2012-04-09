<?php
class Networkers extends AppModel {
    var $name = 'Networkers';
    var $useTable = 'networkers';
    
    var $validate=array(
    	'contact_name'=>array(
	    	'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Contact name can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z .]*$|',
				'message' => 'Contact name can only be letters.',
				'last'=>true,
			),
    	),
    	'address'=>array(
    		'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Address can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z /,0-9]*$|',
				'message' => 'Special symbol other than / and , not allowed in address.',
				'last'=>true,
			),
    	),
    	'city'=>array(
    		'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'City can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z ]*$|',
				'message' => 'City can only be letters.',
				'last'=>true,
			),
    	),
    	'state'=>array(
    		'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'State can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z ]*$|',
				'message' => 'State can only be letters.',
				'last'=>true,
			),
    	),
    	'contact_phone'=>array(
    		'notEmpty'=> array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Contact phone can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[0-9-]*$|',
				'message' => 'Contact phone can only be numbers(dashe also allowed).',
				'last'=>true,
			),
			'minLength'=> array(
				'rule' => array('minLength', 10),
				'message' => 'Contact phone must be at least 10 digits long.',
				'last'=>true,
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'Contact phone can not be longer that 255 characters.',
				'last'=>true,
			)
    	),
    );
}
?>
