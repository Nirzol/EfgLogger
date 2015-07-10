<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Service\StatusDoctrineService;
use Zend\Http\Request;
use Ent\Form\StatusForm;

class StatusController extends AbstractActionController
{
    /**
     * @var StatusDoctrineService
     */
    protected $statusService;
    
    /**
     * @var Request
     */
    protected $request;
    
    public function __construct(StatusDoctrineService $statusService) {
        $this->statusService = $statusService;
    }
    
    public function listAction() {
        $listStatus = $this->statusService->getAll();
        
        return new ViewModel(array(
            'listStatus' => $listStatus
        ));
    }
    
    public function addAction() {
        $form = new StatusForm();
        
        if ($this->request->isPost()) {
            
            $status = $this->statusService->insert($form, $this->request->getPost());            
            
            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été ajouté.');
                
                return $this->redirect()->toRoute('status');
            }
            
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function showAction() {
        $id = (int) $this->params('id');
        
        $status = $this->statusService->getById($id);
        
        if (!$status) {
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'status' => $status
        ));
        
    }
    
    public function updateAction() {
        $id = (int) $this->params('id');
        $form = new StatusForm();
        
        if (!$id) {
            return $this->redirect()->toRoute('status');
        }
        
        $status = $this->statusService->getById($id, $form);
        
        if ($this->request->isPost()) {
            $status = $this->statusService->update($id, $form, $this->request->getPost());
            
            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été modifié.');
                
                return $this->redirect()->toRoute('status');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function deleteAction() {
        $id = (int) $this->params('id');
        
        if (!$id) {
            return $this->redirect()->toRoute('status');
        }
        
        $status = $this->statusService->getById($id);
        
        /* @var $request Request */
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->statusService->delete($id);
                
                $this->flashMessenger()->addSuccessMessage('Le status a bien été supprimé.');
            }
            
            return $this->redirect()->toRoute('status');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'status' => $status
        ));
    }
}
