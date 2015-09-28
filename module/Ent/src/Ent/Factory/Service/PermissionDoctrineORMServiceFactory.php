<?php

namespace Ent\Factory\Service;

use Ent\Service\PermissionDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om   = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $permission = new \Ent\Entity\EntPermission('');

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($om);

        $permissionInputFilter = new \Ent\InputFilter\PermissionInputFilter($om);
        
        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new PermissionDoctrineService($om, $permission, $hydrator, $permissionInputFilter, $authorizationService);

        return $service;
    }
}
