<?php

namespace EfgLogger;

use EfgLogger\Factory\Service\LoggerFactory;
use EfgLogger\Service\Logger;

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            Controller\EfgLoggerController::class => Factory\Controller\EfgLoggerControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Logger::class => LoggerFactory::class,
            ],
        ],
    'controller_plugins' => [
        'factories' => [
            'logger' => LoggerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'efglogger' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/api/efglogger',
                    'constraints' => [
                        'action' => 'index',
                    ],
                    'defaults' => [
                        'controller' => Controller\EfgLoggerController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
//        'display_not_found_reason' => true,
//        'display_exceptions' => true,
//        'doctype' => 'HTML5',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
//    'doctrine' => array(
//        'driver' => array(
//            'efglogger_annotation_driver' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(
//                    __DIR__ . '/../src/EfgLogger/Entity'
//                ),
//            ),
//            'orm_default' => array(
//                'drivers' => array(
//                    'EfgLogger\Entity' => 'efglogger_annotation_driver'
//                )
//            )
//        ),
//    ),
];
