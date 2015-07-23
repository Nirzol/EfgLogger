<?php

namespace Ent\Factory\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Controller\ServiceRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceRestControllerFactory
 *
 * @author fandria
 */
class ServiceRestControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $serviceService = $sm->get('Ent\Service\ServiceDoctrineORM');

        $serviceForm    = $sm->get('FormElementManager')->get('Ent\Form\ServiceForm');

        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new ServiceRestController($serviceService, $serviceForm, $hydrator);

        return $controller;
    }
}
