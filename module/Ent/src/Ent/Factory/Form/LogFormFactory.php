<?php

namespace Ent\Factory\Form;

use Ent\Form\LogForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

        $logForm = new LogForm($entityManager);

        return $logForm;
    }
}
