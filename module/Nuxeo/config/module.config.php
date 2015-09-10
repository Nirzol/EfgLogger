<?php

return array(
    'router' => array(
        'routes' => array(
            'nuxeo' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/api/nuxeo[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
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