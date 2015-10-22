<?php

namespace Ent\Factory\Controller;

use Ent\Controller\AttributeController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $attributeService = $sm->get('Ent\Service\AttributeDoctrineORM');

        $attributeForm = $sm->get('FormElementManager')->get('Ent\Form\AttributeForm');

        $controller = new AttributeController($attributeService, $attributeForm);

        return $controller;
    }

}
