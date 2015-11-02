<?php

namespace Ent\Controller;

use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of InfoRestController
 *
 * @author mdjimbi
 */
class InfoRestController extends AbstractRestfulController
{
    /* @var $searchLdapController SearchLdapController */

    protected $searchLdapController;

    public function options()
    {
        $response = $this->getResponse();
        $headers = $response->getHeaders();

        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    public function __construct(SearchLdapController $searchLdapController)
    {
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
            $infoUser = 'Utilisateur Inconnu';
        }

        return new JsonModel(array(
            'infoUser' => $infoUser
        ));
    }

    public function getMailHostAction() {
        $login = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $login = $authService->getIdentity()->getUserLogin();
        }
        
        $success = false;
        $successMessage = '';
        $errorMessage = '';
        $affiliation = null;
        
        if (!is_null($login)) {
            $affiliation = $this->searchLdapController->getMailHostByUid($login);
        }

        if (!is_null($affiliation)) {
            $success = true;
            $successMessage = 'Le mailhost user a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le mailhost user n\'existe pas.';
        }
        
        return new JsonModel(array(
            'data' => $affiliation,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
}
