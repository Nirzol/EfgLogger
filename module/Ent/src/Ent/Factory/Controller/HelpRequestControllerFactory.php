<?php

namespace Ent\Factory\Controller;

use Ent\Controller\HelpRequestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of HelpRequestControllerFactory
 *
 * @author mdjimbi
 */

class HelpRequestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        
        $helpRequestForm    = $sm->get('FormElementManager')->get('Ent\Form\HelpRequestForm');
        
        $helpRequestInputFilter = $sm->get('InputFilterManager')->get('Ent\InputFilter\HelpRequestInputFilter');
        
        $config = $sm->get('Config');
        
        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);

        $searchLdapController = new \SearchLdap\Controller\SearchLdapController($searchLdapModel);
        
        $contactService = $sm->get('Ent\Service\ContactDoctrineORM');
        
        $helpRequestService = $sm->get('Ent\Service\HelpRequestDoctrineORM');
        
        $controller = new HelpRequestController($contactService, $helpRequestService, $helpRequestForm, $helpRequestInputFilter, $searchLdapController);

        return $controller;
    }

}
