<?php

namespace Ent\Factory\Controller;

use Ent\Controller\UserController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $userService = $sm->get('Ent\Service\UserDoctrineORM');

        $profileService = $sm->get('Ent\Service\ProfileDoctrineORM');

        $config = $sm->get('config');

        $userForm = $sm->get('FormElementManager')->get('Ent\Form\UserForm');

//        $searchLdapModel = new SearchLdap($config['searchldap_config']);
//        $searchLdapController = new SearchLdapController($searchLdapModel);
//        $controller = new UserController($userService, $profileService, $userForm, $config['user-add-base'], $searchLdapController);
        $controller = new UserController($userService, $profileService, $userForm, $config['user-add-base']);

        return $controller;
    }

}
