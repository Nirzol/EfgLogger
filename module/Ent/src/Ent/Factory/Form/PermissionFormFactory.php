<?php

namespace Ent\Factory\Form;

use Ent\Form\PermissionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        $entityManager = $services->get('Doctrine\ORM\EntityManager');

        $form = new PermissionForm($entityManager);

        return $form;
    }
}
