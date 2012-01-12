<?
class UsersController extends AppController {
	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth');


	function register() {
		if (!empty($this->data)) {
			if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
				$this->User->create();
				$this->User->save($this->data);
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function logout() {
		$this->Session->setFlash("You've successfully logged out.");
		$this->redirect($this->Auth->logout());
	}
	function login() {
	}

}
?>
