<?php

namespace Ent\Controller;

use Ent\Form\ListForm;
use Ent\Service\ListDoctrineService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;

class ListController extends AbstractActionController
{

    /**
     * 
     * @var ListDoctrineService
     */
    protected $listService = null;

    /**
     * 
     * @var ListForm
     */
    protected $listForm = null;

    public function __construct(ListDoctrineService $listService, ListForm $listForm)
    {
        $this->listService = $listService;
        $this->listForm = $listForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_list')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $lists = $this->listService->getAll();

        return new ViewModel(array(
            'lists' => $lists,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_list')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $form = $this->listForm;

        if ($this->request->isPost()) {
            $list = $this->listService->insert($form, $this->request->getPost());

            if ($list) {
                $this->flashMessenger()->addSuccessMessage('L\'item dans la liste a bien été insérer.');

                return $this->redirect()->toRoute('zfcadmin/list');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_list')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $list = $this->listService->getById($id);

        if (!$list) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'list' => $list,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_list')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->listForm;
        $list = $this->listService->getById($id, $form);

        if ($this->request->isPost()) {
            $list = $this->listService->save($form, $this->request->getPost(), $list);

            if ($list) {
                $this->flashMessenger()->addSuccessMessage('L\'item de la liste a bien été updaté.');

                return $this->redirect()->toRoute('zfcadmin/list');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_list')) {
            throw new UnauthorizedException('You are not allowed !');
        }
        $id = $this->params('id');

        $this->listService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'item de la liste a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/list');
    }

}
