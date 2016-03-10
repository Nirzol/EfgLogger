<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntList;
use Ent\InputFilter\ListInputFilter;
use Ent\Service\ListDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $list = new EntList();

        $hydrator = new DoctrineObject($om);

        $listInputFilter = new ListInputFilter();

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ListDoctrineService($om, $list, $hydrator, $listInputFilter, $authorizationService);

        return $service;
    }
}
