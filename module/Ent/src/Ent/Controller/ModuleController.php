<?php

namespace Ent\Controller;

use Ent\Form\ModuleForm;
use Ent\Service\ModuleDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ModuleController extends AbstractActionController
{

    /**
     * @var ModuleDoctrineService
     */
    protected $moduleService;

    /**
     * @var Request
     */
    protected $request;

    /**
     *
     * @var ModuleForm
     */
    protected $moduleForm;

    public function __construct(ModuleDoctrineService $moduleService, ModuleForm $moduleForm)
    {
        $this->moduleService = $moduleService;
        $this->moduleForm = $moduleForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_module')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $listModules = $this->moduleService->getAll();

        return new ViewModel(array(
            'listModules' => $listModules
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_module')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $form = $this->moduleForm;

        if ($this->request->isPost()) {
            $module = $this->moduleService->insert($form, $this->request->getPost());

            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été ajouté.');

                return $this->redirect()->toRoute('zfcadmin/module');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_module')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');

        $module = $this->moduleService->getById($id);

        if (!$module) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'module' => $module
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_module')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');
        $form = $this->moduleForm;
        $module = $this->moduleService->getById($id, $form);

        if ($this->request->isPost()) {
            $module = $this->moduleService->save($form, $this->request->getPost(), $module);

            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été modifié.');

                return $this->redirect()->toRoute('zfcadmin/module');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_module')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $id = $this->params('id');

        $this->moduleService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le module a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/module');
    }

}
