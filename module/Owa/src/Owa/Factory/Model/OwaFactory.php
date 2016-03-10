<?php

namespace Owa\Factory\Model;

use Owa\Model\Owa;
use PhpEws\EwsConnection;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of OwaFactory
 *
 * @author fandria
 */
class OwaFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('config');

        $ews = new EwsConnection($config['owa_config']['host'], $config['owa_config']['username'], $config['owa_config']['password'], $config['owa_config']['version']);

        $owa = new Owa($ews);

        return $owa;
    }

}
