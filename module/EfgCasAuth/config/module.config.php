<?php
return array(
    'controllers' => array(
        'factories' => array(
            'EfgCasAuth\Controller\Auth'    => 'EfgCasAuth\Factory\Controller\AuthControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller'    => 'EfgCasAuth\Controller\Auth',
                        'action'        => 'login',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => 'EfgCasAuth\Factory\Service\AuthDoctrineORMServiceFactory',
        )  
    ),
    'doctrine_factories' => array(
        'authenticationadapter' => 'EfgCasAuth\Factory\Authentication\AdapterFactory',
    ),
); 