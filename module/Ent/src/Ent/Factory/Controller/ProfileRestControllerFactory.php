<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ProfileRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $profileService = $sm->get('Ent\Service\ProfileDoctrineORM');

        $profileForm = $sm->get('FormElementManager')->get('Ent\Form\ProfileForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ProfileRestController($profileService, $profileForm, $serializer);

        return $controller;
    }

}
