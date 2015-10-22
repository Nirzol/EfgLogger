<?php

namespace Ent\Factory\Controller;

use Ent\Controller\AttributeRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $attributeService = $sm->get('Ent\Service\AttributeDoctrineORM');

        $attributeForm = $sm->get('FormElementManager')->get('Ent\Form\AttributeForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new AttributeRestController($attributeService, $attributeForm, $serializer);

        return $controller;
    }

}
