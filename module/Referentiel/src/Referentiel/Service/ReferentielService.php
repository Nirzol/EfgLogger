<?php

namespace Referentiel\Service;

/**
 * Description of ReferentielService
 *
 * @author fandria
 */
class ReferentielService {
    
    protected $referentielSoap;

    public function __construct($referentielSoap) {
        $this->referentielSoap = $referentielSoap;
    }
    
    /* pwd compte de servce personnel */
    public function getOWAServiceAccount() {
        try {
            if (!is_null($this->referentielSoap)) {
                $pwd = $this->referentielSoap->getParametre('owa');

                return $pwd;
            }
        } catch (Exception $exc) {
//                echo $exc->getTraceAsString();
        }
    }
}
