<?php

return array(
    'controllers' => array(
        'factories' => array(
            'EfgCasAuth\Controller\Auth' => 'EfgCasAuth\Factory\Controller\AuthControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'logout',
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
