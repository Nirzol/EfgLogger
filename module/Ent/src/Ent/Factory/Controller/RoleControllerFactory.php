<?php

namespace Ent\Factory\Controller;

use Ent\Controller\RoleController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $roleService = $sm->get('Ent\Service\RoleDoctrineORM');

        $roleForm = $sm->get('FormElementManager')->get('Ent\Form\RoleForm');

        $controller = new RoleController($roleService, $roleForm);

        return $controller;
    }

}
