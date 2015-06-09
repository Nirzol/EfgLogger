<?php

namespace Search\Model;

use Zend\Ldap\Ldap;

class Search {
    protected $options = array(
        'host'                  => 'ldap.parisdescartes.fr',
        'port'                  => '389',
        'username'              => 'cn=LectDev,ou=applications,dc=univ-paris5,dc=fr',
        'password'              => 'CyGuMiYo',
        'bindRequiresDn'        => true,
        'accountDomainName'     => 'parisdescartes.fr',
        'baseDn'                => 'ou=People,dc=univ-paris5,dc=fr',
    );
    
    public function ldapConnect() {
        $options = $this->options;
        
        $ldap = new Ldap($options);
        
        return $ldap;
    }
    
    public function searchUser($username) {
        $ldap = $this->ldapConnect();
        
        $searchUser = $ldap->searchEntries('(uid='.$username.')');
        
        return $searchUser;
    }
}

