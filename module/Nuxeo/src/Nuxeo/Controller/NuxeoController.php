<?php

namespace Nuxeo\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Nuxeo\Model\NuxeoSession;

/**
 * Les requetes doivent avoir ce format :
 *      /nuxeo/id=idRequest 
 * ou idRequest est l'index de la requette dans la classe Nuxeo\Controller\NXQLRequestConfig
 * 
 */
class NuxeoController extends AbstractRestfulController
{

    private $nuxeoAutomationUrl = "http://localhost:8080/nuxeo/site/automation";
    private $nuxeoAdminUsername = "Administrator";
    private $nuxeoAdminPassword = "Administrator";

    private $username = "Administrator";  // Current ENT user
    
    /**
     *  Action GET requests without resource Id : on lance toutes les requetes du tableau de bord
     *  
     * @return JsonModel
     */
    public function getList()
    {   
        $documentsArray = array();
        
        // A initialiser avec les id des requettes
        $idArray = array(1, 2);
        
        foreach ($idArray as $id) {
            $tmpArray = $this->getRequestDocuments($id);

            if ( !is_null($tmpArray) && (count($tmpArray) > 0)) {
                // Il faut un merge intelligent pour ne pas dupliquer les elements
                $documentsArray = array_merge($documentsArray, $tmpArray);
            }
        }
        
        return new JsonModel($documentsArray);
    }

    /**
     * Action GET requests with resource Id : on lance la requete numero id
     * @param type $id
     * @return type
     */
    public function get($id)
    {
        $requestId = $this->params('id');
        error_log("Request Id = " . $requestId);
        error_log(print_r($requestId, TRUE));    

        if ( !isset($requestId)) {
            return (new JsonModel(array("Error" => "parameter id manquant.")));
        }
        
        // Check nuxeo url is on
        /*
        if (filter_var($this->nuxeoAutomationUrl, FILTER_VALIDATE_URL) !== false) {
            return (new JsonModel(array("Error" => "Nuxeo server is down: " . $this->nuxeoAutomationUrl)));
        }
        */
        
        $documentsArray = $this->getRequestDocuments($id);

        return (new JsonModel($documentsArray));
        
    }

    public function getRequestDocuments($requestId) {
        
        $nxqlQuery = null;
        
        $requests = new NXQLRequestConfig();
        
        switch ($requestId) {
            case 1:
                $nxqlQuery = $requests->requestForDocumentsOfAutor($this->username);
                break;
            default:
                $nxqlQuery = $requests->requestForDocumentsOfAutor($this->username);
                break;
        }
        
        error_log("nxqlQuery = " . $nxqlQuery);
        
        $session = new NuxeoSession($this->nuxeoAutomationUrl, 
                $this->nuxeoAdminUsername, $this->nuxeoAdminPassword,"Content-Type: application/json+nxrequest");

        $nuxeoRequest = $session->newRequest("Document.Query");

        $answer = $nuxeoRequest->set('params', 'query', $nxqlQuery);

        $answer = $answer->sendRequest();
//            var_dump($answer);
        // $documentsArray = $answer->getDocumentList();
        $documentsArray = $answer->objectsArrayToArrayOfArray();

        return $documentsArray;
    }
}

