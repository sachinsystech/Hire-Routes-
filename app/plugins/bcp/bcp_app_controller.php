<?php
/* SVN FILE: $Id$ */
/**
 * The parent class to all controllers of PoundCake Control Panel Plugin.
 *
 * This file is plugin-wide controller file. You can put all
 * plugin-wide controller-related methods here.
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

class BcpAppController extends AppController {

	public $components = array('Session', 'Bcp.AclCached', 'Auth', 'Security', 'Bcp.Filter', 'Bcp.DatabaseMenus', 'Bcp.Layouts');
	public $helpers = array('Session', 'Html', 'Form', 'Javascript', 'Bcp.DatabaseMenus');

	public function beforeFilter(){
		parent::beforeFilter();
		//Configure AuthComponent
		$this->Auth->authorize = 'actions';
		//$this->Auth->authError = __('You do not have permission to access the page you just selected.', true);
		$this->Auth->loginAction = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('plugin' => 'bcp', 'controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('plugin' => '', 'controller' => 'pages', 'action' => 'index');
		$this->Auth->autoRedirect = false; // Set to false in order to save last_login time
		$this->Auth->allow('logout'); // Allow logout to everybody
		$this->Auth->allow('changePassword'); // if the user is anonymous he should not be allowed to change password
	}

	public function beforeRender(){
		parent::beforeRender();
		$this->disableCache();
	}

	/**
	 * Default method for index() in the controllers
	 */
	protected function _index(){
		$this->{$this->modelClass}->recursive = 0;
		$filter = $this->Filter->process($this);
		$this->set('url', $this->Filter->url);
		$varNameForIndex = Inflector::variable($this->params['controller']);
		// Set the variable for the view file named the same as the current controller
		$this->set($varNameForIndex, $this->paginate(null, $filter));
	}

	/**
	 * Default method for view() in the controllers
	 * @param int $id
	 */
	protected function _view($id = null){
		$this->_checkIdPresence($id);
		/* Retrieve current controller name without 'Controller' word at the end
		 * and singularize it. */
		$varNameForView = Inflector::singularize($this->params['controller']);
		// Set variable for the view
		$this->set($varNameForView, $this->{$this->modelClass}->read(null, $id));
	}

	/**
	 * Default method for add() in the controllers
	 */
	protected function _add(){
		if(!empty($this->data)){
			$this->_createRow($this->data);
		}
	}

	/**
	 * Default method for edit() in the controllers
	 * @param int $id
	 */
	protected function _edit($id = null){
		if(!empty($this->data)){
			$this->_saveRow($this->data);
		}else{
			$this->_checkIdPresence($id);
			$this->data = $this->{$this->modelClass}->read(null, $id);
		}
	}

	/**
	 * Default method for delete() in the controllers
	 * @param int $id
	 */
	protected function _delete($id = null){
		$this->_checkIdPresence($id);
		if($this->{$this->modelClass}->delete($id)){
			$this->DatabaseMenus->clearCache();
			$this->_flash(__('The record has been deleted.', true), 'info');
			$this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * Save a new or update an existing record. Called from _edit() and from _createRow().
	 * @param array $data
	 * @param string $redirect - action to redirect after saving a record
	 */
	protected function _saveRow($data, $redirect = 'index'){

		$this->{$this->modelClass}->set($data);
		if($this->{$this->modelClass}->validates()){
			if($this->{$this->modelClass}->save($data)){
				$this->DatabaseMenus->clearCache();
				$this->_flash(__('The entry has been saved.', true), 'success');
				if($redirect != 'noredirect'){
					$this->redirect(array('action' => $redirect));
				}
			}else{
				$this->_flash(__('The entry could not be saved. Please, try again.', true), 'error');
			}
		}else{
			$this->_flash(__('The entry could not be saved. Correct invalid data.', true), 'error');
		}
	}

	/**
	 * Save a new record. Called from _add().
	 * @param array $data
	 * @param string $redirect - action to redirect after saving a record
	 */
	protected function _createRow($data, $redirect = 'index'){
		$this->{$this->modelClass}->create();
		$this->_saveRow($data, $redirect);
	}

	/**
	 * Verify that id is provided.
	 * @param int $id
	 * @param string $redirect. If 'noredirect' is provided then no redirection occurs if no id provided.
	 * @return unknown_type
	 */
	protected function _checkIdPresence($id = null, $redirect = 'index'){
		if(!$id){
			$this->_flash(__('Invalid request. No id has been provided.', true), 'error');
			if($redirect != 'noredirect'){
				$this->redirect(array('action' => $redirect));
			}
		}
	}

	/** 
	 * Multiple flash messages
	 * 
	 * @param string $message - Message to be displayed
	 * @param string $type - Message type (message, warning, error, success)
	 * @link http://mrphp.com.au/code/code-category/cakephp/cakephp-1-2/multiple-flash-messages-style-cakephp
	 */
	/* Examples:
	$this->_flash(__('Normal message.', true),'message');
	$this->_flash(__('Info message.', true),'info');
	$this->_flash(__('Success message.', true),'success');
	$this->_flash(__('Warning message.', true),'warning');
	$this->_flash(__('Error message.', true),'error');
	*/
	protected function _flash($message, $type = 'message'){
		$messages = (array)$this->Session->read('Message.multiFlash');
		$messages[] = array(
			'message' => $message,
			'element' => 'default',
			'params' => array('class' => 'multi-'.$type)
		);
		$this->Session->write('Message.multiFlash', $messages);
	}
}
?>
