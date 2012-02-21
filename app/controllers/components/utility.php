<?php
class UtilityComponent extends Object
{
	var $controller = true;
	
	var $components = array('Session','Auth');
	
	function startup(&$controller)
	{

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
