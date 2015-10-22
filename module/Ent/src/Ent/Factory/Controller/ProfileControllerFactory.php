<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ProfileController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ProfileControllerFactory
 *
 * @author sebbar
 */
class ProfileControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $profileService = $sm->get('Ent\Service\ProfileDoctrineORM');

        $profileForm = $sm->get('FormElementManager')->get('Ent\Form\ProfileForm');

        $controller = new ProfileController($profileService, $profileForm);

        return $controller;
    }

}
