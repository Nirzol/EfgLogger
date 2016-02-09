<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ListtypeController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListtypeControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $listtypeService = $sm->get('Ent\Service\ListtypeDoctrineORM');

        $listtypeForm = $sm->get('FormElementManager')->get('Ent\Form\ListtypeForm');

        $controller = new ListtypeController($listtypeService, $listtypeForm);

        return $controller;
    }

}
