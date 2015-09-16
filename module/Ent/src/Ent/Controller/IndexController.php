<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {   
        $this->checkVersion();
        return new ViewModel();
    }

    public function addAction()
    {
        /*
         * @TODO
         */
        return new ViewModel();
    }

    public function checkVersion()
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $this->getServiceLocator();
        
        // recupere toute la config avec toutes les cles
        $config = $sm->get('config');
        
        // Recuperation version ENT Zend et compatibilite avec Angular et BD ENT
        $versions = $config['versions'];
        $bdVersionRequired = $versions['dependencies']['data-base-version'];
                
        // Recuperation version BD
        $serviceEo = $sm->get('Ent\Service\Version');
        $bdVersionEo = $serviceEo->getLastInserted(); 
        
        $bdVersionCurrent = "";
        if( isset($bdVersionEo) && ($bdVersionEo != null) ) {
            $bdVersionCurrent = $bdVersionEo->getVersion();
        }
        
        $isMatchBdVersion = $bdVersionRequired === $bdVersionCurrent;
        
        if( $isMatchBdVersion) {
            error_log("INFO: ENT Zend App version = " . $versions['version'] . " matches database version " . $bdVersionCurrent);
        } else {
            error_log("===== Error : ENT Zend App version = " . $versions['version'] . " needs database version " . $versions['dependencies']['data-base-version']);
            error_log( "===== Your database version is " . $bdVersionCurrent);
        }
        return $isMatchBdVersion;
//        return array( $versions, $bdVersionEo);
    }
                
}

