<?php

namespace SearchLdap\Factory\Model;

use SearchLdap\Model\SearchLdap;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of SearchLdapModelFactory
 *
 * @author mdjimbi
 */
class SearchLdapModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator ControllerManager */
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('Config');

        $searchLdapModel = new SearchLdap($config['searchldap_config']);

        return $searchLdapModel;
    }

}
