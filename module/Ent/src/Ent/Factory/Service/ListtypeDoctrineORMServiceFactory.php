<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntListtype;
use Ent\InputFilter\ListtypeInputFilter;
use Ent\Service\ListtypeDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListtypeDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $listtype = new EntListtype();

        $hydrator = new DoctrineObject($om);

        $listtypeInputFilter = new ListtypeInputFilter();

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ListtypeDoctrineService($om, $listtype, $hydrator, $listtypeInputFilter, $authorizationService);

        return $service;
    }

}
