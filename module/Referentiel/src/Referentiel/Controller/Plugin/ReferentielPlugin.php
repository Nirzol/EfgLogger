<?php

namespace Referentiel\Controller\Plugin;

use Exception;
use Referentiel\Model\Encryption;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Soap\Client;

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
    
    public function getAccountFromRef($fromRef) {
        $client = new Client($fromRef);
        try {
            if (!is_null($client)) {
                $pwd = $client->getParametre('love');

                return $pwd;
            }
        } catch (Exception $exc) {
            return null;
//                echo $exc->getTraceAsString();
        }
    }
}
