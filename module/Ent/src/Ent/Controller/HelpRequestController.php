<?php

namespace Ent\Controller;

use Ent\Form\HelpRequestForm;
use Ent\Entity\EntContact;
use Ent\Service\HelpRequestDoctrineService;
use Ent\Service\ContactDoctrineService;
use Ent\InputFilter\HelpRequestInputFilter;
use SearchLdap\Controller\SearchLdapController;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HelpRequestController extends AbstractActionController {

    /**
     * @var HelpRequestDoctrineService
     */
    protected $helpRequestService;
    
    /**
     *
     * @var ContactDoctrineService
     */
    protected $contactService;

    /**
     * @var Request
     */
    protected $request;
    
    /**
     *
     * @var HelpRequestForm
     */
    protected $helpRequestForm;
    
    /**
     *
     * @var HelpRequestInputFilter
     */
    protected $helpRequestInputFilter;
    
    /**
     *
     * @var SearchLdapController
     */
    protected $searchLdapController;

    public function __construct(ContactDoctrineService $contactService, HelpRequestDoctrineService $helpRequestService, HelpRequestForm $helpRequestForm, HelpRequestInputFilter $helpRequestInputFilter, SearchLdapController $searchLdapController) {
        $this->contactService = $contactService;
        $this->helpRequestService = $helpRequestService;
        $this->helpRequestForm = $helpRequestForm;
        $this->helpRequestInputFilter = $helpRequestInputFilter;
        $this->searchLdapController = $searchLdapController;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function sendAction() {
        $form = $this->helpRequestForm;

        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');

        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity()->getUserLogin();
            $infoUser = $this->searchLdapController->getUser($user);
        }

        $request = $this->request;
        
        if ($request->isPost()) {
            
            $form->setInputFilter($this->helpRequestInputFilter);

            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);
        
            if ($form->isValid()) {
                $form->getData();
                
                $body = $request->getPost('message');
                                              
                $filePaths = $_FILES['image-file']['tmp_name'];
                $fileNames = $_FILES['image-file']['name'];

                $senderMail = $infoUser['mail'][0];
                $senderName = $infoUser['displayname'][0];
                $senderService = $infoUser['ou'][0];
                //$senderPhone = $infoUser[0]['telephonenumber'][0];
                
                $id = (int) $request->getPost('contactDescription');
                
                /* @var $contact EntContact */
                $contact = $this->contactService->getById($id);
                $recipientMail = $contact->getContactMailto();
                $recipientName = $contact->getContactName();
                
                $subject = $contact->getContactDescription();
                
                $mailAlt = $request->getPost('email');
                
                if (!empty($mailAlt)) {
                    //$message = $body."\n" ."\n" ."**** INFORMATIONS SUPPLEMENTAIRES ****" . "\n" . "Nom : ".$senderName." \n "."Service : ".$senderService." \n "."Téléphone : ".$senderPhone." \n "."Mail alternatif : " .$mailAlt;
                    $message = $body."\n" ."\n" ."**** INFORMATIONS SUPPLEMENTAIRES ****" . "\n" . "Nom : ".$senderName." \n "."Service : ".$senderService." \n "."Mail alternatif : " .$mailAlt;
                } else {
                    //$message = $body."\n" ."\n" ."**** INFORMATIONS SUPPLEMENTAIRES ****" . "\n" . "Nom : ".$senderName." \n "."Service : ".$senderService." \n "."Téléphone : ".$senderPhone;
                    $message = $body."\n" ."\n" ."**** INFORMATIONS SUPPLEMENTAIRES ****" . "\n" . "Nom : ".$senderName." \n "."Service : ".$senderService;
                }
                               
                if (empty($fileNames[0]) && empty($filePaths[0])) {
                    $transport = $this->helpRequestService->sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName);
                } else {
                    $transport = $this->helpRequestService->sendWithImage($message, $filePaths, $fileNames, $senderMail, $senderName, $recipientMail, $recipientName, $subject);
                }
                
                if ($transport) {
                    $this->flashMessenger()->addSuccessMessage('Le mail de demande d\'aide a bien été envoyé');
                }
            } else {
                $this->flashMessenger()->addErrorMessage('Le mail de demande d\'aide n\'a pas été envoyé car le formulaire est invalide.');
            }

            return $this->redirect()->toRoute('help-request');
        }


        return new ViewModel(array(
            'form' => $form->prepare(),
            'infoUser' => $infoUser
        ));
    }

}
