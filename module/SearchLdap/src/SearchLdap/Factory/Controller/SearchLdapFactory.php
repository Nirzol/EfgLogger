<?php

namespace SearchLdap\Factory\Controller;

use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchLdapFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('config');

        $ldap = new \Zend\Ldap\Ldap($config['searchldap_config']);

        $searchLdapModel = new \SearchLdap\Model\SearchLdap($ldap);

        $searchLdapController = new SearchLdapController($searchLdapModel);

        return $searchLdapController;
    }
}
