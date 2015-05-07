<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Ent\Controller\Index' => Ent\Controller\IndexController::class
        ),
        'factories' => array(
//            'AddressBook\Controller\Contact'    => 'AddressBook\Factory\Controller\ContactControllerFactory',
//            'AddressBook\Controller\ContactRest'    => 'AddressBook\Factory\Controller\ContactRestControllerFactory',
        ),
    ), 
    'form_elements' => array(
        'factories' => array(
//            'AddressBook\Form\ContactForm' => 'AddressBook\Factory\Form\ContactFormFactory',  
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'index' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/index',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),
//                    'show' => array(
//                        'type' => \Zend\Mvc\Router\Http\Segment::class,
//                        'options' => array(
//                            'route' => '/:id',
//                            'defaults' => array(
//                                'action' => 'show',
//                            ),
//                            'constraints' => array(
//                                'id' => '[1-9][0-9]*',
//                            ),
//                        ),
//                        'may_terminate' => true,
//                        'child_routes' => array(
//                            'delete' => array(
//                                'type' => \Zend\Mvc\Router\Http\Literal::class,
//                                'options' => array(
//                                    'route' => '/delete',
//                                    'defaults' => array(
//                                        'action' => 'delete',
//                                    ),
//                                ),
//                            ),
//                            'modify' => array(
//                                'type' => \Zend\Mvc\Router\Http\Literal::class,
//                                'options' => array(
//                                    'route' => '/modify',
//                                    'defaults' => array(
//                                        'action' => 'modify',
//                                    ),
//                                ),
//                            ),
//                        ),
//                    ),
                ),
            ),
//            'contact-rest' => array(
//                'type'    => \Zend\Mvc\Router\Http\Segment::class,
//                'options' => array(
//                    'route'    => '/contact-rest[/:id]',
//                    'constraints' => array(
//                        'id'     => '[0-9]+',
//                    ),
//                    'defaults' => array(
//                        'controller' => 'AddressBook\Controller\ContactRest',
//                    ),
//                ),
//            ),
        ),
    ),
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
//        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//            'error/404'               => __DIR__ . '/../view/error/404.phtml',
//            'error/index'             => __DIR__ . '/../view/error/index.phtml',
//        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
//            'AddressBook\Service\ContactFake' => AddressBook\Service\Contact\ContactFakeService::class
        ),
        'factories' => array( 
//            'AddressBook\Service\ContactZendDb' => 'AddressBook\Factory\Service\ContactZendDbServiceFactory',
//            'AddressBook\Service\ContactDoctrineORM' => 'AddressBook\Factory\Service\ContactDoctrineORMServiceFactory',
        ),
        'aliases' => array(
//            'AddressBook\Service\Contact' => 'AddressBook\Service\ContactFake'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'ent_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Ent/Entity'
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Ent\Entity' => 'ent_annotation_driver'
                )
            )
        )
    ),              
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../languages',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
);
