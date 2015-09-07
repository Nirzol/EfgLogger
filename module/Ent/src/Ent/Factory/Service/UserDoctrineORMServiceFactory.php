<?php

namespace Ent\Factory\Service;

use Ent\Service\UserDoctrineService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om   = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $user = new \Ent\Entity\EntUser();

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($om);

        $userInputFilter = new \Ent\InputFilter\UserInputFilter();
        
        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new UserDoctrineService($om, $user, $hydrator, $userInputFilter, $authorizationService);

        return $service;
    }
}
