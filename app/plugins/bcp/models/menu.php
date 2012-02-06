<?php
/* SVN FILE: $Id$ */
/**
 * Menus table model class.
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

class Menu extends BcpAppModel {

	public $actsAs = array(
		'Acl' => array('type' => 'controlled'),
	);
	public $validate = array(
		'id' => array('numeric'),
		'type' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255)
			),
			'inList' => array(
				'rule' => array('inList', array('main', 'extra', 'actions', 'manual'))
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255)
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			),
		),
		'parent_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => false
			),
		),
		'plugin' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 100)
			),
		),
		'controller' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 100)
			),
		),
		'method' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 100)
			),
		),
		'published' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => false
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Parent' => array(
			'className' => 'Bcp.Menu',
			'foreignKey' => 'parent_id',
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
		if(empty($this->data)){
			$data = $this->read();
		}
		if(!$data['Menu']['parent_id']){
			return null;
		}else{
			if(!empty($data['Menu']['method'])){
				$alias = $data['Menu']['method'];
			}elseif(!empty($data['Menu']['controller'])){
				$alias = $data['Menu']['controller'];
			}elseif(!empty($data['Menu']['plugin'])){
				$alias = $data['Menu']['plugin'];
			}
			return array('Menu' => array('id' => $data['Menu']['parent_id'], 'alias' => $alias));
		}
	}

	/*
	 * After save callback
	 *
	 * Update the aco for the menu item.
	 *
	 * @access public
	 * @return void
	 */
	public function afterSave($created){
		$data = $this->parentNode();
		$parent = $this->node($data);
		$node = $this->node();
		$aco = $node[0];
		$aco['Aco']['parent_id'] = $parent[0]['Aco']['id'];
		$aco['Aco']['alias'] = $data['Menu']['alias'];
		$this->Aco->save($aco);

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
}
?>