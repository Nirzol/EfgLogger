<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntUser;
use Ent\Form\UserForm;
use Ent\Service\UserDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserRestController extends AbstractRestfulController
{

    /**
     *
     * @return UserDoctrineService
     */
    protected $userService;

    /**
     *
     * @var UserForm
     */
    protected $userForm;

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

    public function __construct(UserDoctrineService $userService, UserForm $userForm, DoctrineObject $hydrator)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->userService->getAll();

        $data = array();
        foreach ($results as $result) {
            /* @var $result EntUser */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data)
        );
    }

    public function get($id)
    {
        /* @var $result EntUser */
        $result = $this->userService->getById($id);
//        var_dump($result);

        $data[] = $result->toArray($this->hydrator);

        return new JsonModel(array(
            'data' => $data)
        );
    }

    public function create($data)
    {
        $form = $this->userForm;

        if ($data) {
            
//            object(Zend\Stdlib\Parameters)[140]
//  private 'storage' (ArrayObject) => 
//    array (size=3)
//      'userLogin' => string 'ffff' (length=4)
//      'userStatus' => string '1' (length=1)
//      'fkUrRole' => string '1' (length=1)
                    
            $user = $this->userService->insert($form, $data);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');

                return new JsonModel(array(
                    'data' => $user->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'user  a bien été insérer.',
                    ),
                ));
            }
        }
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\'user n\'a pas été insérer.',
            ),
        ));
    }

    public function update($id, $data)
    {
        $user = $this->userService->getById($id, $this->userForm);

        if ($data) {
            $user = $this->userService->save($this->userForm, $data, $user);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updater.');

                return new JsonModel(array(
                    'data' => $user->getId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'user a bien été updater.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $user,
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\'user n\'a pas été updater.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->userService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'L\'user a bien été supprimé.',
            ),
        ));
    }

}
