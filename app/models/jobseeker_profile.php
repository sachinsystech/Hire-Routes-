<?php

class JobseekerProfile extends AppModel {
    var $name = 'JobseekerProfile';
    var $useTable = 'jobseeker_profile';
	var $validate = array(
		
		'answer1' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),			
		),
		'answer2' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),		
		),
        'answer3' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),						
		),
		'answer4' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),			
		),
		'answer5' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),		
		),
        'answer6' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),						
		),
		'answer7' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),			
		),
		'answer8' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),		
		),
        'answer9' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),						
		),
		'answer10' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'This field can not be left blank.'
			),						
		),
		
	);

	
}

?>
