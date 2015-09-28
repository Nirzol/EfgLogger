<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PermissionController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return \Ent\Service\PermissionDoctrineService
     */
    protected $permissionService = null;

    /**
     * @var \Ent\Form\PermissionForm
     */
    protected $permissionForm = null;

    public function __construct(\Ent\Service\PermissionDoctrineService $permissionService, \Ent\Form\PermissionForm $permissionForm)
    {
        $this->permissionService = $permissionService;
        $this->permissionForm = $permissionForm;
    }

    public function listAction()
    {
        $permissions = $this->permissionService->getAll();

        return new ViewModel(array(
            'permissions' => $permissions,
        ));
    }

    public function addAction()
    {
        $form = $this->permissionForm;

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $permission = $this->permissionService->insert($form, $data);

            if ($permission) {
                $this->flashMessenger()->addSuccessMessage('La permission a bien été insérer.');

                return $this->redirect()->toRoute('permission');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $permission = $this->permissionService->getById($id);

        if (!$permission) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'permission' => $permission,
        ));
    }

    public function modifyAction()
    {
        $id = $this->params('id');
        $form = $this->permissionForm;
        $permission = $this->permissionService->getById($id, $form);

        if ($this->request->isPost()) {
            $permission = $this->permissionService->save($form, $this->request->getPost(), $permission);

            if ($permission) {
                $this->flashMessenger()->addSuccessMessage('La permission  a bien été updaté.');

                return $this->redirect()->toRoute('permission');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->permissionService->delete($id);

        $this->flashMessenger()->addSuccessMessage('La permission a bien été supprimé.');

        return $this->redirect()->toRoute('permission');
    }

}
