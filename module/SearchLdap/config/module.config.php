<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SearchLdap\Controller\SearchLdap' => 'SearchLdap\Controller\SearchLdapController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search-ldap' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/search-ldap[/:slug]',
                    'constraints' => array(
                        'slug' => '.*',
                    ),
                    'defaults' => array(
                        'controller' => 'SearchLdap\Controller\SearchLdap',
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
);