<?php

namespace Ent\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Ent\Form\UserForm;

class UserFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services         = $serviceLocator->getServiceLocator();
        $entityManager    = $services->get('Doctrine\ORM\EntityManager');

        $form = new UserForm($entityManager);

        return $form;
    }
}
