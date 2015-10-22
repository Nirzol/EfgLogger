<?php

namespace Ent\Factory\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Controller\StructureRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of StructureRestControllerFactory
 *
 * @author fandria
 */
class StructureRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $structureService = $sm->get('Ent\Service\StructureDoctrineORM');

        $structureForm = $sm->get('FormElementManager')->get('Ent\Form\StructureForm');

        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new StructureRestController($structureService, $structureForm, $hydrator);

        return $controller;
    }

}
