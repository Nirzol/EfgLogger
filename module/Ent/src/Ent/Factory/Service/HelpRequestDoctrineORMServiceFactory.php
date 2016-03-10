<?php

namespace Ent\Factory\Service;

use Ent\Service\HelpRequestDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of HelpRequestDoctrineORMServiceFactory
 *
 * @author mdjimbi
 */
class HelpRequestDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $service = new HelpRequestDoctrineService($om);

        return $service;
    }
}
