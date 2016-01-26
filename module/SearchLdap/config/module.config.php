<?php
return array(
    'controllers' => array(
//        'invokables' => array(
//            'SearchLdap\Controller\SearchLdap' => 'SearchLdap\Controller\SearchLdapController',
//        ),
        'factories' => array(
            'SearchLdap\Controller\SearchLdapController' => SearchLdap\Factory\Controller\SearchLdapFactory::class,
        ),
    ),
    'controller_plugins' => array(
//        'invokables' => array(
//            'SearchLdapPlugin' => 'SearchLdap\Controller\Plugin\SearchLdapPlugin',
//        ),
        'factories' => array(
            'SearchLdapPlugin' => \SearchLdap\Factory\Controller\Plugin\SearchLdapPluginFactory::class,
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
                        'controller' => 'SearchLdap\Controller\SearchLdapController',
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
        'factories' => array( 
            'SearchLdap\Model\SearchLdap' => SearchLdap\Factory\Model\SearchLdapModelFactory::class,
        ),
    ),
);