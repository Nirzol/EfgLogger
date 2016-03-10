<?php

namespace Ent\Controller;

use Ent\Form\AttributeForm;
use Ent\Service\AttributeDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AttributeController extends AbstractActionController
{

    /**
     *
     * @var AttributeDoctrineService
     */
    protected $attributeService;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var AttributeForm
     */
    protected $attributeForm;

    public function __construct(AttributeDoctrineService $attributeService, AttributeForm $attributeForm)
    {
        $this->attributeService = $attributeService;
        $this->attributeForm = $attributeForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_attribute')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $listAttritutes = $this->attributeService->getAll();

        return new ViewModel(array(
            'listAttributes' => $listAttritutes,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_attribute')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $form = $this->attributeForm;

        if ($this->request->isPost()) {
            $attribute = $this->attributeService->insert($form, $this->request->getPost());

            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été ajouté.');

                return $this->redirect()->toRoute('zfcadmin/attribute');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_attribute')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $attribute = $this->attributeService->getById($id);

        if (!$attribute) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'attribute' => $attribute,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_attribute')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->attributeForm;
        $attribute = $this->attributeService->getById($id, $form);

        if ($this->request->isPost()) {
            $attribute = $this->attributeService->save($form, $this->request->getPost(), $attribute);

            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été modifié.');

                return $this->redirect()->toRoute('zfcadmin/attribute');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_attribute')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $this->attributeService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/attribute');
    }

}
