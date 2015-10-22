<?php

namespace Ent\Factory\Controller;

use Ent\Controller\LogController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $logService = $sm->get('Ent\Service\LogDoctrineORM');

        $logForm = $sm->get('FormElementManager')->get('Ent\Form\LogForm');

        $controller = new LogController($logService, $logForm);

        return $controller;
    }

}
