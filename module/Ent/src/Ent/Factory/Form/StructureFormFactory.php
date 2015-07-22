<?php

namespace Ent\Factory\Form;

use Ent\Form\StructureForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of StructureFormFactory
 *
 * @author fandria
 */
class StructureFormFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services         = $serviceLocator->getServiceLocator();
        $entityManager    = $services->get('Doctrine\ORM\EntityManager');

        $form = new StructureForm($entityManager);

        return $form;
    }
}
