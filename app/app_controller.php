<?php
class AppController extends Controller{
var $components = array('Auth');
function beforeFilter(){
$this->Auth->authorize = 'controller';
$this->Auth->loginAction = array('controller'=>'users', 'action'=>'login');
$this->Auth->loginRedirect = array('controller'=>'users', 'action'=>'index');
$this->Auth->logoutRedirect = '/';
}
function isAuthorized(){
return true;
}
}
?>
