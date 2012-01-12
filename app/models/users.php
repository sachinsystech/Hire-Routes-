<?php

class Users extends AppModel {
    var $name = 'Users';
    var $useTable = 'users';
    var $hasMany = array(
			'UserRoles' => array(
				'className' => 'UserRoles',
				'foreignKey' => 'user_id',
				'dependent'=> true
			),
			'Companies' => array(
				'className' => 'Companies',
				'foreignKey' => 'user_id',
				'dependent'=> true
			),
			'Jobseekers' => array(
				'className' => 'Jobseekers',
				'foreignKey' => 'user_id',
				'dependent'=> true
			),						
			'Networkers' => array(
				'className' => 'Networkers',
				'foreignKey' => 'user_id',
				'dependent'=> true
			),						
	);
	
    var $validate = array(
		'account_email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Please provide a valid email address.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This E-mail used by another user.'
            )
        ),
		'password' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Name can not be blank.'
			),
			'minLength'=> array(
				'rule' => array('minLength', 6),
				'message' => 'Password must be at least 6 characters long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'Name can not be longer that 255 characters.'
			)
		),
		'repeat_password' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Name can not be blank.'
			),
			'rule' => array('checkpasswords', 'password' ), 
			'message' => 'You didn\'t enter same password twice, please re-enter.'
		),

	);

	function checkpasswords( $field=array(), $compare_field=null ) 
    {
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];                 
            if($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    } 
}

?>
