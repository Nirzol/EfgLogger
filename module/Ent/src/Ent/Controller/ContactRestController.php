<?php

namespace Ent\Controller;

use Ent\Form\ContactForm;
use Ent\Service\ContactDoctrineService;
use JMS\Serializer\Serializer;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of ContactRestController
 *
 * @author fandria
 */
class ContactRestController extends AbstractRestfulController
{

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

    public function __construct(ContactDoctrineService $contactService, ContactForm $contactForm, Serializer $serializer)
    {
        $this->contactService = $contactService;
        $this->contactForm = $contactForm;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->contactService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
//            $data[] = $results->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($results, 'json'));
            $success = false;
            $successMessage = 'Les contacts ont bien été trouvés.';
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
    }

    public function get($id)
    {
        $result = $this->contactService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
//            $data[] = $result->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($result, 'json'));
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

    //EN SOMMEIL
    public function create($data)
    {
//        $form = $this->contactForm;
//
//        if ($data) {
//
//            $contact = $this->contactService->insert($form, $data);
//
//            if ($contact) {
////                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré.');
//
//                return new JsonModel(array(
//                    'data' => $contact->getContactId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le contact a bien été inséré.',
//                    ),
//                ));
//            }
//        }
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le contact n\'a pas été inséré.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $contact = $this->contactService->getById($id, $this->serviceForm);
//
//        if ($data) {
//            $contact = $this->contactService->save($this->contactForm, $data, $contact);
//
//            if ($contact) {
//                $this->flashMessenger()->addSuccessMessage('Le contact a bien été updaté.');
//
//                return new JsonModel(array(
//                    'data' => $contact->getContactId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le contact a bien été updaté.',
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'data' => $contact,
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le contact n\'a pas été updaté.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function delete($id)
    {
//        $this->contactService->delete($id);
//
//        $this->flashMessenger()->addSuccessMessage('Le contact a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'error' => 'Le contact a bien été supprimé.',
//            ),
//        ));
    }

}
