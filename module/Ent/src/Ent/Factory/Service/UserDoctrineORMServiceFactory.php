<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntUser;
use Ent\InputFilter\UserInputFilter;
use Ent\Service\UserDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $user = new EntUser();

        $hydrator = new DoctrineObject($om);

        $userInputFilter = new UserInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new UserDoctrineService($om, $user, $hydrator, $userInputFilter, $authorizationService);

        return $service;
    }
}
