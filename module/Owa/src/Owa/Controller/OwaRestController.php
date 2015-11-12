<?php

namespace Owa\Controller;

use Owa\Model\Owa;
use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of OwaRestController
 *
 * @author fandria
 */
class OwaRestController extends AbstractRestfulController {
    
    /* @var $owa Owa */
    protected $owa;
    
    /* @var $searchLdapController SearchLdapController */
    protected $searchLdapController;

    public function __construct(SearchLdapController $searchLdapController, Owa $owa)
    {
        $this->owa = $owa;
        $this->searchLdapController = $searchLdapController;
    }

    public function getList()
    {
        $data = 'owa controller';
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
    
    public function getMailNotifAction() {
        
        $login = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $login = $authService->getIdentity()->getUserLogin();
        }

        $data = null;
        $success = false;
        $successMessage = '';
        $errorMessage = '';
        
        $mail = null;
        if (!is_null($login)) {
            $mail = $this->searchLdapController->getMailByUid($login);
            $owa = $this->owa;
            if (!is_null($owa)) {
                $owa->setImpersonation($mail);
                $mails = $owa->getUnreadMails();
                
                if (!is_null($mails)) {
                    $number = $owa->getNumberOfUnread($mails);
                
                    $data = $number;
                    $success = true;
                    $successMessage = 'ok';
                    $errorMessage = '';
                } else {
                    $errorMessage = 'Mails non récupérés';
                }
               
            }
        } else {
            $errorMessage = 'User non authentifié';
        }
        
        
        
        return new JsonModel(array(
            'number' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
    
    public function getCalendarNotifAction() {
        $data = 10;
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'number' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
}
