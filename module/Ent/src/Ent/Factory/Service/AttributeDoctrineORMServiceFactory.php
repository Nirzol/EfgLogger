<?php

namespace Ent\Factory\Service;

use Ent\Service\AttributeDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');
        
        $service = new AttributeDoctrineService($om);
        
        return $service;
    }
}
