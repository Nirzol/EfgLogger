<?php

namespace SearchLdap\Factory\Controller;

use SearchLdap\Controller\LdapSearchController;
use SearchLdap\Model\SearchLdap;
use SearchLdap\Form\LdapSearchForm;
use SearchLdap\InputFilter\LdapSearchFilter;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Ldap\Ldap;

/**
 * Description of LdapSearchFactory
 *
 * @author mdjimbi
 */
class LdapSearchFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('config');
        $ldap = new Ldap($config['searchldap_config']);

        $searchLdapModel = new SearchLdap($ldap);

        $searchForm = new LdapSearchForm();
        $searchFilter = new LdapSearchFilter();

        $LdapSearchController = new LdapSearchController($searchLdapModel, $searchForm, $searchFilter);

        return $LdapSearchController;
    }
}
