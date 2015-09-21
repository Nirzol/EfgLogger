<?php

namespace Ent\Factory\Form;

use Ent\Form\ServiceAttributeForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceAttributeFormFactory
 *
 * @author fandria
 */
class ServiceAttributeFormFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services         = $serviceLocator->getServiceLocator();
        $entityManager    = $services->get('Doctrine\ORM\EntityManager');

        $form = new ServiceAttributeForm($entityManager);

        return $form;
    }
}
