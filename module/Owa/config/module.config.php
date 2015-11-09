<?php

return array(
    'controllers' => array(
        'factories' => array(
            'Owa\Controller\OwaRest' => 'Owa\Factory\Controller\OwaRestControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'owa-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/owa-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Owa\Controller\OwaRest',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'mail-notif' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/mail-notif',
                            'defaults' => array(
                                'action' => 'getMailNotif',
                            ),
                        ),
                    ),
                    'calendar-notif' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/calendar-notif',
                            'defaults' => array(
                                'action' => 'getCalendarNotif',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    ),
    'service_manager' => array(
//        'factories' => array(
//            'Zend\Authentication\AuthenticationService' => 'EfgCasAuth\Factory\Service\AuthDoctrineORMServiceFactory',
//        )
    )
);
