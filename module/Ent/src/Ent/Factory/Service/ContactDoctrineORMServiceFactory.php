<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntContact;
use Ent\InputFilter\ContactInputFilter;
use Ent\Service\ContactDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactDoctrineORMServiceFactory
 *
 * @author fandria
 */
class ContactDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $contact = new EntContact();

        $hydrator = new DoctrineObject($om);

        $contactInputFilter = new ContactInputFilter();

        $authorizationService = $serviceLocator->get('\ZfcRbac\Service\AuthorizationService');

        $service = new ContactDoctrineService($om, $contact, $hydrator, $contactInputFilter, $authorizationService);

        return $service;
    }
}
