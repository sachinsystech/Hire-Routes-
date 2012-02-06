<?php
/* SVN FILE: $Id$ */
/**
 * ControlPanel class.
 *
 * The class with useful functions for different controllers of control panel.
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

class ControlPanelComponent extends Object{

	public $components = array('Bcp.AclCached');

	// Called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// Saving the controller reference for later use
		$this->controller =& $controller;
	}

	/**
	 * Build a tree list of ACOs or AROs. Used by GroupsController and MenusController.
	 * @param array $names - list of groups or menu names
	 */
	public function tree($names){
		$aclType = 'Aro'; // By default generate AROs tree
		if($this->controller->modelClass == 'Menu'){
			$aclType = 'Aco';
		}
		// Generate AROs or ACOs tree list
		$aclTree = $this->AclCached->{$aclType}->generatetreelist(
			array($aclType.'.model' => $this->controller->modelClass),
			"{n}.".$aclType.".foreign_key",
			" ",
			'&middot;&nbsp;&nbsp;&nbsp;'
		);
		// Format names tree
		$tree = array();
		foreach($aclTree as $id => $node){
			$tree[$id][$this->controller->modelClass]['id'] = $id;
			$tree[$id][$this->controller->modelClass]['name'] = $node.$names[$id];
		}
		return $tree;
	}

	/**
	 * Build permissions tree list for the ARO specified by provided id.
	 * @param int $id - ARO id
	 */
	public function checkPermissions($id){
		$menuNames = ClassRegistry::init('Menu')->find('list', array('fields' => array('Menu.name')));
		$tree = $this->AclCached->Aco->generatetreelist(
			null,
			"{n}.Aco.id",
			array(':{2}:{1}:{0}', '{n}.Aco.alias', '{n}.Aco.foreign_key', '{n}.Aco.model'),
			'&middot;&nbsp;&nbsp;&nbsp;'
		);
		foreach($tree as &$node){
			$node = explode(":", $node);
			$node['name'] = $node[0].$menuNames[$node[2]];
			$allowed = $this->AclCached->check(
				array('model' => $this->controller->modelClass, 'foreign_key' => $id),
				array('model' => $node[1], 'foreign_key' => $node[2])
			);
			$node['allowed'] = (int) $allowed;
		}
		return $tree;
	}

	/**
	 * Find permissions from acos_aros table
	 * @param int $id - ARO id
	 * @return a list of permissions from acos_aros table related to the ARO specified by provided id
	 */
	public function findRecordedPermissions($id){
		$permissions = $this->AclCached->Aro->find('all', array(
			'conditions' => array(
				'Aro.foreign_key' => $id,
				'Aro.model' => $this->controller->modelClass
			)
		));
		$existingPermissions = array();
		foreach($permissions[0]['Aco'] as $aco){
			if(
				($aco['Permission']['_create'] == 1) &&
				($aco['Permission']['_read'] == 1) &&
				($aco['Permission']['_update'] == 1) &&
				($aco['Permission']['_delete'] == 1)
			){
				$existingPermissions[$aco['Permission']['aco_id']] = 1;
			}
			elseif(
				($aco['Permission']['_create'] == -1) &&
				($aco['Permission']['_read'] == -1) &&
				($aco['Permission']['_update'] == -1) &&
				($aco['Permission']['_delete'] == -1)
			){
				$existingPermissions[$aco['Permission']['aco_id']] = -1;
			}
		}
		return $existingPermissions;
	}
}
?>