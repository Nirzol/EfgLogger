<?php

namespace Ent\Controller;

use Ent\Service\HelpRequestDoctrineService;
use Ent\Service\ContactDoctrineService;
use Ent\Form\HelpRequestForm;
use Ent\InputFilter\HelpRequestInputFilter;
use SearchLdap\Controller\SearchLdapController;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Description of HelpRequestRestController
 *
 * @author mdjimbi
 */

class HelpRequestRestController extends AbstractRestfulController
{
    
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
    
    public function options()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();

        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )))->addHeaderLine('Content-Type','application/json; charset=utf-8');

        return $response;
    }
    
    public function __construct(ContactDoctrineService $contactService, HelpRequestDoctrineService $helpRequestService, HelpRequestForm $helpRequestForm, HelpRequestInputFilter $helpRequestInputFilter , SearchLdapController $searchLdapController) {
        $this->contactService = $contactService;
        $this->helpRequestService = $helpRequestService;
        $this->helpRequestForm = $helpRequestForm;
        $this->helpRequestInputFilter = $helpRequestInputFilter;
        $this->searchLdapController = $searchLdapController;
    }

    public function getList() {
        $data = 0;

        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function get($slug) {
        
        return new JsonModel(array(
            'data' => $slug
        ));
    }
    
    public function create($data) {
        
        if ($data) {
            
            $form = $this->helpRequestForm;
            $form->setInputFilter($this->helpRequestInputFilter);
            
            $form->setData($data);
            
            if($form->isValid()) {
                $form->getData();
                $subject = $data['subject'];
                $message = $data['messageplus'];
                $senderMail = $data['senderMail'];
                $senderName = $data['senderName'];
                $recipientMail = $data['recipientMail'];
                $recipientName = $data['recipientName'];

                // On compte le nombre fichiers à envoyer
                $countFiles = count($_FILES);

                if(count($_FILES) > 0) {
                    // Si on a un ou plusieurs fichiers à envoyer
                    for($i = 0; $i < $countFiles; $i++) {
                        $filePaths[] = $_FILES['file'.$i]['tmp_name'];
                        $fileNames[] = $_FILES['file'.$i]['name'];
                    }
                    $transport = $this->helpRequestService->sendWithImage($message, $filePaths, $fileNames, $senderMail, $senderName, $recipientMail, $recipientName, $subject);
                } else {
                    // Si on n'a pas de fichiers à envoyer
                    $transport = $this->helpRequestService->sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName);
                }

                if ($transport) {
                    $this->flashMessenger()->addSuccessMessage('Le mail de demande d\'aide a bien été envoyé.');

                    return new JsonModel(array(
                        'data' => $data,
                        'success' => true,
                        'flashMessages' => array(
                            'success' => 'Le mail de demande d\'aide a bien été envoyé.',
                        ),
                    ));
                }
            } else {
                $error = $form->getMessages();
            }
            
            
        }
               
        return new JsonModel(array(
            'success' => false,
            'error' => $error,
            'flashMessages' => array(
                'error' => 'Le mail de demande d\'aide n\'a pas été envoyé.',
            ),
        ));
        
//        return new JsonModel(array(
//            'data' => $data
//        ));
    }
}
