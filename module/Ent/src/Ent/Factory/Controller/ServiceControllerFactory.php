<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ServiceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceControllerFactory
 *
 * @author fandria
 */
class ServiceControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $serviceService = $sm->get('Ent\Service\ServiceDoctrineORM');

        $serviceForm    = $sm->get('FormElementManager')->get('Ent\Form\ServiceForm');

        $controller = new ServiceController($serviceService, $serviceForm);

        return $controller;
    }
}
