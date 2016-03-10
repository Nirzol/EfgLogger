<?php

namespace Ent\Factory\Form;

use Ent\Form\ContactForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactFormFactory
 *
 * @author fandria
 */
class ContactFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        $entityManager = $services->get('Doctrine\ORM\EntityManager');

        $contactForm = new ContactForm($entityManager);

        return $contactForm;
    }

}
