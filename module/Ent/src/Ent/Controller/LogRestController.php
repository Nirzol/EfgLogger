<?php

namespace Ent\Controller;

use Ent\Form\LogForm;
use Ent\Service\LogDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class LogRestController extends AbstractRestfulController
{

    /**
     *
     * @var LogDoctrineService
     */
    protected $logService;

    /**
     *
     * @var LogForm
     */
    protected $logForm;

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

    public function __construct(LogDoctrineService $logService, LogForm $logForm, Serializer $serializer)
    {
        $this->logService = $logService;
        $this->logForm = $logForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->logService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($results, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les logs ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun log dans la base de données.';
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
        $result = $this->logService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Le log a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le log n\'existe pas dans la base.';
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

    //EN SOMMEIL
    public function create($data)
    {
//        $form = $this->logForm;
//
//        if ($data) {
//            /* @var $log \Ent\Entity\EntLog */
//            $log = $this->logService->insert($form, $data);
//
//            if ($log) {
////                $this->flashMessenger()->addSuccessMessage('Le log a bien été ajouté.');
//
//                return new JsonModel(array(
//                    'data' => $log->getLogId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le log a bien été ajouté.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le log n\'a pas été ajouté.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $log = $this->logService->getById($id, $this->logForm);
//
//        if ($data) {
//            $log = $this->logService->save($this->logForm, $data, $log);
//
//            if ($log) {
////                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été modifié.');
//
//                return new JsonModel(array(
//                    'data' => $log->getLogId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\'attribut a bien été modifié.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\'attribut n\'a pas été modifié.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function delete($id)
    {
//        $this->logService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'L\'attribut a bien été supprimé.',
//            ),
//        ));
    }

}
