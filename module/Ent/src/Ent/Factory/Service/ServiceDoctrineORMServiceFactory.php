<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntService;
use Ent\InputFilter\ServiceInputFilter;
use Ent\Service\ServiceDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceDoctrineORMServiceFactory
 *
 * @author fandria
 */
class ServiceDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $ser = new EntService();

        $hydrator = new DoctrineObject($om);

        $serviceInputFilter = new ServiceInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ServiceDoctrineService($om, $ser, $hydrator, $serviceInputFilter, $authorizationService);

        return $service;
    }
}
