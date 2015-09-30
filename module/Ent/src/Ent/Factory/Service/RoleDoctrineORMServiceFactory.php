<?php

namespace Ent\Factory\Service;

use Ent\Service\RoleDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        /* @var $om \Doctrine\ORM\EntityManager */
        $om   = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $role = new \Ent\Entity\EntHierarchicalRole();
//        $role = $om->getUnitOfWork()-> ClassMetadata('\Ent\Entity\EntHierarchicalRole');

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($om);

        $roleInputFilter = new \Ent\InputFilter\RoleInputFilter($om);
//        $roleInputFilter = $serviceLocator->get('FilterManager')->get('Ent\InputFilter\RoleInputFilter');   
        
        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new RoleDoctrineService($om, $role, $hydrator, $roleInputFilter, $authorizationService);

        return $service;
    }
}
