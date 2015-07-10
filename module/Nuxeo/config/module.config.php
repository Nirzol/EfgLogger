<?php

return array(
    'router' => array(
        'routes' => array(
            'nuxeo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/nuxeo',
                    'defaults' => array(
                        'controller' => 'Nuxeo\Controller\Nuxeo',
                    ),
                ),
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(            
            'Nuxeo\Controller\Nuxeo' => '\Nuxeo\Controller\NuxeoController'
        )
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);