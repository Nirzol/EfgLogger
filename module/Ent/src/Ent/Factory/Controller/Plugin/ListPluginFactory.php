<?php

namespace Ent\Factory\Controller\Plugin;

use Ent\Controller\Plugin\ListPlugin;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListPluginFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $listService = $sm->get('Ent\Service\ListDoctrineORM');

        $service = new ListPlugin($listService);

        return $service;
    }
}
