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
        
        // Recherche avec un filtre LDAP
        if((strpos($searchValue, "(") !== false) && (strpos($searchValue, "(") == 0 )) {
            $filter = $searchValue;
        } elseif((strpos($searchValue, "@parisdescartes.fr") || strpos($searchValue, "@etu.parisdescartes.fr")) !== false){
            // Recherche avec une adresse email
            $filter = "(mail=". $searchValue.")";
        } elseif(strpos($searchValue, " ")){
            // Recherche avec un nom prénom ou prénom nom
            $nomPrenom = explode(" ", $searchValue);
            $count = count($nomPrenom);
            
            // Recherche avec le cn
            $filterCn = "cn=";
            
            // Recherche avec le displayname
            $filterDn = "displayname=";
            
            for($i = 0; $i < $count; $i++) {
                if($i < $count-1) {
                    $filterCn .= "$nomPrenom[$i]"." ";
                    $filterDn .= "$nomPrenom[$i]"." ";
                } else {
                    $filterCn .= "$nomPrenom[$i]";
                    $filterDn .= "$nomPrenom[$i]";
                }
            }
            
            $filter = "(|($filterCn)($filterDn))";
        } else {
            // Recherche avec un uid ou un nom
            $filter = "(|(sn=" . $searchValue . "*)(uid=" . $searchValue . "*))";
        }
        
        $searchResult = $ldap->searchEntries($filter);
        
        return (count($searchResult) > 0 ? $searchResult : 0);
    }
}
