<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use SearchLdap\Controller\SearchLdapController;

/**
 * Description of InfoRestController
 *
 * @author mdjimbi
 */
class InfoRestController extends AbstractRestfulController
{
    /* @var $searchLdapController SearchLdapController */
    protected $searchLdapController;
    
    public function __construct(SearchLdapController $searchLdapController) {
        $this->searchLdapController = $searchLdapController;
    }
    
    public function getList()
    {
        $user = '';
        $infoUser = '';
        
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity()->getUserLogin();
            $infoUser = $this->searchLdapController->getUser($user);
        } else {
            $infoUser= 'Utilisateur Inconnu';
        }
        
        return new JsonModel(array(
            'infoUser' => $infoUser
        ));
    }
}
