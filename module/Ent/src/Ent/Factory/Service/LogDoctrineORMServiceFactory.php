<?php

namespace Ent\Factory\Service;

use Ent\Service\LogDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LogDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');
        
        $service = new LogDoctrineService($om);
        
        return $service;        
    }
}
