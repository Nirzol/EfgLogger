<?php

namespace Ent\Factory\Controller;

use Ent\Controller\StatusRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $statusService = $sm->get('Ent\Service\StatusDoctrineORM');

        $statusForm = $sm->get('FormElementManager')->get('Ent\Form\StatusForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new StatusRestController($statusService, $statusForm, $serializer);

        return $controller;
    }
}
