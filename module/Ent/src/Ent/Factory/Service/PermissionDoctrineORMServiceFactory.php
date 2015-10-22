<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPermission;
use Ent\InputFilter\PermissionInputFilter;
use Ent\Service\PermissionDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $permission = new EntPermission('');

        $hydrator = new DoctrineObject($om);

        $permissionInputFilter = new PermissionInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new PermissionDoctrineService($om, $permission, $hydrator, $permissionInputFilter, $authorizationService);

        return $service;
    }

}
