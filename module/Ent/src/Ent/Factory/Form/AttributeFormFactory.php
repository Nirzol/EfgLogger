<?php

namespace Ent\Factory\Form;

use Ent\Form\AttributeForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {       
        $service = $serviceLocator->getServiceLocator();
        
        $entityManager = $service->get('Doctrine\ORM\EntityManager');
        $attributeForm = new AttributeForm($entityManager);
        
        return $attributeForm;
    }
}
