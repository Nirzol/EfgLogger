<?php

namespace Owa\Factory\Controller;

use Owa\Controller\OwaRestController;
use Owa\Model\Owa;
use PhpEws\EwsConnection;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of OwaRestControllerFactory
 *
 * @author fandria
 */
class OwaRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('config');

        $ews = new EwsConnection($config['owa_config']['host'], $config['owa_config']['username'], $config['owa_config']['password'], $config['owa_config']['version']);

        $owa = new Owa($ews);

//        $searchLdapModel = new \SearchLdap\Model\SearchLdap($config['searchldap_config']);
//        $searchLdapController = new \SearchLdap\Controller\SearchLdapController($searchLdapModel);
//        $serviceOwa = $sm->get('Owa\Model\Owa');
//        $owaRestController = new OwaRestController($searchLdapController, $owa);
        $owaRestController = new OwaRestController($owa);
        return $owaRestController;
    }
}
