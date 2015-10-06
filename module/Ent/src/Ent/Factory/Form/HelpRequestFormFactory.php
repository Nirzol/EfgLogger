<?php

namespace Ent\Factory\Form;

use Ent\Form\HelpRequestForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of HelpRequestFormFactory
 *
 * @author mdjimbi
 */

class HelpRequestFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service         = $serviceLocator->getServiceLocator();
        $entityManager    = $service->get('Doctrine\ORM\EntityManager');

        $form = new HelpRequestForm($entityManager);

        return $form;
    }

}
