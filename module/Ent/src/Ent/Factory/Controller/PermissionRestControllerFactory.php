<?php

namespace Ent\Factory\Controller;

use Ent\Controller\PermissionRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $permissionService = $sm->get('Ent\Service\PermissionDoctrineORM');

        $permissionForm    = $sm->get('FormElementManager')->get('Ent\Form\PermissionForm');

        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new PermissionRestController($permissionService, $permissionForm, $hydrator);

        return $controller;
    }
}
