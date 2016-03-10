<?php

namespace Ent\Factory\Controller;

use Ent\Controller\RoleRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of RoleRestControllerFactory
 *
 * @author sebbar
 */
class RoleRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $roleService = $sm->get('Ent\Service\RoleDoctrineORM');

        $roleForm = $sm->get('FormElementManager')->get('Ent\Form\RoleForm');

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new RoleRestController($roleService, $roleForm, $serializer);

        return ($controller);
    }
}
