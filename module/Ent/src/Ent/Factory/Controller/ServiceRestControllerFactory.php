<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ServiceRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceRestControllerFactory
 *
 * @author fandria
 */
class ServiceRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $serviceService = $sm->get('Ent\Service\ServiceDoctrineORM');

        $preferenceService = $sm->get('Ent\Service\PreferenceDoctrineORM');

        $serviceForm = $sm->get('FormElementManager')->get('Ent\Form\ServiceForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ServiceRestController($serviceService, $preferenceService, $serviceForm, $serializer);

        return $controller;
    }

}
