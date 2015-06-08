<?php

namespace EfgCasAuth\Factory\Authentication;

use DoctrineModule\Service\Authentication\AdapterFactory  as BaseAdapterFactory;
use EfgCasAuth\Adapter\ObjectRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterFactory extends BaseAdapterFactory
{

    /**
     * {@inheritDoc}
     *
     * @return \EfgCasAuth\Adapter\ObjectRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \DoctrineModule\Options\Authentication */
        $options = $this->getOptions($serviceLocator, 'authentication');
        if (is_string($objectManager = $options->getObjectManager())) {
            $options->setObjectManager($serviceLocator->get($objectManager));
        }
        return new ObjectRepository($options);
    }

}
