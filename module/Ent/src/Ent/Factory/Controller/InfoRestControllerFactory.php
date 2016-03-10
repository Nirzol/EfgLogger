<?php

namespace Ent\Factory\Controller;

use Ent\Controller\InfoRestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of InfoRestControllerFactory
 *
 * @author mdjimbi
 */
class InfoRestControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $loveService = $sm->get('Ent\Service\LoveDoctrineORM');

        $config = $sm->get('Config');

        $owa = $config['owa_config'];

//        $ldap = new \Zend\Ldap\Ldap($config['searchldap_config']);
//        $searchLdapModel = new SearchLdap($config['searchldap_config'], $ldap);

        $wsdlReferentiel = $config['referentiel_config']['wsdl'];

//        $searchLdapController = new SearchLdapController($searchLdapModel);
//        $controller = new InfoRestController($searchLdapController, $loveService, $wsdlReferentiel, $owa);
        $controller = new InfoRestController($loveService, $wsdlReferentiel, $owa);

        return $controller;
    }

}
