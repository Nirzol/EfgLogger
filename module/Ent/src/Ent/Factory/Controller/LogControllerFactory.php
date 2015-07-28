<?php

namespace Ent\Factory\Controller;

use Ent\Controller\LogController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $service = $sm->get('Ent\Service\Log');
        
        $controller = new LogController($service);
        
        return $controller;
    }
}