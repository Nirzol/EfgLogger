<?php

// Modify with your own configuration
return array(  
    'cas' => array(
        'cas_version' => '2.0',//'CAS_VERSION_2_0',
	'cas_hostname' => 'servauth.univ-paris5.fr',
	'cas_port' => 443,
	'cas_path' => '/cas',
        'no_account_route' => 'user/add-auto',
        'cas_server_ca_cert_path' => dirname(dirname(__DIR__)) . '/data/certificat_P5_cas.pem',
        'cas_proxy' => true,
        'cas_imap_name' => 'imap-i.infr.univ-paris5.fr', //'imap.univ-paris5.fr:993',
        'cas_imap_password' => '',
        'cas_pgt_dir' => dirname(dirname(__DIR__)) . '/data/',
        'cas_debug_file' => dirname(dirname(__DIR__)) . '/data/cas_debug.log',
        'cas_debug' => true,
        'cas_validation' => 'ca',
        'cas_login_url' => '',
        'cas_logout_url' => '',
        'cas_redirect_route_after_login' => 'home',
    ),
    'get_form' => array(
        'user_form' => 'Ent\Form\UserForm',        
    ),
    'doctrine' => array(
        'user_doctrine_orm_service_factory' => 'Ent\Service\UserDoctrineORM',
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Ent\Entity\EntUser',
                'identity_property' => 'userLogin',
                'credential_property' => 'userPassword',
//                'credential_callable' => function(Ent\Entity\EntUser $user, $passwordGiven) {
//                    // using Bcrypt 
//                    $bcrypt = new \Zend\Crypt\Password\Bcrypt();
//                    $bcrypt->setSalt('m3s3Cr3tS4lty34h');
//                    // $passwordGiven is unhashed password that inputted by user
//                    // $user->getPassword() is hashed password that saved in db
//                    return $bcrypt->verify($passwordGiven, $user->getUserPassword());
//                },
            ),
        ),
    ), 
);
