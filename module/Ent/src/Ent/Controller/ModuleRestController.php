<?php

namespace Ent\Controller;

use Ent\Form\ModuleForm;
use Ent\Service\ModuleDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ModuleRestController extends AbstractRestfulController
{

    /**
     *
     * @var ModuleDoctrineService
     */
    protected $moduleService;

    /**
     *
     * @var ModuleForm
     */
    protected $moduleForm;

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

    public function __construct(ModuleDoctrineService $moduleService, ModuleForm $moduleForm, Serializer $serializer)
    {
        $this->moduleService = $moduleService;
        $this->moduleForm = $moduleForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->moduleService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les modules ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun module dans la base de données.';
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

        $result = $this->moduleService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Le module a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le module n\'existe pas dans la base.';
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
//        $form = $this->moduleForm;
//
//        if ($data) {
//            $module = $this->moduleService->insert($form, $data);
//
//            if ($module) {
////                $this->flashMessenger()->addSuccessMessage('Le module a bien été ajouté.');
//
//                return new JsonModel(array(
//                    'data' => $module->getModuleId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le module a bien été ajouté.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le module n\'a pas été ajouté.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $module = $this->roleService->getById($id, $this->roleForm);
//
//        if ($data) {
//            $module = $this->moduleService->save($this->moduleForm, $data, $module);
//
//            if ($module) {
////                $this->flashMessenger()->addSuccessMessage('Le module a bien été modifié.');
//
//                return new JsonModel(array(
//                    'data' => $module->getModuleId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le module a bien été modifié.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le module n\'a pas été modifié.'
//            ),
//        ));
    }

    //EN SOMMEIl
    public function delete($id)
    {
//        $this->moduleService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('Le module a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'Le module a bien été supprimé.',
//            ),
//        ));
    }
}
