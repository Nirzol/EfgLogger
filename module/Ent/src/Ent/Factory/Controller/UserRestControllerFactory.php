<?php

namespace Ent\Factory\Controller;

use Ent\Controller\UserRestController;
use SearchLdap\Controller\SearchLdapController;
use SearchLdap\Model\SearchLdap;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $userService = $sm->get('Ent\Service\UserDoctrineORM');

        $config = $sm->get('config');

        $userForm = $sm->get('FormElementManager')->get('Ent\Form\UserForm');
        
        $preferenceService = $sm->get('Ent\Service\PreferenceDoctrineORM');

        $searchLdapModel = new SearchLdap($config['searchldap_config']);

        $searchLdapController = new SearchLdapController($searchLdapModel);

        $serializer = $sm->get('jms_serializer.serializer');

        $controller = new UserRestController($userService, $userForm, $preferenceService, $serializer, $searchLdapController);

        return $controller;
    }

}
