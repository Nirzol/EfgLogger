<?php

namespace Ent\Factory\Controller;

use Ent\Controller\PermissionRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $permissionService = $sm->get('Ent\Service\PermissionDoctrineORM');

        $permissionForm = $sm->get('FormElementManager')->get('Ent\Form\PermissionForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new PermissionRestController($permissionService, $permissionForm, $serializer);

        return $controller;
    }
}
