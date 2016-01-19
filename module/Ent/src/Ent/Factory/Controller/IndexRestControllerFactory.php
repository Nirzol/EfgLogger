<?php

namespace Ent\Factory\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Controller\IndexRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $logService = $sm->get('Ent\Service\LogDoctrineORM');
        
        $userService = $sm->get('Ent\Service\UserDoctrineORM');
        
        $actionService = $sm->get('Ent\Service\ActionDoctrineORM');
        
        $logForm = $sm->get('FormElementManager')->get('Ent\Form\LogForm');
        
        $userForm = $sm->get('FormElementManager')->get('Ent\Form\UserForm');

        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');

        $hydrator = new DoctrineObject($om);

        $controller = new IndexRestController($logService, $logForm, $userService, $userForm, $actionService);

        return $controller;
    }

}
