<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return UserDoctrineService
     */
    protected $userService = null;

    /**
     * @var UserForm
     */
    protected $userForm = null;

    public function __construct(\Ent\Service\UserDoctrineService $userService, \Ent\Form\UserForm $userForm)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
    }

    public function listAction()
    {
        $users = $this->userService->getAll();

        return new ViewModel(array(
            'users' => $users,
        ));
    }

    public function addAction()
    {
        $form = $this->userForm;

        if ($this->request->isPost()) {
            $user = $this->userService->insert($form, $this->request->getPost());
//            $user = $this->userService->save($form, $this->request->getPost(), null);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');

                return $this->redirect()->toRoute('user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $user = $this->userService->getById($id);

        if (!$user) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'user' => $user,
        ));
    }

    public function modifyAction()
    {
        $id = $this->params('id');
        $form = $this->userForm;
        $user = $this->userService->getById($id, $form);

        if ($this->request->isPost()) {
            $user = $this->userService->save($form, $this->request->getPost(), $user);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updaté.'); 

                return $this->redirect()->toRoute('user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->userService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');

        return $this->redirect()->toRoute('user');
    }


}

