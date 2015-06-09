<?php
return array(
    'controllers' => array(
        'factories' => array(
            'EfgCasAuth\Controller\Auth' => function($controller) {
                $authController = new \EfgCasAuth\Controller\AuthController($controller->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
                return $authController;
            },
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
//                        '__NAMESPACE__' => 'EfgCasAuth\Controller',
                        'controller'    => 'EfgCasAuth\Controller\Auth',
                        'action'        => 'login',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            }
        )  
    ),
    'doctrine' => array(
        'driver' => array(
            'EfgCasAuth_Entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/EfgCasAuth/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'EfgCasAuth\Entity' => 'EfgCasAuth_Entities'
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'EfgCasAuth\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
            ),
        ),
    ),
    'doctrine_factories' => array(
        'authenticationadapter' => 'EfgCasAuth\Factory\Authentication\AdapterFactory',
    ),
    'cas' => array(
        'cas_version' => '2.0',
	'server_hostname' => 'servauth.univ-paris5.fr',
	'server_port' => 443,
	'server_path' => '/cas',
    ),
); 