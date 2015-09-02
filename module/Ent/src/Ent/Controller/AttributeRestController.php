<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
//use Ent\Entity\EntAttribute;
//use Ent\Entity\EntService;
use Ent\Form\AttributeForm;
use Ent\Entity\Ent;
use Ent\Service\AttributeDoctrineService;

class AttributeRestController extends AbstractRestfulController {

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
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function options() {
        $response = $this->getResponse();
        $headers = $response->getHeaders();

        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )))->addHeaderLine('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    public function __construct(AttributeDoctrineService $attributeService, AttributeForm $attributeForm, DoctrineObject $hydrator) {
        $this->attributeService = $attributeService;
        $this->attributeForm = $attributeForm;
        $this->hydrator = $hydrator;
    }

    public function getList() {
        $results = $this->attributeService->getAll();

        $data = array();
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            foreach ($results as $result) {
//            $services = null;
//            
//            foreach ($result->getFkSaService() as $service) {
//                /* @var $service EntService */
//                $services[] = array(
//                    'serviceId' => $service->getServiceId(),
//                    'serviceName' => $service->getServiceName(),
//                    'serviceLibelle' => $service->getServiceLibelle(),
//                    'serviceDescription' => $service->getServiceDescription(),
//                    'serviceLastUpdate' => $service->getServiceLastUpdate()
//                );
//            }
//            
//            /* @var $result EntAttribute */
//            $data[] = array(
//                'attributeId' => $result->getAttributeId(),
//                'attributeName' => $result->getAttributeName(),
//                'attributeLibelle' => $result->getAttributeLibelle(),
//                'attributeDescription' => $result->getAttributeDescription(),
//                'attributeLastUpdate' => $result->getAttributeLastUpdate(),
//                'fkSaService' => $services,
//            );
                /* @var $result Ent */
                $data[] = $result->toArray($this->hydrator);
                $success = false;
                $successMessage = 'Les attributs ont bien été trouvés.';
            }
        } else {
            $success = false;
            $errorMessage = 'Aucun attribut dans la base de données.';
        }
        
//        return new JsonModel(array(
//            'data' => $data
//        ));
        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }

    public function get($id) {
        $result = $this->attributeService->getById($id);

        $data = array();
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
//            $services = null;
//
//            foreach ($result->getFkSaService() as $service) {
//                /* @var $service EntService */
//                $services[] = array(
//                    'serviceId' => $service->getServiceId(),
//                    'serviceName' => $service->getServiceName(),
//                    'serviceLibelle' => $service->getServiceLibelle(),
//                    'serviceDescription' => $service->getServiceDescription(),
//                    'serviceLastUpdate' => $service->getServiceLastUpdate()
//                );
//            }
//
//            /* @var $result EntAttribute */
//            $data[] = array(
//                'attributeId' => $result->getAttributeId(),
//                'attributeName' => $result->getAttributeName(),
//                'attributeLibelle' => $result->getAttributeLibelle(),
//                'attributeDescription' => $result->getAttributeDescription(),
//                'attributeLastUpdate' => $result->getAttributeLastUpdate(),
//                'fkSaService' => $services,
//            );
            /* @var $result Ent */
            $data[] = $result->toArray($this->hydrator);
            $success = false;
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

    public function create($data) {
        $form = $this->attributeForm;

        if ($data) {
            $attribute = $this->attributeService->insert($form, $data);

            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été ajouté.');

                return new JsonModel(array(
                    'data' => $attribute->getAttributeId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'attribut a bien été ajouté.'
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\'attribut n\'a pas été ajouté.'
            ),
        ));
    }

    public function update($id, $data) {
        $attribute = $this->attributeService->getById($id, $this->attributeForm);

        if ($data) {
            $attribute = $this->attributeService->udpate($id, $this->attributeForm, $data);

            if ($attribute) {
                $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été modifié.');

                return new JsonModel(array(
                    'data' => $attribute->getAttributeId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'attribut a bien été modifié.'
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\'attribut n\'a pas été modifié.'
            ),
        ));
    }

    public function delete($id) {
        $this->attributeService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'attribut a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'L\'attribut a bien été supprimé.',
            ),
        ));
    }

}
