<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ModuleRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $moduleService = $sm->get('Ent\Service\ModuleDoctrineORM');

        $moduleForm = $sm->get('FormElementManager')->get('Ent\Form\ModuleForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ModuleRestController($moduleService, $moduleForm, $serializer);

        return ($controller);
    }

}
