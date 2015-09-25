<?php

namespace Ent\Factory\Controller;

use Ent\Controller\PermissionController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */        
        $sm   = $serviceLocator->getServiceLocator();
        $permissionService = $sm->get('Ent\Service\PermissionDoctrineORM');

        $permissionForm    = $sm->get('FormElementManager')->get('Ent\Form\PermissionForm');

        $controller = new PermissionController($permissionService, $permissionForm);

        return $controller;
    }
}
