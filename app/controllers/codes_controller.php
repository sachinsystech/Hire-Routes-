<?php
/*
Codes Controller ::
	1). Resposnible to restrict registration of users.
	2). Generating code that will be asked to enter when user signup.
*/

class CodesController extends AppController {
    var $uses = array('Code');
	var $helpers = array('Form');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->authorize = 'actions';
		$this->Auth->allow('add');
		$this->Auth->allow('delete');
		$this->layout = "admin";
	}
	
	/*	Display list of all codes and generate/add new code	*/
	function add() {
		if(isset($this->data['Code'])){
			$this->data['Code']['remianing_signups'] = $this->data['Code']['signups'];
			if($this->Code->save($this->data['Code'])){
				$this->Session->setFlash('Code has been added successfuly.', 'success');
				$this->redirect("/admin/codes");
			}
		}
		
		$conditions = array('Code.remianing_signups >'=>0);
		$this->paginate = array(
						    'conditions' => $conditions,
							'limit' => 10, // put display per page
						);
		$code = $this->paginate("Code");
		$codes = $this->set('codes',$code);
		$codeValue = $this->set('codeValue',$this->Code);
	}
	
	/*	Delete selected code	*/
	function delete(){
		$id = $this->params['id'];
		if($id){
			if(!$this->Code->delete($id)){
				$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
			}
			$this->Session->setFlash('Code has been deleted successfuly.', 'success');				
		}
		else{
			$this->Session->setFlash('You may be clicked on old link or entered menualy.', 'error');				
		}
		$this->redirect("/admin/codes");
	}

}
?>
