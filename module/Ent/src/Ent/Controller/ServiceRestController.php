<?php

namespace Ent\Controller;

use Ent\Form\ServiceForm;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of ServiceRestController
 *
 * @author fandria
 */
class ServiceRestController extends AbstractRestfulController
{

    /**
     *
     * @return ServiceDoctrineService
     */
    protected $serviceService;

    /**
     *
     * @return PreferenceDoctrineService
     */
    protected $preferenceService;

    /**
     *
     * @var ServiceForm
     */
    protected $serviceForm;

    /**
     * @var Serializer
     */
    protected $serializer;

//    public function options()
//    {
//        $response = $this->getResponse();
//        $headers  = $response->getHeaders();
//
//        if ($this->params()->fromRoute('id', false)) {
//            // Allow viewing, partial updating, replacement, and deletion
//            // on individual items
//            $headers->addHeaderLine('Allow', implode(',', array(
//                'GET',
//                'PATCH',
//                'PUT',
//                'DELETE',
//            )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
//            return $response;
//        }
//
//        // Allow only retrieval and creation on collections
//        $headers->addHeaderLine('Allow', implode(',', array(
//            'GET',
//            'POST',
//        )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
//
//        return $response;
//    }


    public function __construct(ServiceDoctrineService $serviceService, PreferenceDoctrineService $preferenceService, ServiceForm $serviceForm, Serializer $serializer)
    {
        $this->serviceService = $serviceService;
        $this->preferenceService = $preferenceService;
        $this->serviceForm = $serviceForm;
        $this->serializer = $serializer;
    }

    public function testAction()
    {
        return new JsonModel(array(
            'data' => 'test',
            'success' => 'true',
            'flashMessages' => array(
                'success' => '$successMessage',
                'error' => '$errorMessage',
            ),
        ));
    }

