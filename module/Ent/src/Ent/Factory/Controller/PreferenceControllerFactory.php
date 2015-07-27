<?php

namespace Ent\Factory\Controller;

use Ent\Controller\PreferenceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PreferenceControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $preferenceService = $sm->get('Ent\Service\Preference');
        $preferenceForm = $sm->get('FormElementManager')->get('Ent\Form\PreferenceForm');
        
        $controller = new PreferenceController($preferenceService, $preferenceForm);
        
        return $controller;
    }

}
