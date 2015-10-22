<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntStatus;
use Ent\InputFilter\StatusInputFilter;
use Ent\Service\StatusDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $status = new EntStatus();

        $hydrator = new DoctrineObject($om);

        $statusInputFilter = new StatusInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new StatusDoctrineService($om, $status, $hydrator, $statusInputFilter, $authorizationService);

        return $service;
    }

}
