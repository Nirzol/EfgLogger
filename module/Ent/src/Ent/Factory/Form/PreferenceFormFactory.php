<?php

namespace Ent\Factory\Form;

use Ent\Form\PreferenceForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PreferenceFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service = $serviceLocator->getServiceLocator();
        
        $entityManager = $service->get('Doctrine\ORM\EntityManager');
        $preferenceForm = new PreferenceForm($entityManager);
        
        return $preferenceForm;
    }

}
