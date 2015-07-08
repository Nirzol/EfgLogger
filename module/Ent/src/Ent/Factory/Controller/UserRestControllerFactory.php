<?php

namespace Ent\Factory\Controller;

use Ent\Controller\UserRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $userService = $sm->get('Ent\Service\UserDoctrineORM');

        $userForm    = $sm->get('FormElementManager')->get('Ent\Form\UserForm');

        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new UserRestController($userService, $userForm, $hydrator);

        return $controller;
    }
}
