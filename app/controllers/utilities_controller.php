<?php 
/**
 * UtilityController
 */
class UtilitiesController extends AppController {
    var $uses = array('IndustrySpecification','Specification','State','City','Industry','University','GraduateDegree','NetworkerContacts');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('getCitiesOfState');
		$this->Auth->allow('getSpecificationOfIndustry');
		$this->Auth->allow('getUniversities');
		$this->Auth->allow('getGraduateDegrees');
		$this->Auth->allow('getGraduateUniversities');
		$this->Auth->allow('networkerContacts');
	}

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
	
	public function getUniversities(){
		$this->autoRender= false ;
		$universities=$this->University->find('list',array('fields'=>'id, name', 'order'=>'id','conditions'=>array('name like '=>$this->params['named']['startWith']."%")));
		$univs=null;
		if( $universities != null ){
			foreach($universities as $id=>$name){
				$univs[]=array('id'=>$id,'name'=>$name);
			}
			$universities=json_encode($univs);
		}else{
			/*$universities = $this->University->find('list',array('fields'=>'id, name', 'order'=>'id','conditions'=>array('name like '=>"other%")));
		$univs=null;
			if( $universities != null ){
				foreach($universities as $id=>$name){
					$univs[]=array('id'=>$id,'name'=>$name);
				}
			*/		
			$univs[]=array('id'=>0,'university_name'=>"Our humble apologies that your university is not on the list.  We'll be updating our database soon!  Please select Other for now.");
			$universities=json_encode($univs);
		}
		return $universities;
	}
	
	public function getGraduateDegrees(){
		$this->autoRender= false ;
		//$GraduateDegrees=$this->GraduateDegree->find('list',array('fields'=>'id,degree', 'order'=>'id'));
		$GraduateDegree=$this->GraduateDegree->find('list',array('fields'=>'id,degree', 'order'=>'id','conditions'=>array('degree like '=>$this->params['named']['startWith']."%")));
		$Degree=null;
		foreach($GraduateDegree as $id=>$name){
			$Degree[]=array('id'=>$id,'name'=>$name);
		}
		$GraduateDegree=json_encode($Degree);
		return $GraduateDegree;

	}
	
	function getGraduateUniversities(){
	    $this->autoRender= false ;
	    $degreeId = $this->params['named']['degree_id'];
	    
	    $universities=$this->GraduateUniversityBreakdown->find('list',array('conditions'=>array("degree_type"=>$degreeId, "graduate_college like "=>$this->params['named']['startWith']."%"),
																		    'fields'=>'id, graduate_college',
																		    'order'=>'id'));
	    if( $universities != null){ 
		    foreach($universities as $id=>$name){
			    $universitiesdata[]=array('id'=>$id,'name'=>$name);
		    }
		    $graduateUniversities=json_encode($universitiesdata);
	    }else{
		    /*$universities=$this->GraduateUniversityBreakdown->find('list',array('conditions'=>
		    																array("degree_type"=>$degreeId, 																				"graduate_college like "=>"other%"),
																		'fields'=>'id, graduate_college',
																		'order'=>'id'));
																					
		    if( $universities != null){ 
			    foreach($universities as $id=>$name){
				    $universitiesdata[]=array('id'=>$id,'name'=>$name);
			    }
			*/
			$universitiesdata[]=array('id'=>0,'university_name'=>"Our humble apologies that your university is not on the list.  We'll be updating our database soon!  Please select Other for now.");
			$graduateUniversities=json_encode($universitiesdata);
		}
	    return $graduateUniversities;
	}
	
	function networkerContacts(){
	    $this->autoRender= false ;
	    $userId = $this->Session->read("UserId");
	    $emails = $this->NetworkerContacts->find('list',array('conditions'=>array("user_id"=>$userId, "contact_email like "=>$this->params['named']['startWith']."%"),
								'fields'=>'id, contact_email',
		    						'order'=>'id'));
	    if( $emails != null){ 
		foreach($emails as $id=>$name){
			$emailData[]=array('id'=>$id,'user_name'=>$name);
		}
		$emails=json_encode($emailData);
	    }else
		$emails=json_encode(array());
	    return $emails;
	    
	}
	
}
?>
