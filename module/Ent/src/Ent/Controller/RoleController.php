<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Entity\EntHierarchicalRole;
use Ent\Form\RoleForm;
use Ent\Service\RoleDoctrineService;

class RoleController extends AbstractActionController
{
    /**
     * @var RoleForm
     */
    protected $roleForm = null;
 
    /**
     * @var RoleDoctrineService
     */
    protected $service = null;
    
    public function __construct(RoleDoctrineService $roleService, RoleForm $roleForm)
    {
        $this->service = $roleService;
        $this->roleForm = $roleForm;
    }
    
    public function listAction()
    {
        $roles = $this->service->getAll();

        return new ViewModel(array(
            'roles' => $roles,
        ));
    }
    
    public function addAction()
    {
        $form = new RoleForm();

        if ($this->request->isPost()) {

            $role = $this->service->insert($form, $this->request->getPost());   
            
            if ($role) {
                $this->flashMessenger()->addSuccessMessage('Le nouveau role a bien été enregistré dans la base.');
            } else {
                $this->flashMessenger()->addErrorMessage('Un problème est survenu lors de l\'insertion du role: ' . $role->getName());
            }
            return $this->redirect()->toRoute('role');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('role');
        }
        
        $role = $this->service->getById($id);
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->service->delete($id);
            }
            
            return $this->redirect()->toRoute('role');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'role' => $role
        ));
    }
 

/*

    public function updateAction()
    {
        $id = (int) $this->params('id');
        $form = new VersionForm();
        
        if (!$id) {
            return $this->redirect()->toRoute('version');
        }
        
        // Alimente le formulaire a prtir de l'id eo
        $versionFound = $this->service->getById($id, $form);
        
        if ($this->request->isPost()) {
            $version = $this->service->update($id, $form, $this->request->getPost());
            
            if ($version) {
                $this->flashMessenger()->addSuccessMessage('La version a bien été modifiée dans la base.');
                
                return $this->redirect()->toRoute('version');
            } else {
                $this->flashMessenger()->addErrorMessage('Un problème est survenu lors de la mise a jour de la version: ' . $versionFound->toString());
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'version' => $versionFound
        ));
        
    }

    public function showAction()
    {
        $id = $this->params('id');

        $version = $this->service->getById($id);        
        
        if (!$version) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'version' => $version
        ));
    }

    */
}

