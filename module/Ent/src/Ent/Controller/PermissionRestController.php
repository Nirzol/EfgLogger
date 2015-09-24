<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Form\PermissionForm;
use Ent\Service\PermissionDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PermissionRestController extends AbstractRestfulController
{

    /**
     *
     * @return PermissionDoctrineService
     */
    protected $permissionService;

    /**
     *
     * @var PermissionForm
     */
    protected $permissionForm;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function options()
    {
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

    public function __construct(PermissionDoctrineService $permissionService, PermissionForm $permissionForm, DoctrineObject $hydrator)
    {
        $this->permissionService = $permissionService;
        $this->permissionForm = $permissionForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->permissionService->getAll();

        $data = array();
        $successMessage = '';
        $errorMessage = '';
        if ($results) {
            foreach ($results as $result) {
                $data[] = $result->toArray($this->hydrator);
                $success = false;
                $successMessage = 'Les permissions ont bien été trouvé.';
            }
        } else {
            $success = false;
            $errorMessage = 'Aucun permission existe dans la base.';
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
        $result = $this->permissionService->getById($id);

        $data = array();
        $successMessage = '';
        $errorMessage = '';
        if ($result) {
            $data[] = $result->toArray($this->hydrator);
            $success = false;
            $successMessage = 'La permission a bien été trouver.';
        } else {
            $success = false;
            $errorMessage = 'La permission n\'existe pas dans la base.';
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
        $form = $this->permissionForm;

        if ($data) {

            $permission = $this->permissionService->insert($form, $data);

            if ($permission) {
                $this->flashMessenger()->addSuccessMessage('La permission a bien été insérer.');

                return new JsonModel(array(
                    'data' => $permission->getPermissionId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'La permission  a bien été insérer.',
                    ),
                ));
            }
        }
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'La permission n\'a pas été insérer.',
            ),
        ));
    }

    public function update($id, $data)
    {
        $permission = $this->permissionService->getById($id, $this->permissionForm);

        if ($data) {
            $permission = $this->permissionService->save($this->permissionForm, $data, $permission);

            if ($permission) {
                $this->flashMessenger()->addSuccessMessage('La permission a bien été updater.');

                return new JsonModel(array(
                    'data' => $permission->getPermissionId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'La permission '.$id.' a bien été updater.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $permission,
            'success' => false,
            'flashMessages' => array(
                'error' => 'La permission '.$id.' n\'a pas été updater.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->permissionService->delete($id);

        $this->flashMessenger()->addSuccessMessage('La permission a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'La permission a bien été supprimé.',
            ),
        ));
    }

}
