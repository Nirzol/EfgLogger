<?php

namespace EfgLogger\Factory\Service;

use Doctrine\ORM\EntityManager;
use EfgLogger\Service\Logger;
use EfgLogger\Writer\DoctrineWriter;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of LoggerFactory
 *
 */
class LoggerFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return EntityManager
     */
    protected function getEm(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return $entityManager;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->create($serviceLocator, "Logger");
    }

    public function create(ServiceLocatorInterface $serviceLocator, $requestedName)
    {
        $entityManager = $this->getEm($serviceLocator);
        $config = $serviceLocator->get('config');
        $entityName = $config['efglogger'][$requestedName]['entityClassName'];
        $columnMap = $config['efglogger'][$requestedName]['columnMap'];
//        var_dump($columnMap);
        $logger = new Logger();
        $writer = new DoctrineWriter($entityName, $entityManager, $columnMap);
        $logger->addWriter($writer);
        return $logger;
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
        $requestedName = "Logger";

        $entityManager = $container->get('Doctrine\ORM\EntityManager');

        $config = $container->get('Config');

        $entityName = $config['efglogger'][$requestedName]['entityClassName'];
        $columnMap = $config['efglogger'][$requestedName]['columnMap'];

        $logger = new Logger();
        $writer = new DoctrineWriter($entityName, $entityManager, $columnMap);
        $logger->addWriter($writer);
        return $logger;
    }
}
