<?php

namespace Ent\Factory\Controller;

use Ent\Controller\LogRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of LogRestControllerFactory
 *
 * @author sebbar
 */
class LogRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $logService = $sm->get('Ent\Service\LogDoctrineORM');

        $logForm = $sm->get('FormElementManager')->get('Ent\Form\LogForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new LogRestController($logService, $logForm, $serializer);

        return ($controller);
    }
}
