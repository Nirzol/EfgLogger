<?php

namespace Ent\Factory\Controller;

use Ent\Controller\UserController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */        
        $sm   = $serviceLocator->getServiceLocator();
        $userService = $sm->get('Ent\Service\UserDoctrineORM');
        
        $config = $sm->get('config');

        $userForm    = $sm->get('FormElementManager')->get('Ent\Form\UserForm');

        $controller = new UserController($userService, $userForm, $config['user-add-base']);

        return $controller;
    }
}
