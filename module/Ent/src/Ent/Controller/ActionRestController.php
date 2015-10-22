<?php

namespace Ent\Controller;

use Ent\Form\ActionForm;
use Ent\Service\ActionDoctrineService;
use JMS\Serializer\Serializer;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ActionRestController extends AbstractRestfulController
{

    /**
     *
     * @var ActionDoctrineService
     */
    protected $actionService;

    /**
     *
     * @var ActionForm
     */
    protected $actionForm;

    /**
     * @var Serializer
     */
    protected $serializer;

//    public function options()
//    {
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

    public function __construct(ActionDoctrineService $actionService, ActionForm $actionForm, Serializer $serializer)
    {
        $this->actionService = $actionService;
        $this->actionForm = $actionForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->actionService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
//            $data[] = $results->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($results, 'json'));
            $success = true;
            $successMessage = 'Les actions ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucune action dans la base de données.';
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
        $result = $this->actionService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
//            $data[] = $result->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($result, 'json'));
            $success = true;
            $successMessage = 'L\'action a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'L\'action n\'existe pas dans la base.';
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
//        $form = $this->actionForm;
//
//        if ($data) {
//            $action = $this->actionService->insert($form, $data);
//
//            if ($action) {
////                $this->flashMessenger()->addSuccessMessage('L\' action a bien été ajoutée.');
//
//                return new JsonModel(array(
//                    'data' => $action->getActionId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\' action a bien été ajoutée.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\' action n\'a pas été ajoutée.'
//            ),
//        ));
    }

    // EN SOMMEIL
    public function update($id, $data)
    {
//        $action = $this->actionService->getById($id, $this->actionForm);
//
//        if ($data) {
//            $action = $this->actionService->save($this->actionForm, $data, $action);
//
//            if ($action) {
////                $this->flashMessenger()->addSuccessMessage('L\' action a bien été modifiée.');
//
//                return new JsonModel(array(
//                    'data' => $action->getActionId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\' action a bien été modifiée.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\' action n\'a pas été modifiée.'
//            ),
//        ));
    }

    // EN SOMMEIL
    public function delete($id)
    {
//        $this->actionService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('L\' action a bien été supprimée.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'L\' action a bien été supprimée.'
//            ),
//        ));
    }

}
