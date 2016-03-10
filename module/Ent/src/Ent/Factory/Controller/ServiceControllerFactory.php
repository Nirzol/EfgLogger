<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ServiceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceControllerFactory
 *
 * @author fandria
 */
class ServiceControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $serviceService = $sm->get('Ent\Service\ServiceDoctrineORM');

        $preferenceService = $sm->get('Ent\Service\PreferenceDoctrineORM');

        $serviceForm = $sm->get('FormElementManager')->get('Ent\Form\ServiceForm');

        $preferenceForm = $sm->get('FormElementManager')->get('Ent\Form\PreferenceForm');

        $attributeService = $sm->get('\Ent\Service\AttributeDoctrineORM');

        $config = $sm->get('config');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ServiceController($serviceService, $preferenceService, $serviceForm, $preferenceForm, $attributeService, $serializer, $config['preference_config']);

        return $controller;
    }
}
