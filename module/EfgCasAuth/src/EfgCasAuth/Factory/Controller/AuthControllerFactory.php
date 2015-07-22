<?php

namespace EfgCasAuth\Factory\Controller;

use EfgCasAuth\Controller\AuthController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        
        $config = $sm->get('Config');
        
        $userService = $sm->get($config['cas']['user_doctrine_orm_service_factory']);
        $userForm    = $sm->get('FormElementManager')->get($config['cas']['user_form']);  
        
        // A modifier spécifique à chaque développement
        $om   = $sm->get('Doctrine\ORM\EntityManager');
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($om);
        $user = new \Ent\Controller\UserRestController($userService, $userForm, $hydrator);
        $user = null;

        $authController = new AuthController($authService, $config, $user);

        return $authController;
    }
}
