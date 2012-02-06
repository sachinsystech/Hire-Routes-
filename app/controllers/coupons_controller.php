<?php


class CouponsController extends AppController {

    var $uses = array('Coupon');

	function view() {
		$this->data['Coupon']['code'] = md5(rand()); 
		$this->Coupon->save($this->data['Coupon']);
		$coupon = $this->Coupon->find('all');
		$this->Session->setFlash('Coupon code added successfully.', 'success');				
		$this->set('coupon',$coupon);
	}

}
?>
