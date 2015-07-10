<?php

namespace Ent\Factory\Service;

use Ent\Service\ModuleDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');
        
        $service = new ModuleDoctrineService($om);
        
        return $service;        
    }
}
