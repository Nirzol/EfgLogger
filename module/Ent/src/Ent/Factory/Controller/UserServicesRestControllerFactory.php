<?php

namespace Ent\Factory\Controller;

use Ent\Controller\UserServicesRestController;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of UserServiceRestControllerFactory
 *
 * @author fandria
 */
class UserServicesRestControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $userService = $sm->get('Ent\Service\UserDoctrineORM');
        
        $config = $sm->get('config');

        $userForm = $sm->get('FormElementManager')->get('Ent\Form\UserForm');
        
        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);

        $searchLdapController = new \SearchLdap\Controller\SearchLdapController($searchLdapModel);

        /* @var $serviceLocator ObjectManager */
        $om = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($om);

        $controller = new UserServicesRestController($userService, $userForm, $hydrator, $searchLdapController);

        return $controller;
    }
}
