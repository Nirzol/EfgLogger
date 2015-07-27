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
        $id = $this->params('id');

        $profile = $this->service->getById($id);        
        
        if (!$profile) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'profile' => $profile
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('profile');
        }
        
        $profile = $this->service->getById($id);
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->service->delete($id);
            }
            
            return $this->redirect()->toRoute('profile');
        }
        
        return new ViewModel(array(
            'id' => $id,
            'profile' => $profile
        ));
    }

    public function updateAction()
    {
        $id = (int) $this->params('id');
        $form = new ProfileForm();
        
        if (!$id) {
            return $this->redirect()->toRoute('profile');
        }
        
        $profile = $this->service->getById($id, $form);    
        
        if ($this->request->isPost()) {
            $profile = $this->service->update($id, $form, $this->request->getPost());
            
            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');
                
                return $this->redirect()->toRoute('profile');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }


}

