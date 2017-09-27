<?php

namespace EfgLogger\Factory\Controller;

use EfgLogger\Controller\EfgLoggerController;
use EfgLogger\Service\Logger;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class EfgLoggerControllerFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        $logger = $sm->get('Logger');

        $service = new EfgLoggerController($logger);

        return $service;
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $logger = $container->get(Logger::class);

        $service = new EfgLoggerController($logger);

        return $service;
    }
}
