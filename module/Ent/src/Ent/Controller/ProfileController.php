<?php

namespace Ent\Controller;

use Ent\Form\ProfileForm;
use Ent\Service\ProfileDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController
{

    /**
     *
     * @var ProfileDoctrineService
     */
    protected $profileService;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var ProfileForm
     */
    protected $profileForm;

    public function __construct(ProfileDoctrineService $profileService, ProfileForm $profileForm)
    {
        $this->profileService = $profileService;
        $this->profileForm = $profileForm;
    }

    public function listAction()
    {
        $listProfiles = $this->profileService->getAll();

        return new ViewModel(array(
            'listProfiles' => $listProfiles,
        ));
    }

    public function addAction()
    {
        $form = $this->profileForm;

        if ($this->request->isPost()) {
            $profile = $this->profileService->insert($form, $this->request->getPost());

            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');

                return $this->redirect()->toRoute('profile');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $profile = $this->profileService->getById($id);

        if (!$profile) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'profile' => $profile
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->profileForm;
        $profile = $this->profileService->getById($id, $form);

        if ($this->request->isPost()) {
            $profile = $this->profileService->save($form, $this->request->getPost(), $profile);

            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');

                return $this->redirect()->toRoute('profile');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->profileService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');

        return $this->redirect()->toRoute('profile');
    }

}
