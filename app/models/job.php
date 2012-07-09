<?php

class Job extends AppModel {
    var $name ='Job';
    var $useTable ='jobs';
    var $order = "Job.created DESC";
    var $validate = array(
		'title' => array(
			'notEmpty'=> array(
				'rule' =>'notEmpty',
				'message'=>'title can not be blank.',
				'last'=>true,
			),
        ),
        'reward' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'Reward can not be blank.',
				'last'=>true,
			),
			'numeric'=>array(
				'rule' => 'numeric',
				'message' => 'Reward from must be numeric.',
				'last'=>true,
			),
			'minValue'=>array(
				'rule' => array('comparison', 'greater or equal', 1000),
				'message'=>'Reward value must be greater or equal to 1000',
				'last'=>true,
			),
        ),
        'industry' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'industry can not be blank.',
				'last'=>true,
			),
        ),
        'specification' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'specification can not be blank.',
				'last'=>true,
			),
        ),
        'state' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'state can not be blank.',
				'last'=>true,
			),
        ),
        'description' => array(
			'notEmpty'=> array(
				'rule'=>'notEmpty',
				'message'=>'description can not be blank.',
				'last'=>true,
			),
        ),
        'short_description' => array(
			'notEmpty'=> array(
				'rule' =>'notEmpty',
				'message'=>'short description can not be blank.',
				'last'=>true,
			),
        ),
		'salary_from' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'salary from can not be blank.',
				'last'=>true,
			),
			'numeric'=>array(
				'rule' => 'numeric',
				'message' => 'salary from must be numeric.',
				'last'=>true,
			),
			'minValue'=>array(
				'rule' => array('comparison', 'greater or equal', 1000),
				'message'=>'salary value must be greater or equal to 1000',
				'last'=>true,
			),
		),
		'salary_to' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'salary to can not be blank.',
				'last'=>true,
			),
			'numeric'=>array(
				'rule' => 'numeric',
				'message' => 'salary to must be numeric.',
				'last'=>true,
			),
			'minValue'=>array(
				'rule' => array('comparison', 'greater or equal', 1000),
				'message'=>'salary value must be greater or equal to 1000',
				'last'=>true,
			),
			'greaterEqualTo'=> array(
				'rule' => array('checkSalaryRange', 'salary_from' ), 
				'message' => 'salary to must be greater or equal to salary from',
				'last'=>true,
			)
		),

	);
	
	function checkSalaryRange( $field=array(), $compare_field=null ){
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];   
            if($v2 > $v1) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }
}
?>

