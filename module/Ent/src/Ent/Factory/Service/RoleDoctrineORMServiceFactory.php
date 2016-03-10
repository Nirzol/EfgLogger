<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntHierarchicalRole;
use Ent\InputFilter\RoleInputFilter;
use Ent\Service\RoleDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        /* @var $om EntityManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $role = new EntHierarchicalRole();
//        $role = $om->getUnitOfWork()-> ClassMetadata('\Ent\Entity\EntHierarchicalRole');

        $hydrator = new DoctrineObject($om);

        $roleInputFilter = new RoleInputFilter($om);
//        $roleInputFilter = $serviceLocator->get('FilterManager')->get('Ent\InputFilter\RoleInputFilter');   

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new RoleDoctrineService($om, $role, $hydrator, $roleInputFilter, $authorizationService);

        return $service;
    }
}
