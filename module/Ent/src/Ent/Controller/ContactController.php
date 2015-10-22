<?php

namespace Ent\Controller;

use Ent\Form\ContactForm;
use Ent\Service\ContactDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return ContactDoctrineService
     */
    protected $contactService = null;

    /**
     * @var ContactForm
     */
    protected $contactForm = null;

    public function __construct(ContactDoctrineService $contactService, ContactForm $contactForm)
    {
        $this->contactService = $contactService;
        $this->contactForm = $contactForm;
    }

    public function listAction()
    {
        $contacts = $this->contactService->getAll();

        return new ViewModel(array(
            'contacts' => $contacts,
        ));
    }

    public function addAction()
    {
        $form = $this->contactForm;

        if ($this->request->isPost()) {
            $contact = $this->contactService->insert($form, $this->request->getPost());

            if ($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré.');

                return $this->redirect()->toRoute('contact');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $contact = $this->contactService->getById($id);

        if (!$contact) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'contact' => $contact,
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->contactForm;
        $contact = $this->contactService->getById($id, $form);

        if ($this->request->isPost()) {
            $contact = $this->contactService->save($form, $this->request->getPost(), $contact);

            if ($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été updaté.');

                return $this->redirect()->toRoute('contact');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->contactService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le contact a bien été supprimé.');

        return $this->redirect()->toRoute('contact');
    }

}
