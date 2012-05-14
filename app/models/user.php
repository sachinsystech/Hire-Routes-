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
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'E-mail can not be blank.',
				'last'=>true,
			),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please provide a valid E-mail address.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This E-mail used by another user.'
            )
        ),
		'password' => array(
			'minLength'=> array(
				'rule' => array('minLength', 6),
				'message' => 'Password must be at least 6 characters long.'
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'Password can not be longer that 255 characters.'
			),
			'rule' => array('comparison', '!=', "1e8b5cf1bb9dd228c239af0ca92e4415149fefbb"),
			'message' => 'password can not be blank.'
		),
		'repeat_password' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Repeat Password can not be blank.',
				'last'=>true,
			),
			'minLength'=> array(
				'rule' => array('minLength', 6),
				'message' => 'Password must be at least 6 characters long.',
				'last'=>true,
			),
			'maxLength'=> array(
				'rule' => array('maxLength', 255),
				'message' => 'Password can not be longer that 255 characters.'
			),
			'equalTo'=> array(
				'rule' => array('checkpasswords', 'password' ), 
				'message' => 'You didn\'t enter same password twice, please re-enter.'
			)	
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
