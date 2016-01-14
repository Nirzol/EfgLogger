<?php

namespace Ent\Controller;

use Ent\Form\RoleForm;
use Ent\Service\RoleDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{

    /**
     * 
     * @var Request
     */
    protected $request = null;

    /**
     * 
     * @var RoleDoctrineService
     */
    protected $roleService = null;

    /**
     * 
     * @var RoleForm
     */
    protected $roleForm = null;

    public function __construct(RoleDoctrineService $roleService, RoleForm $roleForm)
    {
        $this->roleService = $roleService;
        $this->roleForm = $roleForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_role')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $roles = $this->roleService->getAll();

        return new ViewModel(array(
            'roles' => $roles,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_role')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $form = $this->roleForm;
        $form->initParams(0); // Permet de gérer parent/child

        if ($this->request->isPost()) {
            $role = $this->roleService->insert($form, $this->request->getPost());

            if ($role) {
                $this->flashMessenger()->addSuccessMessage('Le role a bien été enregistré dans la base.');

                return $this->redirect()->toRoute('zfcadmin/role');
            } else {
                $this->flashMessenger()->addErrorMessage('Un problème est survenu lors de l\'insertion du role ');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_role')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');

        $role = $this->roleService->getById($id);

        if (!$role) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'role' => $role,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_role')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');
        $form = $this->roleForm;
        $form->initParams($id); // Pour gérer parent/child
        $role = $this->roleService->getById($id, $form);

        if ($this->request->isPost()) {
            if($this->request->getPost()->get('permissions') == null){
                $this->request->getPost()->set('permissions', '');
            }
            $user = $this->roleService->save($form, $this->request->getPost(), $role);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('Le role a bien été updaté.');

                return $this->redirect()->toRoute('zfcadmin/role');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_role')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');

        $this->roleService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le role a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/role');
    }

}
