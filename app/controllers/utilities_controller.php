<?php 
/**
 * UtilityController
 */
class UtilitiesController extends AppController {
    var $uses = array('IndustrySpecification','Specification','State','City','Industry');

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

/**
 *get list of specifications of a given Industry
 */
	public function getSpecificationOfIndustry()
	{
		$this->autoRender= false ;
		$specifications=$this->IndustrySpecification->find('list',array(
			'fields'=>array(
				'Specification.id',
				'Specification.name'
			),
			'recursive'=>-1,
			'joins' => array(
			    array(
			        'table' => 'specification',
			        'alias' => 'Specification',
			        'type' => 'inner',
			        'foreignKey' => false,
			        'conditions'=> array('Specification.id = IndustrySpecification.specification_id')
			    )
			),
			'conditions'=>array(
					'IndustrySpecification.industry_id'=>array(0,$this->params['industry_id'])
				)
			)
		);		
		$specifications=json_encode($specifications);
		return $specifications;
	}
}
?>
