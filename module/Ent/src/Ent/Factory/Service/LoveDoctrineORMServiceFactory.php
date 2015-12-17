<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Ent\Entity\EntLove;
use Ent\Service\LoveDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of LoveDoctrineORMServiceFactory
 *
 * @author fandria
 */
class LoveDoctrineORMServiceFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $love = new EntLove();

        $service = new LoveDoctrineService($om, $love);

        return $service;
    }
}
