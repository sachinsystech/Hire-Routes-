<?php
/* SVN FILE: $Id$ */
/**
 * The class to manage groups of users.
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

class GroupsController extends BcpAppController {

	public $components = array('ControlPanel', 'AclCached');

	public function index(){
		$groupNames = $this->Group->find('list', array('fields' => array('Group.name')));
		$this->set('tree', $this->ControlPanel->tree($groupNames));
	}

	public function view($id = null){
		$this->_view($id);
		// Get actions menu for users controller to be used in 'related' div in the view
		$usersActionsMenu = $this->DatabaseMenus->getMenu('actions', 'Users');
		$usersExtraMenu = $this->DatabaseMenus->getMenu('extra', 'Users');
		// For the parent group
		$parent = $this->Group->findParentDetails($this->Group->data['Group']['parent_id']);
		$this->set(compact('usersExtraMenu', 'usersActionsMenu', 'parent'));
	}

	public function add(){
		$this->_add();
		// For the parent group
		$this->set('parents', $this->Group->find('list'));
	}

	public function edit($id = null) {
		$this->_edit($id);
		// For the parent group
		$this->set('parents', $this->Group->find('list'));
	}

	public function delete($id = null) {
		$this->_delete($id);
	}

	public function permissions($id = null){
		$this->_checkIdPresence($id);
		if(!empty($this->data)){
			foreach($this->data['Acos'] as $aco){
				if(!empty($aco['permission'])){
					$do = '';
					if($aco['permission'] == '1'){
						$do = 'allow';
					}elseif($aco['permission'] == '-1'){
						$do = 'deny';
					}
					$aroNode = array('model' => 'Group', 'foreign_key' => $this->data['Group']['id']);
					$acoNode = array('model' => $aco['model'], 'foreign_key' => $aco['foreign_key']);
					// Save allow or deny permission
					if($this->AclCached->{$do}($aroNode, $acoNode)){
						$message = sprintf(__('<i>%s</i> permission to <i>%s</i> has been saved.', true), ucfirst($do), $aco['name']);
						$this->_flash($message, 'success');
					}else{
						$message = sprintf(
							__('<i>%s</i> permission to <i>%s</i> could not be saved. Please, try again.', true),
							ucfirst($do), $aco['name']
						);
						$this->_flash($message, 'error');
					}
				}
			}
		}
		// Get ARO for the current Group and all related ACOs from the db
		$this->data = $this->Group->read(null, $id);
		$acosTree = $this->ControlPanel->checkPermissions($id);
		$existingPermissions = $this->ControlPanel->findRecordedPermissions($id);
		$this->set(compact('acosTree', 'existingPermissions'));
	}
}
?>