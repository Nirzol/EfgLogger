<?php

namespace Ent\Controller;

use Ent\Service\LoveDoctrineService;
use Owa\Controller\Plugin\OwaPlugin;
use PhpEws\EwsConnection;
use Referentiel\Controller\Plugin\ReferentielPlugin;
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

//    protected $searchLdapController;

    /* @var $ews EwsConnection */

    protected $ews;

    /* @var $loveService LoveDoctrineService */
    protected $loveService;
    protected $referentielWsdl;
    protected $owaConfig;

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

//    public function __construct(SearchLdapController $searchLdapController, LoveDoctrineService $loveService, $referentielWsdl, $owaConfig)
    public function __construct(LoveDoctrineService $loveService, $referentielWsdl, $owaConfig)
    {
//        $this->searchLdapController = $searchLdapController;
        $this->loveService = $loveService;
        $this->referentielWsdl = $referentielWsdl;
        $this->owaConfig = $owaConfig;
    }

    public function getList()
    {
        $user = '';
        $infoUser = '';
        $success = false;
        $successMessage = '';
        $errorMessage = '';

        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity()->getUserLogin();
//            $infoUser = $this->searchLdapController->getUser($user);
            $infoUser = $this->SearchLdapPlugin()->getUserInfo($user);
            $success = true;
            $successMessage = 'Les infos ont bien été trouvées';
        } else {
            $success = false;
            $infoUser = null;
            $errorMessage = 'Utilisateur Inconnu';
        }

        return new JsonModel(array(
            'infoUser' => $infoUser,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }

    public function getMailHostAction()
    {
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
//            $affiliation = $this->searchLdapController->getMailHostByUid($login);
            $affiliation = $this->SearchLdapPlugin()->getMailHostByUid($login);
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

    public function getNotifsAction()
    {
        $login = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $login = $authService->getIdentity()->getUserLogin();
        }

//        if ($this->efgCasAuthPlugin()->hasIdentity()) {
//            $login = $this->efgCasAuthPlugin()->getIdentity()->getUserLogin();
//        }

        $data = null;
        $success = false;
        $successMessage = '';
        $errorMessage = '';

        /* notif mail */
        $mail = null;
        if (!is_null($login)) {
//            $mailHost = $this->searchLdapController->getMailHostByUid($login);
            $mailHost = $this->SearchLdapPlugin()->getMailHostByUid($login);

            if (!is_null($mailHost)) {

                if (strcmp($mailHost, 'mataram.parisdescartes.fr') !== 0) {
//                if ($mailHost === $this->owaConfig['mataram']) {
//                    $mail = $this->searchLdapController->getMailByUid($login);
                    $mail = $this->SearchLdapPlugin()->getMailByUid($login);

                    /* @var $referentielPlugin ReferentielPlugin */
                    $referentielPlugin = $this->ReferentielPlugin();

                    $pOwa = $referentielPlugin->getAccountFromRef($this->referentielWsdl);
                    $love = $this->loveService->getAll();
                    $lOwa = '';
                    foreach ($love as $value) {
                        $lOwa = $value->getLoveLove();
                    }
                    if (!is_null($pOwa)) {
                        $accountOwa = $referentielPlugin->getOwaAccount($lOwa, $pOwa);

                        $ews = new EwsConnection($this->owaConfig['host'], $accountOwa[0], $accountOwa[1], $this->owaConfig['version']);

                        /* @var $owaPlugin OwaPlugin */
                        $owaPlugin = $this->OwaPlugin();
                        $number = $owaPlugin->getNotifMail($ews, $mail);

                        $data['mail'] = $number;
                        $success = true;
                        $successMessage = 'ok';
                        $errorMessage = '';
                    } else {
                        $errorMessage = 'Referentiel error';
                    }
                } else {
                    $errorMessage = 'User uses mataram';
                }
            } else {
                $errorMessage = 'User no mailhost';
            }
        } else {
            $errorMessage = 'User non authentifié';
        }

        return new JsonModel(array(
            'notifs' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }

}
