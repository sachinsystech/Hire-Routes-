<?php
class UserList extends AppModel {
    var $name = 'UserList';
    var $useTable = 'users';

    var $hasOne = array(
			'UserRoles' => array(
				'className' => 'UserRoles',
				'foreignKey' => 'user_id',
				'dependent'=> true
			),
			'Companies' => array(
				'className' => 'Companies',
				'foreignKey' => 'user_id',
				'dependent'=> true,
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

}

?>
