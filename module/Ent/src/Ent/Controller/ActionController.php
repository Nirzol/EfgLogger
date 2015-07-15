<?php

namespace Ent\Controller;

use Ent\Service\ActionDoctrineService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Ent\Form\ActionForm;

class ActionController extends AbstractActionController
{
    /**
     *
     * @var ActionDoctrineService
     */
    protected $actionService;
    
    /**
     *
     * @var Request
     */
    protected $request;
    
    public function __construct(ActionDoctrineService $actionService) {
        $this->actionService = $actionService;
    }
    
    public function listAction() {
        $listActions = $this->actionService->getAll();
        
        return new ViewModel(array(
            'listActions' => $listActions
        ));
    }
    
    public function addAction() {
        $form = new ActionForm();
        
        if ($this->request->isPost()) {
            $action = $this->actionService->insert($form, $this->request->getPost());
            
            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\'action a bien été ajoutée');
                
                return $this->redirect()->toRoute('action');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function showAction() {
        $id = (int) $this->params('id');
        
        $action = $this->actionService->getById($id);
        
        if (!$action) {
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'action' => $action
        ));
    }
    
    public function updateAction() {
        $id = (int) $this->params('id');
        $form = new ActionForm();
        
        if (!$id) {
            return $this->redirect()->toRoute('action');
        }
        
        $action = $this->actionService->getById($id, $form);
        
        if ($this->request->isPost()) {
            $action = $this->actionService->update($id, $form, $this->request->getPost());
            
            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\'action a bien été modifiée');
                
                return $this->redirect()->toRoute('action');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function deleteAction() {
        $id = (int) $this->params('id');
        
        if (!$id) {
            return $this->redirect()->toRoute('action');
        }
        
        $action = $this->actionService->getById($id);
        
        $request = $this->request;
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->actionService->delete($id);
                
                $this->flashMessenger()->addSuccessMessage('L\'action a bien été supprimée');
            }
            
            return $this->redirect()->toRoute('action');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'action' => $action
        ));
    }
}
