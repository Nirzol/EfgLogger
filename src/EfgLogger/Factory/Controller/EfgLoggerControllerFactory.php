<?php

namespace EfgLogger\Factory\Controller;

use EfgLogger\Controller\EfgLoggerController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EfgLoggerControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $logger = $sm->get('Logger');
//        $myLoggerName = 'Logger';
//        if ($sm->has($myLoggerName)) {
//            $logger = $sm->get($myLoggerName);
//        } else {
//            $logger = new NullLogger();
//        }

        $service = new EfgLoggerController($logger);

        return $service;
    }
}
