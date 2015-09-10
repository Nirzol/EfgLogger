<?php

namespace SearchLdap\Factory\Controller;

use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchLdapFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('Config');
        
        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);

        $searchLdapController = new SearchLdapController($searchLdapModel);

        return $searchLdapController;
    }

}

