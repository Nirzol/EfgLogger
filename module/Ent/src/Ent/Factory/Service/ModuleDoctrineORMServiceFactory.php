<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntModule;
use Ent\InputFilter\ModuleInputFilter;
use Ent\Service\ModuleDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $module = new EntModule();

        $hydrator = new DoctrineObject($om);

        $moduleInputFilter = new ModuleInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ModuleDoctrineService($om, $module, $hydrator, $moduleInputFilter, $authorizationService);

        return $service;
    }

}
