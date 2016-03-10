<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAttribute;
use Ent\InputFilter\AttributeInputFilter;
use Ent\Service\AttributeDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $attribute = new EntAttribute();

        $hydrator = new DoctrineObject($om);

        $attributeInputFilter = new AttributeInputFilter($om);

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new AttributeDoctrineService($om, $attribute, $hydrator, $attributeInputFilter, $authorizationService);

        return $service;
    }
}
