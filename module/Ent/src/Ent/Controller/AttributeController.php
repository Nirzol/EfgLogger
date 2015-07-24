<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Ent\Form\AttributeForm;
use Ent\Service\AttributeDoctrineService;

class AttributeController extends AbstractActionController
{
    /**
     *
     * @var AttributeDoctrineService
     */
    protected $attributeService;
    
    /**
     *
     * @var Request
     */
    protected $request;
    
    /**
     *
     * @var AttributeForm
     */
    protected $attributeForm;


    public function __construct(AttributeDoctrineService $attributeService, AttributeForm $attributeForm) {
        $this->attributeService = $attributeService;
        $this->attributeForm = $attributeForm;
    }
    
    public function listAction() {
        $listAttritutes = $this->attributeService->getAll();
        
        return new ViewModel(array(
            'listAttributes' => $listAttritutes
        ));
    }
    
    public function addAction() {
        $form = $this->attributeForm;
        
        if ($this->request->isPost()) {
            $attribute = $this->attributeService->insert($form, $this->request->getPost());
            
            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été ajouté.');
                
                return $this->redirect()->toRoute('attribute');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function showAction() {
        $id = (int) $this->params('id');
        
        $attribute = $this->attributeService->getById($id);
        
        if (!$attribute) {
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'attribute' => $attribute
        ));
    }
    
    public function updateAction() {
        $id = (int) $this->params('id');
        $form = $this->attributeForm;
        
        $attribute = $this->attributeService->getById($id, $form);
        
        if ($this->request->isPost()) {
            $attribute = $this->attributeService->udpate($id, $form, $this->request->getPost());
            
            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été modifié.');
                
                return $this->redirect()->toRoute('attribute');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function deleteAction() {
        $id = (int) $this->params('id');
        
        if (!$id) {
            $this->redirect()->toRoute('attribute');
        }
        
        $attribute = $this->attributeService->getById($id);
        
        if ($this->request->isPost()) {
            $del = $this->request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $this->request->getPost('id');
                $this->attributeService->delete($id);
                
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été supprimé.');
            }
            
            return $this->redirect()->toRoute('attribute');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'attribute' => $attribute
        ));
    }
}
