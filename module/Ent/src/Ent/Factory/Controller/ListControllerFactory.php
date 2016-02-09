<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ListController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $listService = $sm->get('Ent\Service\ListDoctrineORM');

        $listForm = $sm->get('FormElementManager')->get('Ent\Form\ListForm');

        $controller = new ListController($listService, $listForm);

        return $controller;
    }

}
