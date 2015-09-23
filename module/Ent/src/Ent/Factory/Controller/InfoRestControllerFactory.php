<?php

namespace Ent\Factory\Controller;

use Ent\Controller\InfoRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of InfoRestControllerFactory
 *
 * @author mdjimbi
 */
class InfoRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $config = $sm->get('Config');
        
        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);

        $searchLdapController = new \SearchLdap\Controller\SearchLdapController($searchLdapModel);
        
        $controller = new InfoRestController($searchLdapController);

        return $controller;
    }
    
}
