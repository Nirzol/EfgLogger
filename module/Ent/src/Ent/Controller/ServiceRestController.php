<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAttribute;
use Ent\Entity\EntContact;
use Ent\Entity\EntService;
use Ent\Form\ServiceForm;
use Ent\Service\ServiceDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of ServiceRestController
 *
 * @author fandria
 */
class ServiceRestController extends AbstractRestfulController{
    /**
     *
     * @return ServiceDoctrineService
     */
    protected $serviceService;

    /**
     *
     * @var ServiceForm
     */
    protected $serviceForm;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;
    
    public function options()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();

        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )))->addHeaderLine('Content-Type','application/json; charset=utf-8');

        return $response;
    }
    

    public function __construct(ServiceDoctrineService $serviceService, ServiceForm $serviceForm, DoctrineObject $hydrator)
    {
        $this->serviceService = $serviceService;
        $this->serviceForm = $serviceForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->serviceService->getAll();
                
        $data = array();
        $successMessage = '';
        $errorMessage = '';
        
        if ($results) {
            foreach ($results as $result) {
//                $contacts = null;
//                foreach ($result->getFkCsContact() as $contact) {
//                    /* @var $contact EntContact */
//                    $contacts[] = array(
//                        'contactId' => $contact->getContactId(),
//                        'contactName' => $contact->getContactName(),
//                        'contactLibelle' => $contact->getContactLibelle(),
//                        'contactDescription' => $contact->getContactDescription(),
//                        'contactService' => $contact->getContactService(),
//                        'contactMailto' => $contact->getContactMailto(),
//                        'contactLastUpdate' => $contact->getContactLastUpdate()
//                    );
//                }
//
//                $attributes = null;
//                foreach ($result->getFkSaAttribute() as $attribute) {
//                    /* @var $attribute EntAttribute */
//                    $attributes[] = array(
//                        'attributeId' => $attribute->getAttributeId(),
//                        'attributeName' => $attribute->getAttributeName(),
//                        'attributeLibelle' => $attribute->getAttributeLibelle(),
//                        'attributeDescription' => $attribute->getAttributeDescription(),
//                        'attributeLastUpdate' => $attribute->getAttributeLastUpdate()
//                    );
//                }
//
//                /* @var $result EntService */
//                $data[] = array(
//                    'serviceId' => $result->getServiceId(),
//                    'serviceName' => $result->getServiceName(),
//                    'serviceLibelle' => $result->getServiceLibelle(),
//                    'serviceDescription' => $result->getServiceDescription(),
//                    'serviceLastUpdate' => $result->getServiceLastUpdate(),
//                    'fkCsContact' => $contacts,
//                    'fkSaAttribute' => $attributes
//                );
            
                $data[] = $result->toArray($this->hydrator);
                $success = false;
                $successMessage = 'Les services ont bien été trouvés.';
            }
        } else {
            $success = false;
            $errorMessage = 'Aucun service existe dans la base.';
        }

        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
        
//        return new JsonModel(array(
//            'services' => $data)
//        );
    }

    public function get($id)
    {
        $result = $this->serviceService->getById($id);
        
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
//        foreach ($result->getFkSaAttribute() as $attribute) {
//            /* @var $attribute EntAttribute */
//            $attributes[] = array(
//                'attributeId' => $attribute->getAttributeId(),
//                'attributeName' => $attribute->getAttributeName(),
//                'attributeLibelle' => $attribute->getAttributeLibelle(),
//                'attributeDescription' => $attribute->getAttributeDescription(),
//                'attributeLastUpdate' => $attribute->getAttributeLastUpdate()
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
//        return new JsonModel(
//                $data
//        );
        
        $data = array();
        $successMessage = '';
        $errorMessage = '';
        if ($result) {
            $data[] = $result->toArray($this->hydrator);
            $success = false;
            $successMessage = 'L\'user a bien été trouver.';
        } else {
            $success = false;
            $errorMessage = 'L\'user n\'existe pas dans la base.';
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

    public function create($data)
    {
        $form = $this->serviceForm;

        if ($data) {
                    
            $service = $this->serviceService->insert($form, $data);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');

                return new JsonModel(array(
                    'data' => $service->getServiceId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le service a bien été inséré.',
                    ),
                ));
            }
        }
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le service n\'a pas été inséré.',
            ),
        ));
    }

    public function update($id, $data)
    {
        $service = $this->serviceService->getById($id, $this->serviceForm);

        if ($data) {
            $service = $this->serviceService->save($this->serviceForm, $data, $service);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.');

                return new JsonModel(array(
                    'data' => $service->getServiceId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le service a bien été updaté.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $service,
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le service n\'a pas été updaté.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->serviceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'Le service a bien été supprimé.',
            ),
        ));
    }
}
