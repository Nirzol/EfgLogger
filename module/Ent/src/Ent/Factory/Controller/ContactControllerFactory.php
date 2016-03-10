<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ContactController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactControllerFactory
 *
 * @author fandria
 */
class ContactControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $contactService = $sm->get('Ent\Service\ContactDoctrineORM');

        $contactForm = $sm->get('FormElementManager')->get('Ent\Form\ContactForm');

        $controller = new ContactController($contactService, $contactForm);

        return $controller;
    }
}
