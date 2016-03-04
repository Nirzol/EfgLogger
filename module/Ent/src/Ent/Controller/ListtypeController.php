<?php

namespace Ent\Controller;

use Ent\Form\ListtypeForm;
use Ent\Service\ListtypeDoctrineService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;

class ListtypeController extends AbstractActionController
{

    /**
     *
     * @var ListtypeDoctrineService
     */
    protected $listtypeService = null;

    /**
     *
     * @var ListtypeForm
     */
    protected $listtypeForm = null;

    public function __construct(ListtypeDoctrineService $listtypeService, ListtypeForm $listtypeForm)
    {
        $this->listtypeService = $listtypeService;
        $this->listtypeForm = $listtypeForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_listtype')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $listtypes = $this->listtypeService->getAll();

        return new ViewModel(array(
            'listtypes' => $listtypes,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_listtype')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $form = $this->listtypeForm;

        if ($this->request->isPost()) {
            $listtype = $this->listtypeService->insert($form, $this->request->getPost());

            if ($listtype) {
                $this->flashMessenger()->addSuccessMessage('Le type de la liste a bien été insérer.');

                return $this->redirect()->toRoute('zfcadmin/listtype');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_listtype')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $listtype = $this->listtypeService->getById($id);

        if (!$listtype) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'listtype' => $listtype,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_listtype')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->listtypeForm;
        $listtype = $this->listtypeService->getById($id, $form);

        if ($this->request->isPost()) {
            $listtype = $this->listtypeService->save($form, $this->request->getPost(), $listtype);

            if ($listtype) {
                $this->flashMessenger()->addSuccessMessage('Le type de la liste a bien été updaté.');

                return $this->redirect()->toRoute('zfcadmin/listtype');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_listtype')) {
            throw new UnauthorizedException('You are not allowed !');
        }
        $id = $this->params('id');

        $this->listtypeService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le type de la liste a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/listtype');
    }
}
