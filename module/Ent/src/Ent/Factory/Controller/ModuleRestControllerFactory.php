<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ModuleRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $moduleService = $sm->get('Ent\Service\Module');
        
        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        
        $hydrator = new DoctrineObject($om);
        
        $controller = new ModuleRestController($moduleService, $hydrator);
        
        return ($controller);
    }

}
