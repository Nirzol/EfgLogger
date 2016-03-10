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

        $preferenceForm = $sm->get('FormElementManager')->get('Ent\Form\PreferenceForm');

        $attributeService = $sm->get('Ent\Service\AttributeDoctrineORM');

        $serviceService = $sm->get('Ent\Service\ServiceDoctrineORM');

        $preferenceService = $sm->get('Ent\Service\PreferenceDoctrineORM');

        $config = $sm->get('config');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ProfileRestController($profileService, $profileForm, $preferenceForm, $attributeService, $serviceService, $preferenceService, $serializer, $config['preference_config']);

        return $controller;
    }
}
