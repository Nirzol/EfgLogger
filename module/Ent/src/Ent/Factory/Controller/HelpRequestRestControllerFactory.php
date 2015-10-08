<?php

namespace Ent\Factory\Controller;

use Ent\Controller\HelpRequestRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of HelpRequestRestControllerFactory
 *
 * @author mdjimbi
 */

class HelpRequestRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $contactService = $sm->get('Ent\Service\ContactDoctrineORM');
        
        $helpRequestService = $sm->get('Ent\Service\HelpRequest');
        
        $helpRequestForm    = $sm->get('FormElementManager')->get('Ent\Form\HelpRequestForm');
        
        $config = $sm->get('Config');
        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);        
        $searchLdapController = new \SearchLdap\Controller\SearchLdapController($searchLdapModel);
                
        $controller = new HelpRequestRestController($contactService, $helpRequestService, $helpRequestForm, $searchLdapController);
        
        return $controller;
    }
    
}
