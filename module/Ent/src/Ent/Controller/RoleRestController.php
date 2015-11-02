<?php

namespace Ent\Controller;

use Ent\Form\RoleForm;
use Ent\Service\RoleDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RoleRestController extends AbstractRestfulController
{

    /**
     *
     * @var RoleDoctrineService
     */
    protected $roleService;

    /**
     *
     * @var RoleForm
     */
    protected $roleForm;

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

    public function __construct(RoleDoctrineService $roleService, RoleForm $roleForm, Serializer $serializer)
    {
        $this->roleService = $roleService;
        $this->roleForm = $roleForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->roleService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les roles ont bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Aucun role existe dans la base.';
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
        $result = $this->roleService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Le role a bien été trouver.';
        } else {
            $success = false;
            $errorMessage = 'Le role n\'existe pas dans la base.';
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
//        $form = $this->roleForm;
//
//        if ($data) {
//            /* @var $role \Ent\Entity\EntHierarchicalRole */
//            $role = $this->roleService->insert($form, $data);
//
//            if ($role) {
////                $message = 'Le role a bien été ajouté dans la base.';
////                $this->flashMessenger()->addSuccessMessage($message);
//
//                return new JsonModel(array(
//                    'data' => $role->getId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le role a bien été ajouté dans la base.',
//                    ),
//                ));
//            }
//        }
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le role n\'a pas été insérer.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $role = $this->roleService->getById($id, $this->roleForm);
//
//        if ($data) {
//            $role = $this->roleService->save($this->roleForm, $data, $role);
//
//            if ($role) {
////                $message = 'Le role a bien été modifié.';
////                $this->flashMessenger()->addSuccessMessage($message);
//
//                return new JsonModel(array(
//                    'data' => $role->getId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le role a bien été modifié.',
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'data' => $role,
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le role ' . $id . ' n\'a pas été updater.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function delete($id)
    {
//        $this->roleService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'Le role a bien été supprimé.',
//            ),
//        ));
    }

}
