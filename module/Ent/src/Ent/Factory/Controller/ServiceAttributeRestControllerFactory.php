<?php

namespace Ent\Factory\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Controller\ServiceAttributeRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of ServiceAttributeRestControllerFactory
 *
 * @author fandria
 */
class ServiceAttributeRestControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $serviceAttributeService = $sm->get('Ent\Service\ServiceAttributeDoctrineORM');

        $serviceAttributeForm    = $sm->get('FormElementManager')->get('Ent\Form\ServiceAttributeForm');

        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new ServiceAttributeRestController($serviceAttributeService, $serviceAttributeForm, $hydrator);

        return $controller;
    }
}
