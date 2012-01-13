<?php

class CompanyRecruiter extends AppModel {
    var $name = 'CompanyRecruiter';
    var $useTable = null;
	
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
	
		'agree_condition' => array(
         	    'rule' => array('comparison', '!=', 0),
                'required' => true,
                'message' => 'You must agree to the Terms and Conditions.'
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
