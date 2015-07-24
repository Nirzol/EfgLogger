<?php

namespace Ent\Factory\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Controller\ContactRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactRestControllerFactory
 *
 * @author fandria
 */
class ContactRestControllerFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $contactService = $sm->get('Ent\Service\ContactDoctrineORM');

        $contactForm    = $sm->get('FormElementManager')->get('Ent\Form\ContactForm');

        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new ContactRestController($contactService, $contactForm, $hydrator);

        return $controller;
    }
}
