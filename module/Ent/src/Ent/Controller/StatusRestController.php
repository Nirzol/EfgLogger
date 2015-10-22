<?php

namespace Ent\Controller;

use Ent\Form\StatusForm;
use Ent\Service\StatusDoctrineService;
use JMS\Serializer\Serializer;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class StatusRestController extends AbstractRestfulController
{

    /**
     * 
     * @var StatusDoctrineService
     */
    protected $statusService;

    /**
     *
     * @var StatusForm
     */
    protected $statusForm;

    /**
     * @var Serializer
     */
    protected $serializer;

//    public function options() {
//        $response = $this->getResponse();
//        $headers = $response->getHeaders();
//
//        if ($this->params()->fromRoute('id', false)) {
//            // Allow viewing, partial updating, replacement, and deletion
//            // on individual items
//            $headers->addHeaderLine('Allow', implode(',', array(
//                'GET',
//                'PATCH',
//                'PUT',
//                'DELETE',
//            )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
//            return $response;
//        }
//
//        // Allow only retrieval and creation on collections
//        $headers->addHeaderLine('Allow', implode(',', array(
//            'GET',
//            'POST',
//        )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
//
//        return $response;
//    }

    public function __construct(StatusDoctrineService $statusService, StatusForm $statusForm, Serializer $serializer)
    {
        $this->statusService = $statusService;
        $this->statusForm = $statusForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->statusService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
//            $data[] = $results->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($results, 'json'));
            $success = true;
            $successMessage = 'Les status ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun status dans la base de données.';
        }

        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }

    public function get($id)
    {
        $result = $this->statusService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
//            $data[] = $result->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($result, 'json'));
            $success = true;
            $successMessage = 'Le status a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le status n\'existe pas dans la base.';
        }

        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }

    // EN SOMMEIL
    public function create($data)
    {
//        $form = $this->statusForm;
//
//        if ($data) {
//            $status = $this->statusService->insert($form, $data);
//
//            if ($status) {
////                $this->flashMessenger()->addSuccessMessage('Le status a bien été ajouté.');
//
//                return new JsonModel(array(
//                    'data' => $status->getStatusId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le status a bien été ajouté.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le status n\'a pas été ajouté.'
//            ),
//        ));
    }

    // EN SOMMEIL
    public function update($id, $data)
    {
//        $status = $this->statusService->getById($id, $this->statusForm);
//
//        if ($data) {
//            $status = $this->statusService->save($this->statusForm, $data, $status);
//
//            if ($status) {
////                $this->flashMessenger()->addSuccessMessage('Le status a bien été modifié.');
//
//                return new JsonModel(array(
//                    'data' => $status->getStatusId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le status a bien été modifié.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le status n\'a pas été modifié.'
//            ),
//        ));
    }

    // EN SOMMEIL
    public function delete($id)
    {
//        $this->statusService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('Le status a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'Le status a bien été supprimé.'
//            ),
//        ));
    }

}
