<?php

class PaymentInfo extends AppModel {
    var $name = 'PaymentInfo';
    var $useTable = 'payment_info';
	var $validate = array(
		
		'card_type' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Card Type can not be blank.'
			),			
		),
		'card_no' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Card No. can not be left blank.'
			),
		     'cc'=> array(
				'rule' => 'cc',
				'message' => 'Please provide valid Card No.'
			),			
		),
        'expiration_month' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Please select Expiry date'
			),						
		),
		'expiration_year' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Card No. can not be left blank.'
			),
			'rule' => array('datevalid', 'expiration_month' ), 
			'message' => 'Expiry date should be greater than current date.'						
		),
		'ccv_code' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "CCV Code can not be blank."
			),			
		),
		'cardholder_name' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => "Card Holder's name can not be blank."
			),			
		),
		'address' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Address can not be blank.'
			),			
		),
		'city' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'City can not be blank.'
			),			
		),
		'state' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'State can not be blank.'
			),			
		),
		'country' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Country can not be blank.'
			),			
		),
		'zip' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Zipcode can not be blank.'
			),			
		)
	);

	function datevalid($field=array(), $month_field=null ) {
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][ $month_field ];
            $todate  = date('Y-m-d');
		    $day     = date('d'); 
		    $expdate = date('Y-m-d',strtotime($v1."-".$v2."-".$day));
            if($todate>=$expdate){
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    } 


}

?>
