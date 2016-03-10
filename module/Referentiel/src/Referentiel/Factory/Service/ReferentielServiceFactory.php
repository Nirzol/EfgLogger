<?php

namespace Referentiel\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ReferentielServiceFactory
 *
 * @author fandria
 */
class ReferentielServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('Config');

        $client = new Zend\Soap\Client($config['referentiel_config']['wsdl']);

        $referentiel = new \Referentiel($client);

        return $referentiel;
    }

}
