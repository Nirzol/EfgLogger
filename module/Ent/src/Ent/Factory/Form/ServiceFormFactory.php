<?php

namespace Ent\Factory\Form;

use Ent\Form\ServiceForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ServiceFormFactory
 *
 * @author fandria
 */
class ServiceFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        $entityManager = $services->get('Doctrine\ORM\EntityManager');

        $form = new ServiceForm($entityManager);

        return $form;
    }

}
