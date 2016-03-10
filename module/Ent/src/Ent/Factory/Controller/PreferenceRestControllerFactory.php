<?php

namespace Ent\Factory\Controller;

use Ent\Controller\PreferenceRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PreferenceRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $preferenceService = $sm->get('Ent\Service\PreferenceDoctrineORM');

        $preferenceForm = $sm->get('FormElementManager')->get('Ent\Form\PreferenceForm');

        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');

        $hydrator = new DoctrineObject($om);

        $controller = new PreferenceRestController($preferenceService, $preferenceForm, $hydrator);

        return $controller;
    }

}
