<?php

namespace SearchLdap\Model;

use Zend\Ldap\Ldap;

class SearchLdap {
    
    /* @var $ldap \Zend\Ldap\Ldap */
    protected $ldap;
    
    protected $searchLdapConfig;
    
    // Connexion LDAP direct into Factory
    public function __construct($ldap) {
        $this->ldap = $ldap;
    }

    /**
     * For Global search one or many user(s)
     * 
     * @param string $itemToSearch
     * @return array
     */
    public function searchUser($itemToSearch){
        $filter = '(|(cn=*'.$itemToSearch.'*)(givenname=*'.$itemToSearch.'*)(sn=*'.$itemToSearch.'*)(uid=*'.$itemToSearch.'*)(displayname=*'.$itemToSearch.'*)(mail=*'.$itemToSearch.'*))';
        
        $searchResult = $this->ldap->searchEntries($filter);
        
        $this->ldap->disconnect();
        
        return $searchResult;
    }

    /**
     * For specific search : one user. Filter By uid
     * 
     * @param string $uid
     * @return array
     */
    public function getUserInfo($uid){
        $filter = '(uid='.$uid.')';
        
        $justethese = array('memberOf', '*');
        
        $searchResult = $this->ldap->searchEntries($filter, null, 1, $justethese);
        
        $this->ldap->disconnect();
        
        return $searchResult[0];        
    }
    
//    private function ldapConnect() {
//        $options = $this->searchLdapConfig;
//        
//        $ldap = new Ldap($options);
//        
//        return $ldap;
//    }
          
//    public function searchUser($searchValue) {
////        $ldap = $this->ldapConnect();
//        $filter = "";
//        $nomPrenom = "";
//        $count = "";
//        $searchValues = [];
//        // Recherche avec un filtre LDAP
//        if((strpos($searchValue, "(") !== false) && (strpos($searchValue, "(") == 0 )) {
//            $filter = $searchValue;
//        } elseif((strpos($searchValue, "@parisdescartes.fr") || strpos($searchValue, "@etu.parisdescartes.fr")) !== false){
//            // Recherche avec une adresse email
//            $filter = "(mail=". $searchValue.")";
//        } elseif(strpos($searchValue, " ") !== false){
//            // Recherche avec un nom prénom ou prénom nom
//            $nomPrenom = explode(" ", $searchValue);
//            $count = count($nomPrenom);
//            
//            // Recherche avec le cn
//            $filterCn = "cn=";
//            
//            // Recherche avec le displayname
//            $filterDn = "displayname=";
//            
//            for($i = 0; $i < $count; $i++) {
//                if($i < $count-1) {
//                    $filterCn .= "$nomPrenom[$i]"." ";
//                    $filterDn .= "$nomPrenom[$i]"." ";
//                } else {
//                    $filterCn .= "$nomPrenom[$i]";
//                    $filterDn .= "$nomPrenom[$i]";
//                }
//            }
//            
//            $filter = "(|($filterCn)($filterDn))";
//        } else if(strpos($searchValue, "&") !== false) {
//            // Recherche avec filtre Personnel ou Etudiant
//            $searchValues = preg_split("/&/", $searchValue);
//            
//            if ($searchValues[1] === 'Personnel') {
//                // Pour le filtre Personnel, on recherche les personnes dont l'edupersonprimaryaffiliation est égale à staff ou faculty 
//                $filter = "(&(|(sn=".$searchValues[0]."*)(uid=".$searchValues[0]."))(|(edupersonprimaryaffiliation=staff)(edupersonprimaryaffiliation=faculty)))";
//            } else if ($searchValues[1] === 'Etudiant') {
//                $filter = "(&(|(sn=".$searchValues[0]."*)(uid=".$searchValues[0]."))(edupersonprimaryaffiliation=student))";
//            }
//        } else {
//            // Recherche avec un uid ou un nom
//            $filter = "(uid=" . $searchValue . ")";
//        }
//        
//        $searchResult = $ldap->searchEntries($filter);
//        
//        $ldap->disconnect();
//        
//        return (count($searchResult) > 0 ? $searchResult[0] : 0);
//    }
    
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
