<?php

namespace SearchLdap\Factory\Controller\Plugin;

use SearchLdap\Controller\Plugin\SearchLdapPlugin;
use Zend\Ldap\Ldap;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of SearchLdapModelFactory
 *
 * @author mdjimbi
 */
class SearchLdapPluginFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('Config');
        
        $ldap = new Ldap($config['searchldap_config']);

        $searchLdapModel = new \SearchLdap\Model\SearchLdap($ldap);

        return new SearchLdapPlugin($searchLdapModel);
    }

}
