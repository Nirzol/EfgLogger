<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPreference;
use Ent\Form\PreferenceForm;
use Ent\Service\PreferenceDoctrineService;

class PreferenceRestController extends AbstractRestfulController {

    /**
     *
     * @var PreferenceDoctrineService
     */
    protected $preferenceService;

    /**
     *
     * @var PreferenceForm
     */
    protected $preferenceForm;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    public function __construct(PreferenceDoctrineService $preferenceService, PreferenceForm $preferenceForm, DoctrineObject $hydrator) {
        $this->preferenceService = $preferenceService;
        $this->preferenceForm = $preferenceForm;
        $this->hydrator = $hydrator;
    }

    public function getList() {
        $results = $this->preferenceService->getAll();

        $data = array();

        foreach ($results as $result) {
            /* @var $result EntPreference */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function create($data) {
        $form = $this->preferenceForm;

        if ($data) {
            $preference = $this->preferenceService->insert($form, $data);

            if ($preference) {
                $this->flashMessenger()->addSuccessMessage('La préférence a bien été ajoutée.');

                return new JsonModel(array(
                    /* @var $preference EntPreference */
                    'data' => $preference->getPrefAttribute(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'La préférence a bien été ajoutée.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'La préférence n\'a pas été ajoutée.'
            ),
        ));
    }

    public function get($id) {
        $result = $this->preferenceService->getById($id);

        $data = array();

        if ($result) {
            /* @var $result EntPreference */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function update($id, $data) {
        $form = $this->preferenceForm;

        $preference = $this->preferenceService->getById($id, $form);

        if ($data) {
            $preference = $this->preferenceService->udpate($id, $form, $data);

            if ($preference) {
                $this->flashMessenger()->addSuccessMessage('La préférence a bien été modifiée.');

                return new JsonModel(array(
                    /* @var $preference EntPreference */
                    'data' => $preference->getPrefAttribute(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'La préférence a bien été modifiée.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'La préférence n\'a pas été modifiée.'
            ),
        ));
    }

    public function delete($id) {
        $this->preferenceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('La préférence a bien été supprimée.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'La préférence a bien été supprimée.',
            ),
        ));
    }

}
