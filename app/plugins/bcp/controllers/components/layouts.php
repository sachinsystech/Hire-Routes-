<?php
/* SVN FILE: $Id$ */
/**
 * Layouts component.
 *
 * Layouts component that allowes to choose the application's layout.
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

class LayoutsComponent extends Object{

	public $components = array('Session');

	public function initialize(&$controller) {
		$view_paths = App::path('views');
		array_unshift($view_paths, ROOT.DS.'plugins'.DS.'bcp'.DS.'views'.DS, APP.'plugins'.DS.'bcp'.DS.'views'.DS);
		App::build(array('views' => $view_paths));

		$controller->layout = $this->__setLayout();
	}

	private function __setLayout(){
		$layout = $this->Session->read('Settings.bcp.layout');
		if(empty($layout)){
			// Read the whole settings table
			$settings = ClassRegistry::init('Setting')->find('all');
			foreach($settings as $value){
				// Write each setting value from the database to session.
				$this->Session->write('Settings.'.$value['Setting']['category'].'.'.$value['Setting']['setting'], $value['Setting']['value']);
				if($value['Setting']['category'] == 'bcp' AND $value['Setting']['setting'] == 'layout'){
					$layout = $value['Setting']['value'];
				}
			}
		}
		return $layout;
	}
}
?>