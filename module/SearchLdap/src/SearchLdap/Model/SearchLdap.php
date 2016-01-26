<?php

namespace SearchLdap\Model;

use Zend\Ldap\Ldap;

class SearchLdap {
    
//    protected $options = array(
//        'host'                  => 'ldap.parisdescartes.fr',
//        'port'                  => '389',
//        'username'              => 'cn=LectDev,ou=applications,dc=univ-paris5,dc=fr',
//        'password'              => 'CyGuMiYo',
//        'bindRequiresDn'        => true,
//        'accountDomainName'     => 'parisdescartes.fr',
//        'baseDn'                => 'ou=People,dc=univ-paris5,dc=fr',
//    );
    
    protected $searchLdapConfig;
    
    public function __construct($searchLdapConfig) {
        $this->searchLdapConfig = $searchLdapConfig;
    }
    
    private function ldapConnect() {
        $options = $this->searchLdapConfig;
        
        $ldap = new Ldap($options);
        
        return $ldap;
    }
          
    public function searchUser($searchValue) {
        $ldap = $this->ldapConnect();
        $filter = "";
        $nomPrenom = "";
        $count = "";
        $searchValues = [];
        // Recherche avec un filtre LDAP
        if((strpos($searchValue, "(") !== false) && (strpos($searchValue, "(") == 0 )) {
            $filter = $searchValue;
        } elseif((strpos($searchValue, "@parisdescartes.fr") || strpos($searchValue, "@etu.parisdescartes.fr")) !== false){
            // Recherche avec une adresse email
            $filter = "(mail=". $searchValue.")";
        } elseif(strpos($searchValue, " ") !== false){
            // Recherche avec un nom prénom ou prénom nom           
            $filter = "(|(cn=".$searchValue.")(displayName=".$searchValue."))";
        } else if(strpos($searchValue, "&") !== false) {
            // Recherche avec filtre Personnel ou Etudiant
            $searchValues = preg_split("/&/", $searchValue);
            
            if ($searchValues[1] === 'Personnel') {
                // Pour le filtre Personnel, on recherche les personnes dont l'edupersonprimaryaffiliation est égale à staff ou faculty 
                $filter = "(&(|(sn=".$searchValues[0]."*)(uid=".$searchValues[0]."))(|(edupersonprimaryaffiliation=staff)(edupersonprimaryaffiliation=faculty)))";
            } else if ($searchValues[1] === 'Etudiant') {
                $filter = "(&(|(sn=".$searchValues[0]."*)(uid=".$searchValues[0]."))(edupersonprimaryaffiliation=student))";
            }
        } else {
            // Recherche avec un uid ou un nom
            $filter = "(uid=" . $searchValue . ")";
        }
        
        $searchResult = $ldap->searchEntries($filter);
        
        $ldap->disconnect();
        
        return (count($searchResult) > 0 ? $searchResult[0] : 0);
    }
    
    public function getPrimaryAffiliationByUid($uid) {
        $ldap = $this->ldapConnect();
        
        $filter = "(uid=" . $uid . ")";
        
        $searchResult = $ldap->searchEntries($filter);
        if (!empty($searchResult)) {
            $ldap->disconnect();
            return ($searchResult[0]['edupersonprimaryaffiliation']) ? $searchResult[0]['edupersonprimaryaffiliation'][0] : null;
        }
        
        return null;
        
    }
    
    public function getMailHostByUid($uid) {
        $ldap = $this->ldapConnect();
        
        $filter = "(uid=" . $uid . ")";
        
        $searchResult = $ldap->searchEntries($filter);
        if (!empty($searchResult)) {
            $ldap->disconnect();
            return ($searchResult[0]['mailhost']) ? $searchResult[0]['mailhost'][0] : null;
        }
        
        return null;
        
    }
    
    public function getMailByUid($uid) {
        $ldap = $this->ldapConnect();
        
        $filter = "(uid=" . $uid . ")";
        
        $searchResult = $ldap->searchEntries($filter);
        if (!empty($searchResult)) {
            $ldap->disconnect();
            return ($searchResult[0]['mail']) ? $searchResult[0]['mail'][0] : null;
        }
        
        return null;
    } 
}
