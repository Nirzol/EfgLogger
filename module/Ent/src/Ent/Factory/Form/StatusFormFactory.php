<?php

namespace Ent\Factory\Form;

use Ent\Form\StatusForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

        $statusForm = new StatusForm($entityManager);

        return $statusForm;
    }

}
