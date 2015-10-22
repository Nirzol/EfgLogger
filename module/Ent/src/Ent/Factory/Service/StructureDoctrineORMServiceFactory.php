<?php

namespace Ent\Factory\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntStructure;
use Ent\InputFilter\StructureInputFilter;
use Ent\Service\StructureDoctrineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of StructureDoctrineORMServiceFactory
 *
 * @author fandria
 */
class StructureDoctrineORMServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ObjectManager */
        $om = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $structure = new EntStructure();

        $hydrator = new DoctrineObject($om);

        $structureInputFilter = new StructureInputFilter();

        $service = new StructureDoctrineService($om, $structure, $hydrator, $structureInputFilter);

        return $service;
    }

}
