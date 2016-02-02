<?php

return array(
    'controllers' => array(
        'factories' => array(
            'EfgCasAuth\Controller\Auth' => 'EfgCasAuth\Factory\Controller\AuthControllerFactory',
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'efgCasAuthPlugin' => 'EfgCasAuth\Factory\Controller\Plugin\EfgCasAuthPluginFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/login',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/logout',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'logout',
                    ),
                ),
            ),
            'pgtcallback' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/pgtcallback',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'pgtcallback',
                    ),
                ),
            ),
            'proxylogin' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/proxylogin',
                    'defaults' => array(
                        'controller' => 'EfgCasAuth\Controller\Auth',
                        'action' => 'proxylogin',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
//        'doctype' => 'HTML5',
//        'not_found_template' => 'error/404',
//        'exception_template' => 'error/index',
//        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//            'error/404'               => __DIR__ . '/../view/error/404.phtml',
//            'error/index'             => __DIR__ . '/../view/error/index.phtml',
//        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
//        'strategies' => array(
//            'ViewJsonStrategy',
//        ),
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
