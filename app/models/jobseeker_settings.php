<?php

class JobseekerSettings extends AppModel {
    var $name = 'JobseekerSettings';
    var $useTable = 'jobseeker_settings';
    
    var $validate=array(
    	'name'=>array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'state can not be blank.',
				'last'=>true,
			),
			'allowedCharacters'=> array(
				'rule' => '|^[a-zA-Z ]*$|',
				'message' => 'This can only be letters.',
				'last'=>true,
			),
			'minLength'=> array(
				'rule' => array('minLength', 3),
				'message' => 'This must be at least 3 characters long.',
				'last'=>true,
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'This can not be longer that 255 characters.',
				'last'=>true,
			)
		),
		'industry_1' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'industry can not be blank.',
				'last'=>true,
			),
        ),
        'industry_2' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'industry can not be blank.',
				'last'=>true,
			),
        ),
		'state' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'state can not be blank.',
				'last'=>true,
			)
		),
		'salary_range' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'salary range can not be blank.',
				'last'=>true,
			),
			'numeric'=>array(
				'rule' => 'numeric',
				'message' => 'salary range must be numeric.',
				'last'=>true,
			),
			'minValue'=>array(
				'rule' => array('comparison', 'greater or equal', 1000),
				'message'=>'salary range must be greater or equal to 1000',
				'last'=>true,
			),
		),
    );
}

?>
