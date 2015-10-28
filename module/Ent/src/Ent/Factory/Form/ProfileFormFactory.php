<?php

namespace Ent\Factory\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Form\Fieldset\ServiceFieldset;
use Ent\Form\ProfileForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = $serviceLocator->getServiceLocator();

        $entityManager = $service->get('Doctrine\ORM\EntityManager');

//        $hydrator = new DoctrineObject($entityManager);
//        $serviceEntity = new \Ent\Entity\EntService();
//        $serviceFieldset = new ServiceFieldset($hydrator, $serviceEntity);

        $profileForm = new ProfileForm($entityManager); // $serviceFieldset

        return $profileForm;
    }

}
