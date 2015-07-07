<?php
// Modify with your own configuration
return array(  
    'cas' => array(
        'cas_version' => '2.0',
	'server_hostname' => 'servauth.univ-paris5.fr',
	'server_port' => 443,
	'server_path' => '/cas',
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Ent\Entity\EntUser',
                'identity_property' => 'userLogin',
                'credential_property' => 'password',
            ),
        ),
    ), 

);
