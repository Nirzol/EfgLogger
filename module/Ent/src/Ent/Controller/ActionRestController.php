<?php

namespace Ent\Controller;

use Ent\Entity\EntAction;
use Ent\Entity\Ent;
use Ent\Form\ActionForm;
use Ent\Service\ActionDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\View\Model\JsonModel;

class ActionRestController extends AbstractRestfulController
{
    /**
     *
     * @var ActionDoctrineService
     */
    protected $actionService;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;
    
    public function __construct(ActionDoctrineService $actionService, DoctrineObject $hydrator) {
        $this->actionService = $actionService;
        $this->hydrator = $hydrator;
    }
    
    public function getList() {
        $results = $this->actionService->getAll();
        
        $data = array();
        
        foreach ($results as $result) {
            /* @var $result Ent */
            $data[] = $result->toArray($this->hydrator);
        }
        
        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function get($id) {
        $result = $this->actionService->getById($id);
        
        $data = array();
        
        if ($result) {
            /* @var $result Ent */
            $data[] = $result->toArray($this->hydrator);
        }
        
        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function create($data) {
        $form = new ActionForm();
        
        if ($data) {
            $action = $this->actionService->insert($form, $data);
            
            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\' action a bien été ajoutée.');
                
                return new JsonModel(array(
                    'data' => $action->getActionId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\' action a bien été ajoutée.'
                    ),
                ));
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\' action n\'a pas été ajoutée.'
            ),
        ));
    }
    
    public function update($id, $data) {
        $form = new ActionForm();
        
        $action = $this->actionService->getById($id, $form);
        
        if ($data) {
            $action = $this->actionService->update($id, $form, $data);
            
            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\' action a bien été modifiée.');
                
                return new JsonModel(array(
                    'data' => $action->getActionId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\' action a bien été modifiée.'
                    ),
                ));
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\' action n\'a pas été modifiée.'
            ),
        ));
    }
    
    public function delete($id) {
        $this->actionService->delete($id);
        
        $this->flashMessenger()->addSuccessMessage('L\' action a bien été supprimée.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'L\' action a bien été supprimée.'
            ),
        ));
    }
}
