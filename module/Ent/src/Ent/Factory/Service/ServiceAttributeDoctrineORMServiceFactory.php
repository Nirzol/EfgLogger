<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntServiceAttribute;
use Ent\InputFilter\ServiceAttributeInputFilter;
use Ent\Service\ServiceAttributeDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Description of ServiceAttributeDoctrineORMServiceFactory
 *
 * @author fandria
 */
class ServiceAttributeDoctrineORMServiceFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om   = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $serviceAttribute = new EntServiceAttribute();

        $hydrator = new DoctrineObject($om);

        $serviceAttributeInputFilter = new ServiceAttributeInputFilter();

        $service = new ServiceAttributeDoctrineService($om, $serviceAttribute, $hydrator, $serviceAttributeInputFilter);

        return $service;
    }
}
