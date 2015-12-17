<?php

namespace Referentiel\Controller\Plugin;

use Referentiel\Model\Encryption;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Description of ReferentielPlugin
 *
 * @author fandria
 */
class ReferentielPlugin extends AbstractPlugin {
    
    public function getOwaAccount($username, $password) {
        $code = $username.$password;
        
        $decode = Encryption::decode($code);
        $pieces = explode('/', $decode);
        
        $credential = array($pieces[0], $pieces[1]);
        return $credential;
    }


//    public function getOWAServiceAccount($configRef, $config) {
//        $dataFromRef = $this->getAccountFromRef($configRef);
//        
//        if (!is_null($dataFromRef)) {
//            $code = $config.$dataFromRef;
//            
//            $decode = Encryption::decode($code);
//            $pieces = explode('/', $decode);
//
//            $credential = array($pieces[0], $pieces[1]);
//            return $credential;
//        }
//        return null;
//    }
//    
//    private function getAccountFromRef($fromRef) {
//        $client = new Client($fromRef);
//        try {
//            if (!is_null($client)) {
//                $pwd = $client->getParametre('owa');
//
//                return $pwd;
//            }
//        } catch (Exception $exc) {
//            return null;
////                echo $exc->getTraceAsString();
//        }
//    }
}
