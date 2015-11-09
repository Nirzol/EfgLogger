<?php

namespace Owa\Factory\Controller;

use Owa\Controller\OwaRestController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of OwaRestControllerFactory
 *
 * @author fandria
 */
class OwaRestControllerFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        //TODO
        
        $owaRestController = new OwaRestController();
        return $owaRestController;
    }
}
