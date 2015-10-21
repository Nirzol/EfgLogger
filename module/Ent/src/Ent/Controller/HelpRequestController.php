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
    
    protected $searchLdapController;

    public function __construct(ContactDoctrineService $contactService, HelpRequestDoctrineService $helpRequestService, HelpRequestForm $helpRequestForm, SearchLdapController $searchLdapController) {
        $this->contactService = $contactService;
        $this->helpRequestService = $helpRequestService;
        $this->helpRequestForm = $helpRequestForm;
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
            
            $form = $this->helpRequestForm;
            $form->setInputFilter(new HelpRequestInputFilter());

            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);

            if ($form->isValid()) {
                $form->getData();                
                
                $body = $request->getPost('message');
                $filePath = $_FILES['image-file']['tmp_name'];
                $fileName = $_FILES['image-file']['name'];
                
                $senderMail = $infoUser[0]['mail'][0];
                $senderName = $infoUser[0]['displayname'][0];
                
                $id = (int) $request->getPost('contactDescription');
                
                /* @var $contact EntContact */
                $contact = $this->contactService->getById($id);
                $recipientMail = $contact->getContactMailto();
                $recipientName = $contact->getContactName();
                
                $subject = $contact->getContactDescription();
                
                $mailAlt = $request->getPost('email');
                
                if (empty($mailAlt)) {
                    $message = $body;
                } else {
                    $message = $body.' Mail alternatif : '.$mailAlt;
                }
                               
                if (empty($filePath) && empty($fileName)) {
                    $transport = $this->helpRequestService->sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName);
                } else {
                    $transport = $this->helpRequestService->sendWithImage($message, $filePath, $fileName, $senderMail, $senderName, $recipientMail, $recipientName, $subject);
                }
                
                if ($transport) {
                    $this->flashMessenger()->addSuccessMessage('Le mail de demande d\'aide a bien été envoyé');
                }
            } else {
                $this->flashMessenger()->addSuccessMessage('Le mail de demande d\'aide n\'a pas été envoyé car le formulaire est invalide.');
            }

            return $this->redirect()->toRoute('help-request');
        }


        return new ViewModel(array(
            'form' => $form->prepare(),
            'infoUser' => $infoUser
        ));
    }

}
