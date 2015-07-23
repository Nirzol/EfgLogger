<?php

namespace Ent\Controller;

use Ent\Form\ServiceForm;
use Ent\Service\ServiceDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ServiceController extends AbstractActionController
{
    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return ServiceDoctrineService
     */
    protected $serviceService = null;

    /**
     * @var ServiceForm
     */
    protected $serviceForm = null;

    public function __construct(ServiceDoctrineService $serviceService, ServiceForm $serviceForm)
    {
        $this->serviceService = $serviceService;
        $this->serviceForm = $serviceForm;
    }

    public function listAction()
    {
        $services = $this->serviceService->getAll();

        return new ViewModel(array(
            'services' => $services,
        ));
    }

    public function addAction()
    {
        $form = $this->serviceForm;

        if ($this->request->isPost()) {
            $user = $this->serviceService->insert($form, $this->request->getPost());

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');

                return $this->redirect()->toRoute('service');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $service = $this->serviceService->getById($id);

        if (!$service) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'service' => $service,
        ));
    }

    public function modifyAction()
    {
        $id = $this->params('id');
        $form = $this->serviceForm;
        $service = $this->serviceService->getById($id, $form);

        if ($this->request->isPost()) {
            $service = $this->serviceService->save($form, $this->request->getPost(), $service);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.'); 

                return $this->redirect()->toRoute('service');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->serviceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');

        return $this->redirect()->toRoute('service');
    }
}

