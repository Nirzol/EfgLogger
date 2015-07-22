<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Ent\Entity\EntStatus;
use Ent\Entity\Ent;
use Ent\Form\StatusForm;
use Ent\Service\StatusDoctrineService;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class StatusRestController extends AbstractRestfulController {

    /**
     * 
     * @var StatusDoctrineService
     */
    protected $statusService;

    /**
     * 
     * @var DoctrineObject
     */
    protected $hydrator;

    public function __construct(StatusDoctrineService $statusService, DoctrineObject $hydrator) {
        $this->statusService = $statusService;
        $this->hydrator = $hydrator;
    }

    public function getList() {
        $results = $this->statusService->getAll();

        $data = array();

        foreach ($results as $result) {
            /* @var $result EntStatus */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function get($id) {

        $result = $this->statusService->getById($id);

        $data = array();

        if ($result) {
            /* @var $result Ent */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function create($data) {
        $form = new StatusForm();

        if ($data) {
            $status = $this->statusService->insert($form, $data);

            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été ajouté.');

                return new JsonModel(array(
                    'data' => $status->getStatusId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le status a bien été ajouté.'
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le status n\'a pas été ajouté.'
            ),
        ));
    }

    public function update($id, $data) {
        $form = new StatusForm();

        $status = $this->statusService->getById($id, $form);

        if ($data) {
            $status = $this->statusService->update($id, $form, $data);

            if ($status) {
                $this->flashMessenger()->addSuccessMessage('Le status a bien été modifié.');

                return new JsonModel(array(
                    'data' => $status->getStatusId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le status a bien été modifié.'
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le status n\'a pas été modifié.'
            ),
        ));
    }

    public function delete($id) {
        $this->statusService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le status a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'Le status a bien été supprimé.'
            ),
        ));
    }

}
