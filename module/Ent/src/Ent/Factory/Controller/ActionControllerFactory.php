<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ActionController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ActionControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $actionService = $sm->get('Ent\Service\Action');
        
        $controller = new ActionController($actionService);
        
        return $controller;
    }

}
