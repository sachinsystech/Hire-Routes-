<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {

	function validateUnique($value, $params = array())
	{
		if(isset($params['field'])){		
		
			$conditions = array($params['field'] => $value);
			if(!empty($this->id)) {
				$conditions = Set::merge($conditions, array($this->name.'.'.$this->primaryKey => '!= '.$this->id));
			}
			return !$this->hasAny($conditions);
		}
	}

	public function paginateCount($conditions = null, $recursive = 0, $extra = array())
	{
		if(isset($extra['myCount']))
		{
			$count = $extra['myCount'];
			unset($extra['myCount']);
			return $count;
		}
		$parameters = compact('conditions', 'recursive');
	    if (isset($extra['group']))
	    {
	    	$cond=null;
	    	if(isset($extra['joins'])){
	    		foreach($extra['joins'] as $key => $join){
	    			if(strtoupper($join['type'])=='INNER'){
	    				$cond['joins'][]=$extra['joins'][$key];
	    			}
	    		}
	    	}
			if(!empty($cond))
				$count = $this->find('count', array_merge($parameters,$cond));
			else
				$count = $this->find('count', $parameters);
	    }
	    else
	    {
			$count = $this->find('count', array_merge($parameters, $extra));
	    }
	    return $count;
	}

}
