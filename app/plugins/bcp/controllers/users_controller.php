<?php
/* SVN FILE: $Id$ */
/**
 * The class to manage users.
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

class UsersController extends BcpAppController {

	public $components = array('ControlPanel');
	
	function beforeRender(){
		parent::beforeRender();
		// Ensure that encrypted passwords are not sent back to the user
		unset($this->data['User']['password']);
		unset($this->data['User']['confirm_password']);
	}

	public function index(){
		$this->_index();
	}

	public function view($id = null){
		$this->_view($id);
	}

	public function add(){
		$this->_add();
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function edit($id = null){
		if(!empty($this->data)){
			// If no password is supplied, we don't change it
			if(trim($this->data['User']['password']) == Security::hash('', null, true)){
				unset($this->data['User']['password']);
				unset($this->data['User']['confirm_password']);
			}
			$this->_saveRow($this->data);
		}else{
			$this->_checkIdPresence($id);
			$this->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function delete($id = null){
		$this->_delete($id);
	}

	public function login(){
		// If a user is not authenticated then login him as anonymous visitor
		if(!$this->Auth->user()){ 
			if($this->User->find('first', array('conditions' => array('User.account_email' => 'admin', 'User.password' => 'admin')))){
				$data = array('User' => array('account_email' => 'admin', 'password' => 'admin'));
				$this->_flash(__('You must change admin password for security reasons right now.', true), 'warning');
				$this->Auth->authError = '';
				$this->Auth->loginRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'changePassword');
			}else{
				$data = array('User' => array('account_email' => 'anonymous', 'password' => 'anonymous'));
			}
			$this->Auth->login($data);  
		}
		// If the user is authenticated then record the login time
		if($this->Auth->user()){
			$id = $this->Auth->user('id');
			// Save login time
			$this->User->lastLogin($id);
			// If the login was not called by pressing a login link then redirect
			if(!isset($this->params['url']['requestedByUser'])){
				$this->redirect($this->Auth->loginRedirect);
			}
		}

	}

	/**
	 * Alternative login function for projects where unauthorized users are allowed to access only login page.
	 */
	public function no_guest_login(){
		if(!$this->Auth->user()){
			if($this->User->find('first', array('conditions' => array('User.account_email' => 'admin', 'User.password' => 'admin')))){
				$this->data = array('User' => array('account_email' => 'admin', 'password' => 'admin'));
				$this->_flash(__('You must change admin password for security reasons right now.', true), 'warning');
				$this->Auth->authError = '';
				//$this->Auth->allow('changePassword');
				$this->Auth->loginRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'changePassword');
			}
			$this->Auth->login($this->data);
		}
		// If the user is authenticated then record the login time
		if($this->Auth->user()){
			$id = $this->Auth->user('id');
			// Save login time
			$this->User->lastLogin($id);
			// If the login was not called by pressing a login link then redirect
			if(!isset($this->params['url']['requestedByUser'])){
				$this->redirect($this->Auth->loginRedirect);
			}
		}
	}

	public function logout(){
		$this->_flash(__('You have been logged out.', true), 'success');
		// Logout and Redirect to login page
		$this->redirect($this->Auth->logout());
	}

	public function changePassword(){
		if(!empty($this->data)){
			$this->_saveRow($this->data);
		}else{
			$this->data = $this->Auth->user();
			$this->render("change_password");
		}
		
	}

	public function permissions($id = null){
		$this->_checkIdPresence($id);
		if(!empty($this->data)){
			$aroNode = array('model' => 'User', 'foreign_key' => $this->data['User']['id']);
			foreach($this->data['Acos'] as $aco){
				if(!empty($aco['permission'])){
					$do = '';
					if($aco['permission'] == '1'){
						$do = 'allow';
					}elseif($aco['permission'] == '-1'){
						$do = 'deny';
					}
					$acoNode = array('model' => $aco['model'], 'foreign_key' => $aco['foreign_key']);
					if($this->Acl->{$do}($aroNode, $acoNode, '*')){
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
		$this->data = $this->User->read(null, $id);
		$acosTree = $this->ControlPanel->checkPermissions($id);
		$existingPermissions = $this->ControlPanel->findRecordedPermissions($id);
		$this->set(compact('acosTree', 'existingPermissions'));
	}

	public function verifyTree(){
		$treeErrors = array();
		$errors = $this->Acl->Aro->verify();
		if(is_array($errors)){
			foreach($errors as &$error){
				if($error[0] == 'index'){
					$error['message'] = $error[2].' left/right '.$error[0].' '.$error[1];
				}else{
					$error['message'] = $error[2];
				}
			}
		}else{ // If no tree errors have been found redirect to index page.
			$this->_flash(__('No errors have been found.', true), 'info');
			$this->redirect(array('action'=>'index'));
		}
		$this->set(compact('treeErrors', 'errors'));
	}

	public function recover(){
		if($this->Acl->Aro->recover()){
			$this->_flash(__('The tree has been recovered.', true), 'success');
			$this->redirect(array('action' => 'index'));
		}else{
			$this->_flash(__('The tree could not be recovered. Please, try again.', true), 'error');
			$this->redirect(array('action' => 'verifyTree'));
		}
	}

	public function tree(){
		$aros = array();
		$aros['User'] = $this->User->find('list', array('fields' => array('User.account_email')));
		$aros['Group'] = $this->User->Group->find('list');
		$aclTree = $this->Acl->Aro->generatetreelist(
			null,
			array('{1}:{0}', '{n}.Aro.foreign_key', '{n}.Aro.model'),
			" ",
			'&middot;&nbsp;&nbsp;&nbsp;'
		);
		$tree = array();
		foreach($aclTree as $id => $node){
			$modelAndForeignKey = explode(":", $id);
			$tree[$id]['Aco']['id'] = $modelAndForeignKey[1];;
			$tree[$id]['Aco']['model'] = $modelAndForeignKey[0];
			$tree[$id]['Aco']['name'] = $node.$aros[$modelAndForeignKey[0]][$modelAndForeignKey[1]];
		}
		$groupActionsMenu = $this->DatabaseMenus->getMenu('actions', 'Groups');
		$this->set(compact('tree', 'groupActionsMenu'));
	}
}
?>
