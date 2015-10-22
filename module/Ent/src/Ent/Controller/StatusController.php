<?php

namespace Ent\Controller;

use Ent\Form\StatusForm;
use Ent\Service\StatusDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatusController extends AbstractActionController
{

    /**
     * @var StatusDoctrineService
     */
    protected $statusService;

    /**
     * @var Request
     */
    protected $request;

    /**
     *
     * @var StatusForm
     */
    protected $statusForm;

    public function __construct(StatusDoctrineService $statusService, StatusForm $statusForm)
    {
        $this->statusService = $statusService;
        $this->statusForm = $statusForm;
    }

    public function listAction()
    {
        $listStatus = $this->statusService->getAll();

        return new ViewModel(array(
            'listStatus' => $listStatus,
        ));
    }

    public function addAction()
    {
        $form = $this->statusForm;

        if ($this->request->isPost()) {
            $status = $this->statusService->insert($form, $this->request->getPost());

            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été ajouté.');

                return $this->redirect()->toRoute('status');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $status = $this->statusService->getById($id);

        if (!$status) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'status' => $status
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->statusForm;
        $status = $this->statusService->getById($id, $form);

        if ($this->request->isPost()) {
            $status = $this->statusService->save($form, $this->request->getPost(), $status);

            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été modifié.');

                return $this->redirect()->toRoute('status');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->statusService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le status a bien été supprimé.');

        return $this->redirect()->toRoute('status');
    }

}
