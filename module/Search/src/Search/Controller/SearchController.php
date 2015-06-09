<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Search\Model\Search;

class SearchController extends AbstractActionController {
    /**
     *
     * @var \Zend\Http\Request
     */
    protected $request;
    
    public function indexAction() {        
        
        $accueil = 'Bienvenue sur la page de recherche LDAP'; 
        
        return new JsonModel(array(
            'data' => $accueil
        ));
    }
    
    public function searchuidAction() {
        $uid = $this->params()->fromRoute('uid');
        
        $ldap= new Search();
        
        $ldap->ldapConnect();
        
        $searchUser = $ldap->searchUser($uid);
        
        return new JsonModel(array(
            'user' => $searchUser
        ));
    }
}

