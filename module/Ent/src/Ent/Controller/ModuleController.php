<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Service\ModuleDoctrineService;
use Zend\Http\Request;
use Ent\Form\ModuleForm;

class ModuleController extends AbstractActionController {

    /**
     * @var ModuleDoctrineService
     */
    protected $moduleService;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(ModuleDoctrineService $moduleService) {
        $this->moduleService = $moduleService;
    }

    public function listAction() {
        $listModules = $this->moduleService->getAll();

        return new ViewModel(array(
            'listModules' => $listModules
        ));
    }

    public function addAction() {
        $form = new ModuleForm();
        
        if ($this->request->isPost()) {

            $module = $this->moduleService->insert($form, $this->request->getPost());            
            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été ajouté.');
                
                return $this->redirect()->toRoute('module');
            }
            
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function showAction() {
        $id = $this->params('id');

        $module = $this->moduleService->getById($id);        
        
        if (!$module) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'module' => $module
        ));
    }

    public function updateAction() {
        $id = (int) $this->params('id');
        $form = new ModuleForm();
        
        if (!$id) {
            return $this->redirect()->toRoute('module');
        }
        
        $module = $this->moduleService->getById($id, $form);                      
        
        if ($this->request->isPost()) {
            $module = $this->moduleService->update($id, $form, $this->request->getPost());
            
            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été modifié.');
                
                return $this->redirect()->toRoute('module');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deleteAction() {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('module');
        }
        
        $module = $this->moduleService->getById($id);
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->moduleService->delete($id);
            }
            
            return $this->redirect()->toRoute('module');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'module' => $module
        ));
    }

}
