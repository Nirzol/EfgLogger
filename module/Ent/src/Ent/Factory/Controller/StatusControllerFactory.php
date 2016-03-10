<?php

namespace Ent\Factory\Controller;

use Ent\Controller\StatusController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $statusService = $sm->get('Ent\Service\StatusDoctrineORM');

        $statusForm = $sm->get('FormElementManager')->get('Ent\Form\StatusForm');

        $controller = new StatusController($statusService, $statusForm);

        return $controller;
    }
}
