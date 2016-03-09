<?php

return array(
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'EfgLogger\Controller\EfgLogger' => 'EfgLogger\Factory\Controller\EfgLoggerControllerFactory',
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
        ),
    ),
    'router' => array(
        'routes' => array(
            'efglogger' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/efglogger',
                    'constraints' => array(
                        'action' => 'index',
                    ),
                    'defaults' => array(
                        'controller' => 'EfgLogger\Controller\EfgLogger',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions' => true,
//        'doctype' => 'HTML5',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
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
);
