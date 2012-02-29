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
         'expiration_date' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Card No. can not be left blank.'
			),
			'date'=> array(
				'rule' => 'date',
				'message' => 'Please provide valid Expiration Date.'
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
		),
		'email' => array(
                    'email' => array(
                	'rule' => 'email',
                	'message' => 'Please provide a valid email address.'
            ),            
        ),
	);


}

?>
