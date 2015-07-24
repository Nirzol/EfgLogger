<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Factory\Service;

use Ent\Service\ProfileDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ProfileDoctrineORMServiceFactory
 *
 * @author sebbar
 */
class ProfileDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');
        
        $service = new ProfileDoctrineService($om);
        
        return $service;        
    }
}
