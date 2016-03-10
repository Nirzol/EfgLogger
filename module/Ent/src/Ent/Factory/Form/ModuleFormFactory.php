<?php

namespace Ent\Factory\Form;

use Ent\Form\ModuleForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

        $moduleForm = new ModuleForm($entityManager);

        return $moduleForm;
    }
}
