<?php

namespace Ent\Controller;

use Ent\Form\ActionForm;
use Ent\Service\ActionDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ActionController extends AbstractActionController
{

    /**
     *
     * @var ActionDoctrineService
     */
    protected $actionService;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var ActionForm
     */
    protected $actionForm;

    public function __construct(ActionDoctrineService $actionService, ActionForm $actionForm)
    {
        $this->actionService = $actionService;
        $this->actionForm = $actionForm;
    }

    public function listAction()
    {
        $listActions = $this->actionService->getAll();

        return new ViewModel(array(
            'listActions' => $listActions
        ));
    }

    public function addAction()
    {
        $form = $this->actionForm;

        if ($this->request->isPost()) {
            $action = $this->actionService->insert($form, $this->request->getPost());

            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\'action a bien été ajoutée');

                return $this->redirect()->toRoute('action');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $action = $this->actionService->getById($id);

        if (!$action) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'action' => $action
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->actionForm;
        $action = $this->actionService->getById($id, $form);

        if ($this->request->isPost()) {
            $action = $this->actionService->save($form, $this->request->getPost(), $action);

            if ($action) {
                $this->flashMessenger()->addSuccessMessage('L\'action a bien été modifiée.');

                return $this->redirect()->toRoute('action');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->actionService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'action a bien été supprimée.');

        return $this->redirect()->toRoute('action');
    }

}
