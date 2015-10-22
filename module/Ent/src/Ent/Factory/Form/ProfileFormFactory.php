<?php

namespace Ent\Factory\Form;

use Ent\Form\ProfileForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

        $profileForm = new ProfileForm($entityManager);

        return $profileForm;
    }

}
