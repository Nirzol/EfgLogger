<?php

namespace Ent\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPreference;
use Ent\InputFilter\PreferenceInputFilter;
use Ent\Service\PreferenceDoctrineService;

class PreferenceDoctrineORMServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');
        
        $preference = new EntPreference();
        
        $hydrator = new DoctrineObject($om);
        
        $preferenceFilter = new PreferenceInputFilter();
        
        $service = new PreferenceDoctrineService($om, $preference, $hydrator, $preferenceFilter);
        
        return $service;
    }

}
