<?php

namespace Ent\Factory\Form;

use Ent\Form\ActionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ActionFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

        $actionForm = new ActionForm($entityManager);

        return $actionForm;
    }

}
