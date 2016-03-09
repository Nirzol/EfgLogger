<?php

namespace EfgLogger\Factory\Service;

use Doctrine\ORM\EntityManager;
use EfgLogger\Service\Logger;
use EfgLogger\Writer\DoctrineWriter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of LoggerFactory
 *
 */
class LoggerFactory implements FactoryInterface
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
}
