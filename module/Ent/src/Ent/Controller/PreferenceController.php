<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Ent\Form\PreferenceForm;
use Ent\Service\PreferenceDoctrineService;

class PreferenceController extends AbstractActionController
{
    /**
     *
     * @var Request
     */
    protected $request;
    
    /**
     *
     * @var PreferenceDoctrineService
     */
    protected $preferenceService;
    
    /**
     *
     * @var PreferenceForm
     */
    protected $preferenceForm;
    
    public function __construct(PreferenceDoctrineService $preferenceService, PreferenceForm $preferenceForm) {
        $this->preferenceService = $preferenceService;
        $this->preferenceForm = $preferenceForm;
    }
    
    public function listAction() {
        $preferences = $this->preferenceService->getAll();
        
        return new ViewModel(array(
            'preferences' => $preferences
        ));
    }
    
    public function addAction() {
        $form = $this->preferenceForm;
        
        if ($this->request->isPost()) {
            $preference = $this->preferenceService->insert($form, $this->request->getPost());
            
            if ($preference) {
                $this->flashMessenger()->addSuccessMessage('La préférence a bien été ajoutée.');
                
                return $this->redirect()->toRoute('preference');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function showAction() {
        $id = (int) $this->params('id');
        
        $preference = $this->preferenceService->getById($id);
        
        if (!$preference) {
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'preference' => $preference
        ));
    }
    
    public function updateAction() {
        $id = (int) $this->params('id');
        $form = $this->preferenceForm;
        $preference = $this->preferenceService->getById($id, $form);
        
        if ($this->request->isPost()) {
            $preference = $this->preferenceService->udpate($id, $form, $this->request->getPost());
            
            if ($preference) {
                $this->flashMessenger()->addSuccessMessage('La préférence a bien été modifiée.');
                
                return $this->redirect()->toRoute('preference');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function deleteAction() {
        $id = (int) $this->params('id');
        
        if (!$id) {
            $this->redirect()->toRoute('preference');
        }
        
        $preference = $this->preferenceService->getById($id);
        
        if ($this->request->isPost()) {
            $del = $this->request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $this->request->getPost('id');
                $this->preferenceService->delete($id);
                
                $this->flashMessenger()->addSuccessMessage('La préférence a bien été supprimée.');
            }
            
            return $this->redirect()->toRoute('preference');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'preference' => $preference
        ));
    }
}
