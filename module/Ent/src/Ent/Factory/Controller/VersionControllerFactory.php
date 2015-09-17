<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Factory\Controller;

use Ent\Controller\VersionController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of VersionControllerFactory
 *
 * @author sebbar
 */
class VersionControllerFactory  implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $service = $sm->get('Ent\Service\Version');
        
        $controller = new VersionController($service);
        
        return $controller;
    }
    

}
