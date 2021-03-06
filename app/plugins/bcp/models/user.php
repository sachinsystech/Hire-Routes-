<?php
/* SVN FILE: $Id$ */
/**
 * Users table model class.
 *
 * PHP version 5
 * 
 * (C) Copyright 2009, Valerij Bancer (http://bancer.sourceforge.net)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author        Valerij Bancer
 * @link          http://www.bancer.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class User extends BcpAppModel {

	public $actsAs = array('Acl' => array('requester'));

	public $validate = array(
		'id' => array('numeric'),
		'account_email' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true
			),
			'between' => array(
				'rule' => array('between', 5, 30)
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			),
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', '8')
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			)
		),
		'confirm_password' => array(
			'minLength' => array(
				'rule' => array('minLength', '8'),
				'required' => true
			),
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'comparePasswords' => array(
				'rule' => 'comparePasswords' // Protected function below
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true
			))
	);

	public $belongsTo = array(
		'Group' => array(
			'className' => 'Bcp.Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function parentNode(){
		if(!$this->id && empty($this->data)){
			return null;
		}
		$data = $this->data;
		if(empty($this->data) OR !isset($data['User']['group_id'])){
			$data = $this->read();
		}
		if(empty($data['User']['group_id'])) {
			return null;
		}else{
			return array('Group' => array('id' => $data['User']['group_id']));
		}
	}

	/**
	 * After save callback
	 *
	 * Update the aro for the user.
	 *
	 * @access public
	 * @return void
	 */
	function afterSave($created) {
		if($created){
			// It is a creation
			$id = $this->getLastInsertID();
			$aro = new Aro();
			$aro->updateAll(
				array('alias' => '\'User:'.$id.'\''),
				array('Aro.model' => 'User', 'Aro.foreign_key' => $id)
			);
		}else{
			$parent = $this->parentNode();
			$parent = $this->node($parent);
			$node = $this->node();
			$aro = $node[0];
			$aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
			$this->Aro->save($aro);
		}
		// Clear menus cache
		App::import('Component', 'DatabaseMenus');
		$databaseMenus = new DatabaseMenusComponent();
		$databaseMenus->clearCache();
		// Clear permissions cache
		App::import('Component', 'AclCached');
		$aclCache = new AclCachedComponent();
		$aclCache->clearCache();
	}

	public function afterDelete(){
		// Clear menus cache
		App::import('Component', 'DatabaseMenus');
		$databaseMenus = new DatabaseMenusComponent();
		$databaseMenus->clearCache();
		// Clear permissions cache
		App::import('Component', 'AclCached');
		$aclCache = new AclCachedComponent();
		$aclCache->clearCache();
	}

	/**
	 * Method used to validate password fields in the comparePasswords validation rule.
	 * 
	 * @return unknown_type
	 */
	protected function comparePasswords($field = null){
		return (Security::hash($field['confirm_password'], null, true) === $this->data['User']['password']);
	}

	/**
	 * Method to save login time
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	function lastLogin($id){
		$this->id = $id;
		$this->saveField('last_login', date('Y-m-d H:i:s'));
	}
}
?>
