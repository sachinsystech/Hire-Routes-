<?php
/* SVN FILE: $Id$ */
/**
 * The class to manage settings.
 * 
 * The class to manage settings of Bancer Control Panel
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

class SettingsController extends BcpAppController {

	public function index() {
		$this->_index();
		$this->set('oneColumnLayout', true);
	}

	public function view($id = null) {
		$this->_view($id);
	}

	public function add() {
		$this->_add();
	}

	public function edit($id = null) {
		$this->_edit($id);
		if($this->data['Setting']['setting'] == 'layout'){
			$values = $this->Setting->availableLayouts();
			$this->set(compact('values'));
		}
	}

	public function delete($id = null) {
		if($id == 1){
			$this->_flash(__('You cannot delete layout setting. It is imperative for Bancer Control Panel plugin.', true), 'error');
			$this->redirect(array('action'=>'index'));
		}else{
			$this->_delete($id);
		}
	}
}
?>