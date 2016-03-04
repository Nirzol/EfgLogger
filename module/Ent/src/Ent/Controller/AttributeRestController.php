<?php

namespace Ent\Controller;

use Ent\Form\AttributeForm;
use Ent\Service\AttributeDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AttributeRestController extends AbstractRestfulController
{

    /**
     *
     * @var AttributeDoctrineService
     */
    protected $attributeService;

    /**
     *
     * @var AttributeForm
     */
    protected $attributeForm;

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

    public function __construct(AttributeDoctrineService $attributeService, AttributeForm $attributeForm, Serializer $serializer)
    {
        $this->attributeService = $attributeService;
        $this->attributeForm = $attributeForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->attributeService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($results, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les attributs ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun attribut dans la base de données.';
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
        $result = $this->attributeService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'L\'attribut a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'L\'attribut n\'existe pas dans la base.';
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
//        $form = $this->attributeForm;
//
//        if ($data) {
//            /* @var $attribute \Ent\Entity\EntAttribute */
//            $attribute = $this->attributeService->insert($form, $data);
//
//            if ($attribute) {
////                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été ajouté.');
//
//                return new JsonModel(array(
//                    'data' => $attribute->getAttributeId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\'attribut a bien été ajouté.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\'attribut n\'a pas été ajouté.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $attribute = $this->attributeService->getById($id, $this->attributeForm);
//
//        if ($data) {
//            $attribute = $this->attributeService->save($this->attributeForm, $data, $attribute);
//
//            if ($attribute) {
////                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été modifié.');
//
//                return new JsonModel(array(
//                    'data' => $attribute->getAttributeId(),
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
//        $this->attributeService->delete($id);
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
