<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Ent\Service\RoleDoctrineService;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntHierarchicalRole;
use Ent\Form\RoleForm;

class RoleRestController extends AbstractRestfulController
{
    /**
     *
     * @var RoleDoctrineService
     */
    protected $service;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function __construct(RoleDoctrineService $aService, DoctrineObject $hydrator) {
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
            /* @var $result EntHierarchicalRole */
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
            /* @var $result EntHierarchicalRole */
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
                'success' => 'Le role a bien été supprimé.',
            ),
        ));
    }
    
    public function update($id, $data) {
        $form = new RoleForm();
        
        $roleFound = $this->service->getById($id, $form);
        
        if ($data) {
            $role = $this->service->update($id, $form, $data);
            
            if ($role) {
                $message = 'Le role a bien été modifié.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $role->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'RoleRestController.update: Le role n\'a pas été modifié. Role: ' . $roleFound.getName();
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
    public function create($data) {
        $form = new RoleForm();
        
        if ($data) {
            $role = $this->service->insert($form, $data);
            
            if ($role) {
                $message = 'Le role a bien été ajouté dans la base.';
                $this->flashMessenger()->addSuccessMessage($message);
                
                return new JsonModel(array(
                    'data' => $role->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => $message
                    ),
                ));
                
            }
        }
        
        $message = 'RoleRestController.create: Le role n\'a pas été ajouté.';
        error_log("===== Erreur: " . $message);
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => $message
            ),
        ));
    }
    
}

