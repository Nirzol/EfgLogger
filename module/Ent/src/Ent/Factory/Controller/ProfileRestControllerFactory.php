<?php

/*
 * ProfileRestControllerFactory : factory de controlleur ProfileRest
 */


namespace Ent\Factory\Controller;

use Ent\Controller\ProfileRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $service = $sm->get('Ent\Service\Profile');
        
        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        
        $hydrator = new DoctrineObject($om);
        
        $controller = new ProfileRestController($service, $hydrator);
        
        return ($controller);
    }

}
