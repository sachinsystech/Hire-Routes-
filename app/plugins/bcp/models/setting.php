<?php
/* SVN FILE: $Id$ */
/**
 * Settings table model class.
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

class Setting extends AppModel {

	public $order = array('category' , 'name');

	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
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
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			)
		),
		'category' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255)
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			),
		),
		'setting' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255)
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			),
			'alphaNumericDashDotUnderscore' => array(
				'rule' => 'alphaNumericDashDotUnderscore',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			),
		),
		'value' => array(
			'allowedValue' => array(
				'rule' => '_allowedValue' // Protected function below
			),
		),
	);

	/**
	 * Method used to validate the value of the setting.
	 * 
	 * @return boolean
	 */
	protected function _allowedValue(){
		/* If that is a layout setting only filename values without extention that are available in
		 * the layouts directroies are valid */
		if(isset($this->data['Setting']['setting']) AND $this->data['Setting']['setting'] == 'layout'){
			$layouts = $this->availableLayouts();
			// If submitted value has no corresponding layout file
			if(!in_array($this->data['Setting']['value'], $layouts)){
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to find all layouts from respective directories
	 * 
	 * @return array - List of available layouts
	 */
	public function availableLayouts(){
		// Read filenames from cake libs layout directry
		$coreLayouts = scandir('..'.DS.'..'.DS.LIBS.'view'.DS.'layouts'.DS);
		// Read filenames from app layout directry
		$appLayouts = scandir(LAYOUTS);
		// Read filenames from BCP plugin layout directry
		if(is_dir(APP.'plugins'.DS.'bcp'.DS.'views'.DS.'layouts'.DS)){
			$bcpLayouts = scandir(APP.'plugins'.DS.'bcp'.DS.'views'.DS.'layouts'.DS);
		}elseif(is_dir(ROOT.DS.'plugins'.DS.'bcp'.DS.'views'.DS.'layouts'.DS)){
			$bcpLayouts = scandir(ROOT.DS.'plugins'.DS.'bcp'.DS.'views'.DS.'layouts'.DS);
		}else{
			$bcpLayouts = array();
		}
		$layouts = array_merge($coreLayouts, $appLayouts, $bcpLayouts);
		foreach($layouts as $key => &$file){
			$position = strpos($file, '.ctp'); // Find the position of '.ctp' in the filename
			if($position === false){ // If '.ctp' was not found in the filename then unset the filename
				unset($layouts[$key]);
			}else{
				$file = substr($file, 0, $position); // Truncate the filename by '.ctp'
			}
		}
		sort($layouts);
		// Create associative array with keys equal to values
		$layouts = array_combine($layouts, $layouts);
		return $layouts;
	}

	function alphaNumericDashDotUnderscore($check) {
		// $data array is passed using the form field name as the key
		// have to extract the value to make the function generic
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|^[0-9a-zA-Z_\.-]*$|', $value);
	}

	public function afterSave(){
		// Destroy settings session array in order the settings to be refreshed. That will not work if sessions are stored in the DB.
		unset($_SESSION['Settings']);
	}
}
?>