<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPreference;
use Ent\InputFilter\PreferenceInputFilter;
use Ent\Service\PreferenceDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PreferenceDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $preference = new EntPreference();

        $hydrator = new DoctrineObject($om);

        $preferenceFilter = new PreferenceInputFilter();

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new PreferenceDoctrineService($om, $preference, $hydrator, $preferenceFilter, $authorizationService);

        return $service;
    }
}
