<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Factory\Controller;

use Ent\Controller\VersionRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of VersionRestControllerFactory
 *
 * @author sebbar
 */
class VersionRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $service = $sm->get('Ent\Service\Version');
        
        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        
        $hydrator = new DoctrineObject($om);
        
        $controller = new VersionRestController($service, $hydrator);
        
        return ($controller);
    }

}

