<?php

namespace Ent\Factory\Controller;

use Ent\Controller\InfoRestController;
use PhpEws\EwsConnection;
use Referentiel\Controller\Plugin\ReferentielPlugin;
use SearchLdap\Controller\SearchLdapController;
use SearchLdap\Model\SearchLdap;
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
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();
        
        $config = $sm->get('Config');
        
        $searchLdapModel = new SearchLdap($config['searchldap_config']);

        $searchLdapController = new SearchLdapController($searchLdapModel);
        
        /* @var $referentielPlugin ReferentielPlugin */
        $referentielPlugin = new ReferentielPlugin();
        $accountOwa = $referentielPlugin->getOwaAccount($config['owa_config']['username'], $config['owa_config']['password']);
        
        $ews = new EwsConnection($config['owa_config']['host'], $accountOwa[0], $accountOwa[1], $config['owa_config']['version']);
                
        $controller = new InfoRestController($searchLdapController, $ews);

        return $controller;
    }
    
}
