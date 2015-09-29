<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntLog;
use Ent\Service\LogDoctrineService;

class LogRestController extends AbstractRestfulController
{
    /**
     *
     * @var LogDoctrineService
     */
    protected $service;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function __construct(LogDoctrineService $aService, DoctrineObject $hydrator) {
        $this->service = $aService;
        $this->hydrator = $hydrator;
    }
    
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

    public function getList() {
        $results = $this->service->getAll();
        
        $data = array();
        
        foreach ($results as $result) {
            /* @var $result EntLog */
            $data[] = $result->toArray($this->hydrator);
        }
        
        return new JsonModel(array(
            'data' => $data
        ));    
    }
    
    public function get($id) {
        
        $result = $this->service->getById($id);
        
        $data = array();
        
        if($result) {
            /* @var $result EntLog */
            $data[] = $result->toArray($this->hydrator);
        }
        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function delete($id) {
        $this->service->delete($id);
        
        $this->flashMessenger()->addSuccessMessage('L\'entrée Log a bien été supprimée.');
        
        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'L\'entrée Log a bien été supprimée.',
            ),
        ));
    }
    
/*    
    public function create($data) {
        $form = new LogForm();
        
        if ($data) {
            $log = $this->service->insert($form, $data);
            
            if ($log) {
                $message = 'Le log a bien été ajouté dans la base.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $log->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'LogRestController.create: Le log n\'a pas été ajouté.';
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
*/    
    
    public function create($data) {
        
        if ($data) {

            $eo = $this->service->insertArray($data);
            
            if ($eo) {
                $message = 'L\'entrée log a bien été ajoutée dans la base.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $eo->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'LogRestController.create: l\'entrée log n\'a pas été ajoutée dans la base.';
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
    public function update($id, $data) {
        
        
        if ($data && ($id != NULL)) {
            $logFound = $this->service->getById($id);
            $log = $this->service->update($id, $form, $data);
            
            if ($log) {
                $message = 'Le log a bien été modifiée.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $log->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'LogRestController.update: Le Log n\'a pas été modifié.';
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
}

