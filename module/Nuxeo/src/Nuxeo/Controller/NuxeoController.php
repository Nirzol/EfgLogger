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
    
    public function getList()
    {
        
//        $requestId = $this->getRequest()->getQuery('id');
        
//        error_log("Request Id = " . $requestId);
        
//        $requestId = htmlspecialchars($requestId);
/*
        if (filter_var($nuxeoAutomationUrl, FILTER_VALIDATE_URL) === false) {
            
        }
        else {
            
        }
  
error_log(print_r($variable, TRUE));    
 */        
        $requestId = 1;
        
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
        
        error_log("Request Id = " . $requestId);
        
        return (new JsonModel(array("Request Id = " => $requestId, "Query" => $nxqlQuery)));
        
        
        if( !isset($nxqlQuery) /*OR isEmpty($nxqlQuery)*/) {
            $view->setVariable("result", $json);
            return ( $view);
        }
        else {    
            //echo "<br />Query : " . $nxqlQuery ."<br />";
            $session = new NuxeoSession($this->nuxeoAutomationUrl, 
                $this->nuxeoAdminUsername, $this->nuxeoAdminPassword,"Content-Type: application/json+nxrequest");

            $nuxeoRequest = $session->newRequest("Document.Query");

            $answer = $nuxeoRequest->set('params', 'query', $nxqlQuery);

            $answer = $answer->sendRequest();
//            var_dump($answer);
            // $documentsArray = $answer->getDocumentList();
            $documentsArray = $answer->objectsArrayToArrayOfArray();

            // var_dump($documentsArray);

            $json = json_encode($documentsArray);
        }
        
        return $view;
    }

}

