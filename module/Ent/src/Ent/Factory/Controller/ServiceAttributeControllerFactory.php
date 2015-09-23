<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ServiceAttributeController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceAttributeControllerFactory
 *
 * @author fandria
 */
class ServiceAttributeControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $serviceAttributeService = $sm->get('Ent\Service\ServiceAttributeDoctrineORM');

        $serviceAttributeForm    = $sm->get('FormElementManager')->get('Ent\Form\ServiceAttributeForm');

        $controller = new ServiceAttributeController($serviceAttributeService, $serviceAttributeForm);

        return $controller;
    }
}
