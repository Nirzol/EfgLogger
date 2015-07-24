<?php

namespace Ent\Factory\Controller;

use Ent\Controller\AttributeRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeRestControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        
        $attributeService = $sm->get('Ent\Service\Attribute');
        
        $attributeForm = $sm->get('FormElementManager')->get('Ent\Form\AttributeForm');
        
        /* @var $serviceLocator ObjectManager */
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        
        $hydrator = new DoctrineObject($om);
        
        $controller = new AttributeRestController($attributeService, $attributeForm, $hydrator);
        
        return $controller;
    }

}