    public function getList()
    {
        $results = $this->serviceService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($results, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les services ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun service dans la base de données.';
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
        $result = $this->serviceService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Le service a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Aucun service dans la base de données.';
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

//    public function getList2()
//    {
////        $results = $this->serviceService->getAll();
//        $results = $this->serviceService->findBy(array(), array('serviceId' => 'ASC'));
//
//        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//
//        if ($results) {
//            $i = 0;
//            foreach ($results as $result) {
//                $prefService = $this->preferenceService->findOneBy(array('fkPrefService' => $result->getServiceId(), 'fkPrefUser' => null, 'fkPrefProfile' => null));
//                $data[$i] = $result->toArray($this->hydrator);
////                        var_dump($result->getServiceId());
//                if ($prefService) {
////                        var_dump($prefService->getPrefAttribute());
//                    $data[$i]['fkSaAttribute'] = json_decode($prefService->getPrefAttribute());
//                }
//
//                $success = true;
//                $successMessage = 'Les services ont bien été trouvés.';
//
//                $i++;
//            }
//        } else {
//            $success = false;
//            $errorMessage = 'Aucun service existe dans la base.';
//        }
//
//        return new JsonModel(array(
//            'data' => $data,
//            'success' => $success,
//            'flashMessages' => array(
//                'success' => $successMessage,
//                'error' => $errorMessage,
//            ),
//        ));
//    }
//    public function getList2()
//    {
//        $results = $this->serviceService->getAll();
//                
//        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//        
//        if ($results) {
//            foreach ($results as $result) {
//                $data[] = $this->extractDataService($result);
//            
////                $data[] = $result->toArray($this->hydrator);
//                $success = true;
//                $successMessage = 'Les services ont bien été trouvés.';
//            }
//        } else {
//            $success = false;
//            $errorMessage = 'Aucun service existe dans la base.';
//        }
//
//        return new JsonModel(array(
//            'data' => $data,
//            'success' => $success,
//            'flashMessages' => array(
//                'success' => $successMessage,
//                'error' => $errorMessage,
//            ),
//        ));
//    }
//    public function get2($id)
//    {
//
//        $result = $this->serviceService->getById($id);
//
//        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//
//
//        if ($result) {
//            /* @var $result EntHierarchicalRole */
//            $data[0] = $result->toArray($this->hydrator);
//            
//            $prefService = $this->preferenceService->findOneBy(array('fkPrefService' => $id, 'fkPrefUser' => null, 'fkPrefProfile' => null));
//            if ($prefService) {
//                $data[0]['fkSaAttribute'] = json_decode($prefService->getPrefAttribute());
//            }
//            $success = true;
//            $successMessage = 'Les services ont bien été trouvés.';
//        } else {
//            $success = false;
//            $errorMessage = 'Aucun service existe dans la base.';
//        }
//        return new JsonModel(array(
//            'data' => $data,
//            'success' => $success,
//            'flashMessages' => array(
//                'success' => $successMessage,
//                'error' => $errorMessage,
//            ),
//        ));
//    }
//    public function get($id)
//    {
//        $result = $this->serviceService->getById($id);
//
//        $data = $this->extractDataService($result);
//
////        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//        if ($result) {
//            $data[] = $result->toArray($this->hydrator);
//            $success = true;
//            $successMessage = 'Le service a bien été trouvé.';
//        } else {
//            $success = false;
//            $errorMessage = 'Le service n\'existe pas dans la base.';
//        }
//
//        return new JsonModel(array(
//            'data' => $data,
//            'success' => $success,
//            'flashMessages' => array(
//                'success' => $successMessage,
//                'error' => $errorMessage,
//            ),
//        ));
//    }
    // EN SOMMEIL
    public function create($data)
    {
//        $form = $this->serviceForm;
//
//        if ($data) {
//
//            $service = $this->serviceService->insert($form, $data);
//
//            if ($service) {
//                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');
//
//                return new JsonModel(array(
//                    'data' => $service->getServiceId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le service a bien été inséré.',
//                    ),
//                ));
//            }
//        }
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le service n\'a pas été inséré.',
//            ),
//        ));
    }

    // EN SOMMEIL
    public function update($id, $data)
    {
//        $service = $this->serviceService->getById($id, $this->serviceForm);
//
//        if ($data) {
//            $service = $this->serviceService->save($this->serviceForm, $data, $service);
//
//            if ($service) {
//                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.');
//
//                return new JsonModel(array(
//                    'data' => $service->getServiceId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le service a bien été updaté.',
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'data' => $service,
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le service n\'a pas été updaté.',
//            ),
//        ));
    }

    // EN SOMMEIL
    public function delete($id)
    {
//        $this->serviceService->delete($id);
//
//        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'error' => 'Le service a bien été supprimé.',
//            ),
//        ));
    }

//    private function extractDataService($result) {
//        $contacts = null;
//        foreach ($result->getFkCsContact() as $contact) {
//            /* @var $contact EntContact */
//            $contacts[] = array(
//                'contactId' => $contact->getContactId(),
//                'contactName' => $contact->getContactName(),
//                'contactLibelle' => $contact->getContactLibelle(),
//                'contactDescription' => $contact->getContactDescription(),
//                'contactService' => $contact->getContactService(),
//                'contactMailto' => $contact->getContactMailto(),
//                'contactLastUpdate' => $contact->getContactLastUpdate()
//            );
//        }
//
//        $attributes = null;
//        foreach ($result->getAttributes() as $attribute) {
//            /* @var $attribute EntAttribute */
//            $attributes[] = array(
//                'attributeId' => $attribute['attribute']->getAttributeId(),
//                'attributeName' => $attribute['attribute']->getAttributeName(),
//                'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                'attributeLastUpdate' => $attribute['attribute']->getAttributeLastUpdate(),
//                'value' => $attribute['value']
//            );
//        }
//
//        /* @var $result EntService */
//        $data = array(
//            'serviceId' => $result->getServiceId(),
//            'serviceName' => $result->getServiceName(),
//            'serviceLibelle' => $result->getServiceLibelle(),
//            'serviceDescription' => $result->getServiceDescription(),
//            'serviceLastUpdate' => $result->getServiceLastUpdate(),
//            'fkCsContact' => $contacts,
//            'fkSaAttribute' => $attributes
//        );
//        
//        return $data;
//    }
}
