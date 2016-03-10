<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ActionRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ActionRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $actionService = $sm->get('Ent\Service\ActionDoctrineORM');

        $actionForm = $sm->get('FormElementManager')->get('Ent\Form\ActionForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ActionRestController($actionService, $actionForm, $serializer);

        return $controller;
    }
}
