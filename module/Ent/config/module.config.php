<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Ent\Controller\Index' => Ent\Controller\IndexController::class,
//            'Ent\Controller\Profile' => Ent\Controller\ProfileController::class
        ),
        'factories' => array(
            'Ent\Controller\User'    => 'Ent\Factory\Controller\UserControllerFactory',
            'Ent\Controller\UserRest'    => 'Ent\Factory\Controller\UserRestControllerFactory',
            'Ent\Controller\Module' => 'Ent\Factory\Controller\ModuleControllerFactory',
            'Ent\Controller\ModuleRest' => 'Ent\Factory\Controller\ModuleRestControllerFactory',
            'Ent\Controller\Status' => 'Ent\Factory\Controller\StatusControllerFactory',
            'Ent\Controller\StatusRest' => 'Ent\Factory\Controller\StatusRestControllerFactory',
            'Ent\Controller\Action' => 'Ent\Factory\Controller\ActionControllerFactory',
            'Ent\Controller\ActionRest' => 'Ent\Factory\Controller\ActionRestControllerFactory',
//            'Ent\Controller\Module' => function($cm) {
//                $sm = $cm->getServiceLocator($cm);
//                
//                $moduleService = $sm->get('Ent\Service\Module');
//                
//                return new Ent\Controller\ModuleController($moduleService);
//            },
//            'Ent\Controller\ModuleRest' => function($cm) {
//                $sm = $cm->getServiceLocator($cm);
//                $om   = $sm->get('Doctrine\ORM\EntityManager');
//                
//                $moduleService = $sm->get('Ent\Service\Module');
//                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($om);
//                
//                return new Ent\Controller\ModuleRestController($moduleService, $hydrator);
//            },
            'Ent\Controller\Profile' => 'Ent\Factory\Controller\ProfileControllerFactory',
        ),
    ), 
    'form_elements' => array(
        'factories' => array(
            'Ent\Form\UserForm' => 'Ent\Factory\Form\UserFormFactory',  
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
            'user' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\User',
                        'action' => 'list',
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
                    'show' => array(
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'delete' => array(
                                'type' => \Zend\Mvc\Router\Http\Literal::class,
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                            'modify' => array(
                                'type' => \Zend\Mvc\Router\Http\Literal::class,
                                'options' => array(
                                    'route' => '/modify',
                                    'defaults' => array(
                                        'action' => 'modify',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'module' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/module',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Module',
                        'action' => 'list',
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
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/show/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
            'profile' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/profile',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Profile',
                        'action' => 'list',
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
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/show/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
                
            'status' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/status',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Status',
                        'action' => 'list',
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
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/show/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
            'action' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/action',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Action',
                        'action' => 'list',
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
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/show/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
            'user-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/user-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\UserRest',
                    ),
                ),
            ),
            'module-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/module-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ModuleRest',
                    ),
                ),
            ),
            'status-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/status-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\StatusRest',
                    ),
                ),
            ),
            'action-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/action-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ActionRest',
                    ),
                ),
            ),
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
            'Ent\Service\UserDoctrineORM' => 'Ent\Factory\Service\UserDoctrineORMServiceFactory',
            'Ent\Service\Module' => 'Ent\Factory\Service\ModuleDoctrineORMServiceFactory',
            'Ent\Service\Status' => 'Ent\Factory\Service\StatusDoctrineORMServiceFactory',
            'Ent\Service\Action' => 'Ent\Factory\Service\ActionDoctrineORMServiceFactory',
//            'Ent\Service\Module' => function($sm) {
//
//                $om = $sm->get('Doctrine\ORM\EntityManager');
//                $service = new \Ent\Service\ModuleDoctrineService($om);
//
//                return $service;
//            },
            'Ent\Service\Profile' => 'Ent\Factory\Service\ProfileDoctrineORMServiceFactory',
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
        ),
//        'authentication' => array(
//            'orm_default' => array(
//                'object_manager' => 'Doctrine\ORM\EntityManager',
//                'identity_class' => 'Ent\Entity\EntUser',
//                'identity_property' => 'userLogin',
//                'credential_property' => 'password',
//            ),
//        ),
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
