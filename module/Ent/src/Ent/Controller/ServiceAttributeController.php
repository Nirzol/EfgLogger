<?php

namespace Ent\Controller;

use Ent\Form\ServiceAttributeForm;
use Ent\Service\ServiceAttributeDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ServiceAttributeController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return ServiceAttributeDoctrineService
     */
    protected $serviceAttributeService = null;

    /**
     * @var ServiceAttributeForm
     */
    protected $serviceAttributeForm = null;

    public function __construct(ServiceAttributeDoctrineService $serviceAttributeService, ServiceAttributeForm $serviceAttributeForm)
    {
        $this->serviceAttributeService = $serviceAttributeService;
        $this->serviceAttributeForm = $serviceAttributeForm;
    }

    public function addAction()
    {
        $form = $this->serviceAttributeForm;

        if ($this->request->isPost()) {
            $service = $this->serviceAttributeService->insert($form, $this->request->getPost());

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service attribute a bien été inséré.');

                return $this->redirect()->toRoute('service-attribute');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->serviceAttributeService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service attribute a bien été supprimé.');

        return $this->redirect()->toRoute('service-attribute');
    }

    public function listAction()
    {
        $services = $this->serviceAttributeService->getAll();

        return new ViewModel(array(
            'servicesAttributes' => $services,
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $service = $this->serviceAttributeService->getById($id);

        if (!$service) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'servicesAttributes' => $service,
        ));
    }

    public function modifyAction()
    {
        $id = $this->params('id');
        $form = $this->serviceAttributeForm;
        $service = $this->serviceAttributeService->getById($id, $form);

        if ($this->request->isPost()) {
            $service = $this->serviceAttributeService->save($form, $this->request->getPost(), $service);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service attribute a bien été updaté.'); 

                return $this->redirect()->toRoute('service-attribute');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }


}

