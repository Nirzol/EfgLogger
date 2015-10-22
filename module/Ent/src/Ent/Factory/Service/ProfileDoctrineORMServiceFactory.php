<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntProfile;
use Ent\InputFilter\ProfileInputFilter;
use Ent\Service\ProfileDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ProfileDoctrineORMServiceFactory
 *
 * @author sebbar
 */
class ProfileDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $profile = new EntProfile();

        $hydrator = new DoctrineObject($om);

        $profileInputFilter = new ProfileInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ProfileDoctrineService($om, $profile, $hydrator, $profileInputFilter, $authorizationService);

        return $service;
    }

}
