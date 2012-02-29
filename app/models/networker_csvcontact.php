<?php

class NetworkerCsvcontact extends AppModel {
    var $name = 'NetworkerCsvcontact';
    var $useTable = 'networker_contacts';
    var $validate = array(
		'contact_email' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This E-mail already exist.'
            )
        )
    );
    
}

?>
