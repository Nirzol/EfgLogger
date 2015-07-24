<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntContact;
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

        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
            'PUT',
            'DELETE',
        )))
        ->addHeaderLine('Content-Type','application/json; charset=utf-8');
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
        foreach ($results as $result) {
            /* @var $result EntContact */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data)
        );
    }

    public function get($id)
    {
        /* @var $result EntContact */
        $result = $this->contactService->getById($id);

        $data[] = $result->toArray($this->hydrator);

        return new JsonModel(
                $result->toArray($this->hydrator)
        );
//        return new JsonModel(array(
//            'data' => $data)
//        );
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
