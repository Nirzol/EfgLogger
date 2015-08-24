<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntContact;
use Ent\Entity\EntService;
use Ent\Entity\EntUser;
use Ent\Form\ContactForm;
use Ent\Service\ContactDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of ContactRestController
 *
 * @author fandria
 */
class ContactRestController  extends AbstractRestfulController{
    /**
     *
     * @return ContactDoctrineService
     */
    protected $contactService;

    /**
     *
     * @var ContactForm
     */
    protected $contactForm;

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
    

    public function __construct(ContactDoctrineService $contactService, ContactForm $contactForm, DoctrineObject $hydrator)
    {
        $this->contactService = $contactService;
        $this->contactForm = $contactForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->contactService->getAll();

        $data = array();
        $successMessage = '';
        $errorMessage = '';
        
        if ($results) {
            foreach ($results as $result) {
//                $services = null;
//                foreach ($result->getFkCsService() as $service) {
//                    /* @var $service EntService */
//                    $services[] = array(
//                        'serviceId' => $service->getServiceId(),
//                        'serviceName' => $service->getServiceName(),
//                        'serviceLibelle' => $service->getServiceLibelle(),
//                        'serviceDescription' => $service->getServiceDescription(),
//                        '$serviceLastUpdate' => $service->getServiceLastUpdate()
//                    );
//                }
//
//                $users = null;
//                foreach ($result->getFkUcUser() as $user) {
//                    /* @var $user EntUser */
//                    $users[] = array(
//                        'userId' => $user->getUserId(),
//                        'userLogin' => $user->getUserLogin(),
//                        'userLastConnection' => $user->getUserLastConnection(),
//                        'userLastUpdate' => $user->getUserLastUpdate(),
//                        'userStatus' => $user->getUserStatus()
//                    );
//                }
//
//                /* @var $result EntContact */
//                $data[] = array(
//                    'contactId' => $result->getContactId(),
//                    'contactName' => $result->getContactName(),
//                    'contactLibelle' => $result->getContactLibelle(),
//                    'contactDescription' => $result->getContactDescription(),
//                    'contactService' => $result->getContactService(),
//                    'contactMailto' => $result->getContactMailto(),
//                    'contactLastUpdate' => $result->getContactLastUpdate(),
//                    'contactLastUpdate' => $result->getContactLastUpdate(),
//                    'fkContactStructure' => $result->getFkContactStructure()->toArray($this->hydrator),
//                    'fkCsService' => $services,
//                    'fkUcUser' => $users
//                ); 
                $data[] = $result->toArray($this->hydrator);
                $success = false;
                $successMessage = 'Les contacts ont bien été trouvés.';
            }
        } else {
            $success = false;
            $errorMessage = 'Aucun contact existe dans la base.';
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
//            'data' => $data)
//        );
    }

    public function get($id)
    {
        /* @var $result EntContact */
        $result = $this->contactService->getById($id);
        
//        $services = null;
//        foreach ($result->getFkCsService() as $service) {
//            /* @var $service EntService */
//            $services[] = array(
//                'serviceId' => $service->getServiceId(),
//                'serviceName' => $service->getServiceName(),
//                'serviceLibelle' => $service->getServiceLibelle(),
//                'serviceDescription' => $service->getServiceDescription(),
//                '$serviceLastUpdate' => $service->getServiceLastUpdate()
//            );
//        }
//
//        $users = null;
//        foreach ($result->getFkUcUser() as $user) {
//            /* @var $user EntUser */
//            $users[] = array(
//                'userId' => $user->getUserId(),
//                'userLogin' => $user->getUserLogin(),
//                'userLastConnection' => $user->getUserLastConnection(),
//                'userLastUpdate' => $user->getUserLastUpdate(),
//                'userStatus' => $user->getUserStatus()
//            );
//        }
//
//        /* @var $result EntContact */
//        $data = array(
//            'contactId' => $result->getContactId(),
//            'contactName' => $result->getContactName(),
//            'contactLibelle' => $result->getContactLibelle(),
//            'contactDescription' => $result->getContactDescription(),
//            'contactService' => $result->getContactService(),
//            'contactMailto' => $result->getContactMailto(),
//            'contactLastUpdate' => $result->getContactLastUpdate(),
//            'contactLastUpdate' => $result->getContactLastUpdate(),
//            'fkContactStructure' => $result->getFkContactStructure()->toArray($this->hydrator),
//            'fkCsService' => $services,
//            'fkUcUser' => $users
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
            $successMessage = 'Le contact a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le contact n\'existe pas dans la base.';
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
        $form = $this->contactForm;

        if ($data) {
                    
            $contact = $this->contactService->insert($form, $data);

            if ($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré.');

                return new JsonModel(array(
                    'data' => $contact->getContactId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le contact a bien été inséré.',
                    ),
                ));
            }
        }
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le contact n\'a pas été inséré.',
            ),
        ));
    }

    public function update($id, $data)
    {
        $contact = $this->contactService->getById($id, $this->serviceForm);

        if ($data) {
            $contact = $this->contactService->save($this->contactForm, $data, $contact);

            if ($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été updaté.');

                return new JsonModel(array(
                    'data' => $contact->getContactId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le contact a bien été updaté.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $contact,
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le contact n\'a pas été updaté.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->contactService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le contact a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'Le contact a bien été supprimé.',
            ),
        ));
    }
}
