<?php

namespace Ent\Factory\Controller;

use Ent\Controller\RoleRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
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

        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');

        $hydrator = new DoctrineObject($om);

        $controller = new RoleRestController($roleService, $roleForm, $hydrator);

        return ($controller);
    }

}
