<?php
return array(
    'controllers' => array(
//        'invokables' => array(
//            'SearchLdap\Controller\SearchLdap' => 'SearchLdap\Controller\SearchLdapController',
//        ),
        'factories' => array(
            'SearchLdap\Controller\SearchLdapController' => SearchLdap\Factory\Controller\SearchLdapFactory::class,
            'SearchLdap\Controller\LdapSearchController' => SearchLdap\Factory\Controller\LdapSearchFactory::class,
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
            'ldap-search' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/api/ldap-search',
                    'defaults' => array(
                        'controller' => 'SearchLdap\Controller\LdapSearchController',
                        'action' => 'search'
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
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