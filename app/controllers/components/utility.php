<?php

class UtilityComponent extends Object
{
	var $controller = true;
	var $components = array('Session','Auth');
	var $uses = array('Industry','State','City','Specification','FacebookUsers','Companies');
	
	function initialize(&$controller) {
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}		
	}

	function startup(&$controller){

	}
	
	function getIndustry(){
		return $this->Industry->find('list', array('fields' => array('Industry.name')));
	}
	
	function getState(){
		return $this->State->find('list', array('fields' => array('State.state')));
	}
	
	function getCity(){
		$params = array(
					   'conditions' => array('City.state_code'=>'DE'), 
					   'fields' => array('City.city','City.city') 
					   );
 
		return $this->City->find('list',$params);
	}

	function getCities(){
		return $this->City->find('list', array('fields' => array('City.city')));
	}
	
	function getSpecification(){
		return $this->Specification->find('list', array('fields' => array('Specification.name')));
	}

	function getCompany($by = null){
		if($by=='url'){
			$by = 'company_url';
			return $this->Companies->find('list', array('fields' => array("Companies.$by")));
		}
		else{
			return $this->Companies->find('list', array('fields' => array("Companies.id","Companies.company_name")));
		}
	}
	
	function objectToKeyValueArray($objectArray, $key, $value, $modelName){
		$object_to_key_value_array = array();
		foreach($objectArray as $ob){
			$object_to_key_value_array[$ob[$modelName][$key]] = $ob[$modelName][$value];
		}		
		return $object_to_key_value_array;
	}
}
?>
