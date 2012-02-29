<?php

class User extends AppModel {
    var $name = 'User';
    var $useTable = 'users';
    var $actsAs = array('Acl' => array('requester'));
 
	function parentNode() {
		if (!$this->id && empty($this->data)) {
		    return null;
		}
		$data = $this->data;
		if (empty($this->data)) {
		    $data = $this->read();
		}
		if (!$data['User']['group_id']) {
		    return null;
		} else {
		    return array('Group' => array('id' => $data['User']['group_id']));
		}
	}
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
				'message' => 'Password can not be longer that 255 characters.'
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
            if(Security::hash(Configure::read('Security.salt') . $v1) !== $v2) {
               unset($this->data[$this->name][ $compare_field ]);
               unset($this->data[$this->name][ $key]);
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    } 
}

?>
