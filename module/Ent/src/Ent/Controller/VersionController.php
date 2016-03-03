<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Form\VersionForm;

class VersionController extends AbstractActionController
{

    protected $service = null;

    public function __construct(\Ent\Service\VersionDoctrineService $iservice)
    {
        $this->service = $iservice;
    }

    public function indexAction()
    {
        
        if (!$this->isGranted('list_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        
        $versions = $this->service->getAll();
        
        return new ViewModel(array(
            'listVersions' => $versions
        ));
    }

    public function addAction()
    {
        $form = new \Ent\Form\VersionForm();

        if ($this->request->isPost()) {

            $version = $this->service->insert($form, $this->request->getPost());

            if ($version) {
                $this->flashMessenger()->addSuccessMessage('La version a bien été enregistrée dans la base.');
            } else {
                $this->flashMessenger()->addErrorMessage('Un problème est survenu lors de l\'insertion de la version: ' . $version->toString());
            }
            return $this->redirect()->toRoute('version');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('version');
        }

        $version = $this->service->getById($id);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->service->delete($id);
            }

            return $this->redirect()->toRoute('version');
        }

        return new ViewModel(array(
            'id' => $id,
            'version' => $version
        ));
    }

    public function updateAction()
    {
        $id = (int) $this->params('id');
        $form = new VersionForm();

        if (!$id) {
            return $this->redirect()->toRoute('version');
        }

        // Alimente le formulaire a prtir de l'id eo
        $versionFound = $this->service->getById($id, $form);

        if ($this->request->isPost()) {
            $version = $this->service->update($id, $form, $this->request->getPost());

            if ($version) {
                $this->flashMessenger()->addSuccessMessage('La version a bien été modifiée dans la base.');

                return $this->redirect()->toRoute('version');
            } else {
                $this->flashMessenger()->addErrorMessage('Un problème est survenu lors de la mise a jour de la version: ' . $versionFound->toString());
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'version' => $versionFound
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $version = $this->service->getById($id);

        if (!$version) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'version' => $version
        ));
    }

}
