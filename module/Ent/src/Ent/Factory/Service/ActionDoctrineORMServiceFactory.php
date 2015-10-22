<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAction;
use Ent\InputFilter\ActionInputFilter;
use Ent\Service\ActionDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ActionDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $action = new EntAction();

        $hydrator = new DoctrineObject($om);

        $actionInputFilter = new ActionInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ActionDoctrineService($om, $action, $hydrator, $actionInputFilter, $authorizationService);

        return $service;
    }

}
