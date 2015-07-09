<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ModuleController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $moduleService = $sm->get('Ent\Service\Module');
        
        $controller = new ModuleController($moduleService);
        
        return $controller;
    }
}
