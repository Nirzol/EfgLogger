<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Ent\Service\VersionDoctrineService;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntVersion;

class VersionRestController extends AbstractRestfulController
{
    /**
     *
     * @var VersionDoctrineService
     */
    protected $service;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function __construct(VersionDoctrineService $aService, DoctrineObject $hydrator) {
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
            /* @var $result EntVersion */
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
            /* @var $result EntVersion */
            $data[] = $result->toArray($this->hydrator);
        }
        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function delete($id) {
        $this->service->delete($id);
        
        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');
        
        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'La Version a bien été supprimée.',
            ),
        ));
    }
    
    public function update($id, $data) {
        $form = new VersionForm();
        
        $versionFound = $this->service->getById($id, $form);
        
        if ($data) {
            $version = $this->service->update($id, $form, $data);
            
            if ($version) {
                $message = 'La version a bien été modifiée.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $version->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'VersionRestController.create: La version n\'a pas été modifiée. Version: ' . $versionFound.toString();
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
    public function create($data) {
        $form = new VersionForm();
        
        if ($data) {
            $version = $this->service->insert($form, $data);
            
            if ($version) {
                $message = 'La version a bien été ajoutée dans la base.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $version->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'VersionRestController.create: La version n\'a pas été ajoutée.';
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
}

