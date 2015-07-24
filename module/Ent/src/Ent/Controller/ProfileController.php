<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Form\ProfileForm;

class ProfileController extends AbstractActionController
{

    protected $service = null;

    public function __construct(\Ent\Service\GenericEntityServiceInterface $iservice)
    {
        $this->service = $iservice;
    }

    public function listAction()
    {
        $profiles = $this->service->getAll();

        return new ViewModel(array(
            'listProfiles' => $profiles
        ));
    }

    public function addAction()
    {
        $form = new ProfileForm();

        if ($this->request->isPost()) {

            $profile = $this->service->insert($form, $this->request->getPost());            
            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');
                
                return $this->redirect()->toRoute('profile');
            }
            
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function showAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function updateAction()
    {
        return new ViewModel();
    }


}

