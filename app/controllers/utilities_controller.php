<?php 
/**
 * UtilityController
 */
class UtilitiesController extends AppController {
    var $uses = array('Specification','State','City','Industry');

/**
 * get list cities of a specific state
 */
	public function getCitiesOfState()
	{
		$this->autoRender= false ;
		$cities=$this->State->find('list',array(
			'fields'=>array(
				'City.id',
				'City.city'
			),
			'recursive'=>-1,
			'joins' => array(
			    array(
			        'table' => 'cities',
			        'alias' => 'City',
			        'type' => 'inner',
			        'foreignKey' => false,
			        'conditions'=> array('City.state_code = State.state_code')
			    )
			),
			'conditions'=>array(
					'State.id'=>$this->params['state_id']
				)
			)
		);

		$cities=json_encode($cities);
		return $cities;
	}
}
?>
