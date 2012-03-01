<?php 
class BaseModelComponent extends Object {
 
	var $uses = false;
 
	function initialize(&$controller) {
 
		//load required for component models
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}
 
	}
 
}
?>


