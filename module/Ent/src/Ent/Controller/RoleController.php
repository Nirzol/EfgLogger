<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{

    /**
     * @var RoleForm
     */
    protected $roleForm = null;

    public function __construct(\Ent\Service\RoleDoctrineService $roleService, \Ent\Form\RoleForm $roleForm)
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
//        $form = $this->roleForm;
//
//        if ($this->request->isPost()) {
//            $data = $this->request->getPost();
//            $role = $this->roleService->insert($form, $data);
//
//            if ($role) {
//                $this->flashMessenger()->addSuccessMessage('Le role a bien été insérer.');
//
//                return $this->redirect()->toRoute('role');
//            }
//        }
//
//        return new ViewModel(array(
//            'form' => $form->prepare(),
//        ));
        return new ViewModel();
    }


}

