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
        $roles = $this->roleService->getAll();

        return new ViewModel(array(
            'roles' => $roles,
        ));
    }

    public function addAction()
    {
        $form = $this->roleForm;
        $form->initParams(0); // Permet de gérer parent/child

        if ($this->request->isPost()) {
            $role = $this->roleService->insert($form, $this->request->getPost());

            if ($role) {
                $this->flashMessenger()->addSuccessMessage('Le role a bien été enregistré dans la base.');

                return $this->redirect()->toRoute('role');
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
        $id = $this->params('id');
        $form = $this->roleForm;
        $form->initParams($id); // Pour gérer parent/child
        $role = $this->roleService->getById($id, $form);

        if ($this->request->isPost()) {
            $user = $this->roleService->save($form, $this->request->getPost(), $role);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('Le role a bien été updaté.');

                return $this->redirect()->toRoute('role');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->roleService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le role a bien été supprimé.');

        return $this->redirect()->toRoute('role');
    }

}
