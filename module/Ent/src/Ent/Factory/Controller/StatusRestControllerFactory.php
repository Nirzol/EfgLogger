<?php

namespace Ent\Factory\Controller;

use Ent\Controller\StatusRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $statusService = $sm->get('Ent\Service\Status');
        
        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        
        $hydrator = new DoctrineObject($om);
        
        $controller = new StatusRestController($statusService, $hydrator);
        
        return $controller;
        
    }

}
