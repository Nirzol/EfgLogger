<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Ent\Controller\Index' => Ent\Controller\IndexController::class,
            'Ent\Controller\IndexRest' => Ent\Controller\IndexRestController::class
        ),
        'factories' => array(
            'Ent\Controller\User' => 'Ent\Factory\Controller\UserControllerFactory',
            'Ent\Controller\UserRest' => 'Ent\Factory\Controller\UserRestControllerFactory',
            'Ent\Controller\UserServicesRest' => 'Ent\Factory\Controller\UserServicesRestControllerFactory',
            'Ent\Controller\Module' => 'Ent\Factory\Controller\ModuleControllerFactory',
            'Ent\Controller\ModuleRest' => 'Ent\Factory\Controller\ModuleRestControllerFactory',
            'Ent\Controller\Status' => 'Ent\Factory\Controller\StatusControllerFactory',
            'Ent\Controller\StatusRest' => 'Ent\Factory\Controller\StatusRestControllerFactory',
            'Ent\Controller\Action' => 'Ent\Factory\Controller\ActionControllerFactory',
            'Ent\Controller\ActionRest' => 'Ent\Factory\Controller\ActionRestControllerFactory',
            'Ent\Controller\StructureRest' => 'Ent\Factory\Controller\StructureRestControllerFactory',
            'Ent\Controller\Attribute' => 'Ent\Factory\Controller\AttributeControllerFactory',
            'Ent\Controller\AttributeRest' => 'Ent\Factory\Controller\AttributeRestControllerFactory',
            'Ent\Controller\Service' => 'Ent\Factory\Controller\ServiceControllerFactory',
            'Ent\Controller\ServiceRest' => 'Ent\Factory\Controller\ServiceRestControllerFactory',
            'Ent\Controller\ServiceAttribute' => 'Ent\Factory\Controller\ServiceAttributeControllerFactory',
            'Ent\Controller\ServiceAttributeRest' => 'Ent\Factory\Controller\ServiceAttributeRestControllerFactory',
            'Ent\Controller\Contact' => 'Ent\Factory\Controller\ContactControllerFactory',
            'Ent\Controller\ContactRest' => 'Ent\Factory\Controller\ContactRestControllerFactory',
            'Ent\Controller\Preference' => 'Ent\Factory\Controller\PreferenceControllerFactory',
            'Ent\Controller\PreferenceRest' => 'Ent\Factory\Controller\PreferenceRestControllerFactory',
            'Ent\Controller\Profile' => 'Ent\Factory\Controller\ProfileControllerFactory',
            'Ent\Controller\ProfileRest' => 'Ent\Factory\Controller\ProfileRestControllerFactory',
            'Ent\Controller\Log' => 'Ent\Factory\Controller\LogControllerFactory',
            'Ent\Controller\LogRest' => 'Ent\Factory\Controller\LogRestControllerFactory',
            'Ent\Controller\Version' => 'Ent\Factory\Controller\VersionControllerFactory',
            'Ent\Controller\VersionRest' => 'Ent\Factory\Controller\VersionRestControllerFactory',
            'Ent\Controller\Role' => 'Ent\Factory\Controller\RoleControllerFactory',
            'Ent\Controller\InfoRest' => 'Ent\Factory\Controller\InfoRestControllerFactory',
            'Ent\Controller\Permission' => 'Ent\Factory\Controller\PermissionControllerFactory',
            'Ent\Controller\RoleRest' => 'Ent\Factory\Controller\RoleRestControllerFactory',
            'Ent\Controller\HelpRequest' => 'Ent\Factory\Controller\HelpRequestControllerFactory',
            'Ent\Controller\HelpRequestRest' => 'Ent\Factory\Controller\HelpRequestRestControllerFactory',
        ),
    ),
    'form_elements' => array(
        'factories' => array(
            'Ent\Form\UserForm' => 'Ent\Factory\Form\UserFormFactory',
            'Ent\Form\StructureForm' => 'Ent\Factory\Form\StructureFormFactory',
            'Ent\Form\AttributeForm' => 'Ent\Factory\Form\AttributeFormFactory',
            'Ent\Form\ServiceForm' => 'Ent\Factory\Form\ServiceFormFactory',
            'Ent\Form\ServiceAttributeForm' => 'Ent\Factory\Form\ServiceAttributeFormFactory',
            'Ent\Form\ContactForm' => 'Ent\Factory\Form\ContactFormFactory',
            'Ent\Form\PreferenceForm' => 'Ent\Factory\Form\PreferenceFormFactory',
            'Ent\Form\RoleForm' => 'Ent\Factory\Form\RoleFormFactory',
            'Ent\Form\PermissionForm' => 'Ent\Factory\Form\PermissionFormFactory',
            'Ent\Form\HelpRequestForm' => 'Ent\Factory\Form\HelpRequestFormFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                ),
            ),
            'index' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/index',
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
                    'route' => '/api/user',
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
                    'add-auto' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/add-auto',
                            'defaults' => array(
                                'action' => 'addAuto',
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
                    'route' => '/api/module',
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
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'update' => array(
                                'type' => Zend\Mvc\Router\Http\Segment::class,
                                'options' => array(
                                    'route' => '/update',
                                    'defaults' => array(
                                        'action' => 'update',
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type' => Zend\Mvc\Router\Http\Segment::class,
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                        )
                    ),
                ),
            ),
            'profile' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/profile',
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
                    'route' => '/api/status',
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
                    'route' => '/api/action',
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
            'attribute' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/attribute',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Attribute',
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
            'service' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/service',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Service',
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
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
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
            'service-attribute' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/service-attribute',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ServiceAttribute',
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
            'contact' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/contact',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Contact',
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
            'log' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/log',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\log',
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
                )
            ),
            'preference' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/preference',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Preference',
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
            'role' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/role',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Role',
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
            'permission' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/permission',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Permission',
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
            'version' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/version',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\Version',
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
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'update' => array(
                                'type' => Zend\Mvc\Router\Http\Segment::class,
                                'options' => array(
                                    'route' => '/update',
                                    'defaults' => array(
                                        'action' => 'update',
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type' => Zend\Mvc\Router\Http\Segment::class,
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                        )
                    ),
                ),
            ),
            'help-request' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/help-request',
                    'defaults' => array(
                        'controller' => 'Ent\Controller\HelpRequest',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'send' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/send',
                            'defaults' => array(
                                'action' => 'send',
                            ),
                        ),
                    ),
                ),
            ),
            'index-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/index-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\IndexRest',
                    ),
                ),
            ),
            'user-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/user-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\UserRest',
                    ),
                ),
            ),
            'user-services-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/user-services-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\UserServicesRest',
                    ),
                ),
            ),
            'module-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/module-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ModuleRest',
                    ),
                ),
            ),
            'profile-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/profile-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ProfileRest',
                    ),
                ),
            ),
            'log-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/log-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\LogRest',
                    ),
                ),
            ),
            'status-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/status-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\StatusRest',
                    ),
                ),
            ),
            'action-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/action-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ActionRest',
                    ),
                ),
            ),
            'structure-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/structure-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\StructureRest',
                    ),
                ),
            ),
            'attribute-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/attribute-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\AttributeRest',
                    ),
                ),
            ),
            'service-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/service-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ServiceRest',
                    ),
                ),
            ),  
            'service-attribute-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/api/service-attribute-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ServiceAttributeRest',
                    ),
                ),
            ),  
            'contact-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/contact-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\ContactRest',
                    ),
                ),
            ),
            'preference-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/preference-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\PreferenceRest',
                    ),
                ),
            ),
            'permission-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/permission-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\PermissionRest',
                    ),
                ),
            ),
            'version-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/api/version-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\VersionRest',
                    ),
                ),
            ),
            'info-rest' => array(
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route' => '/api/info-rest[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\InfoRest',
                    ),
                ),
            ),
            'role-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/api/role-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\RoleRest',
                    ),
                ),
            ),
            'help-request-rest' => array(
                'type'    => \Zend\Mvc\Router\Http\Segment::class,
                'options' => array(
                    'route'    => '/api/help-request-rest[/:slug]',
                    'constraints' => array(
                        'slug'     => '.*',
                    ),
                    'defaults' => array(
                        'controller' => 'Ent\Controller\HelpRequestRest',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
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
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
//            'AddressBook\Service\ContactZendDb' => 'AddressBook\Factory\Service\ContactZendDbServiceFactory',
            'Ent\Service\UserDoctrineORM' => 'Ent\Factory\Service\UserDoctrineORMServiceFactory',
            'Ent\Service\Module' => 'Ent\Factory\Service\ModuleDoctrineORMServiceFactory',
            'Ent\Service\Status' => 'Ent\Factory\Service\StatusDoctrineORMServiceFactory',
            'Ent\Service\Action' => 'Ent\Factory\Service\ActionDoctrineORMServiceFactory',
            'Ent\Service\Profile' => 'Ent\Factory\Service\ProfileDoctrineORMServiceFactory',
            'Ent\Service\StructureDoctrineORM' => 'Ent\Factory\Service\StructureDoctrineORMServiceFactory',
            'Ent\Service\Attribute' => 'Ent\Factory\Service\AttributeDoctrineORMServiceFactory',
            'Ent\Service\ServiceDoctrineORM' => 'Ent\Factory\Service\ServiceDoctrineORMServiceFactory',
            'Ent\Service\ServiceAttributeDoctrineORM' => 'Ent\Factory\Service\ServiceAttributeDoctrineORMServiceFactory',
            'Ent\Service\ContactDoctrineORM' => 'Ent\Factory\Service\ContactDoctrineORMServiceFactory',
            'Ent\Service\Log' => 'Ent\Factory\Service\LogDoctrineORMServiceFactory',
            'Ent\Service\Preference' => 'Ent\Factory\Service\PreferenceDoctrineORMServiceFactory',
            'Ent\Service\RoleDoctrineORM' => 'Ent\Factory\Service\RoleDoctrineORMServiceFactory',
            'Ent\Service\Version' => 'Ent\Factory\Service\VersionDoctrineORMServiceFactory',
            'Ent\Service\PermissionDoctrineORM' => 'Ent\Factory\Service\PermissionDoctrineORMServiceFactory',
            'Ent\Service\HelpRequest' => 'Ent\Factory\Service\HelpRequestDoctrineORMServiceFactory',
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
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
//                'text_domain' => 'ent'
            ),
            array(
                'type' => 'phpArray',
                'base_dir' => 'vendor/zendframework/zend-i18n-resources/languages/',
                'pattern' => 'fr/Zend_Validate.php',
            ),
        ),
    ),
);
//$translator = new Zend\Mvc\I18n\Translator();
//$translator->addTranslationFile(
//    'phpArray',
//    'resources/languages/en/Zend_Validate.php', //or Zend_Captcha
//    'default',
//    'en_US'
//);
//Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
//        $type,
//        $filename,
//        $textDomain = 'default',
//        $locale = null
