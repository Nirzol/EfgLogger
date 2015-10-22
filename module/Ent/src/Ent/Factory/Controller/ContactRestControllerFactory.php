<?php

namespace Ent\Factory\Controller;

use Ent\Controller\ContactRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactRestControllerFactory
 *
 * @author fandria
 */
class ContactRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $contactService = $sm->get('Ent\Service\ContactDoctrineORM');

        $contactForm = $sm->get('FormElementManager')->get('Ent\Form\ContactForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new ContactRestController($contactService, $contactForm, $serializer);

        return $controller;
    }

}
