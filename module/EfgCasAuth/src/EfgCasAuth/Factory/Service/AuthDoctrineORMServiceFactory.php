<?php

namespace EfgCasAuth\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator )
    {
        return $serviceLocator->get('doctrine.authenticationservice.orm_default');
    }
}
