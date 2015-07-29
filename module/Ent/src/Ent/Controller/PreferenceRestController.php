<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPreference;
use Ent\Entity\EntProfile;
use Ent\Entity\EntService;
use Ent\Entity\EntStatus;
use Ent\Entity\EntUser;
use Ent\Form\PreferenceForm;
use Ent\Service\PreferenceDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

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

    public function __construct(PreferenceDoctrineService $preferenceService, PreferenceForm $preferenceForm, DoctrineObject $hydrator) {
        $this->preferenceService = $preferenceService;
        $this->preferenceForm = $preferenceForm;
        $this->hydrator = $hydrator;
    }

    public function getList() {
        $results = $this->preferenceService->getAll();

        $data = array();

        foreach ($results as $result) {
            /* @var $user EntUser */
            $users = null;
            if (!is_null($result->getFkPrefUser())) {
                $user = $result->getFkPrefUser();
                $users = array(
                    'userId' => $user->getUserId(),
                    'userLogin' => $user->getUserLogin(),
                    'userLastConnection' => $user->getUserLastConnection(),
                    'userLastUpdate' => $user->getUserLastUpdate(),
                    'userStatus' => $user->getUserStatus()
                );
            }
            
            /* @var $service EntService */
            $services = null;
            if (!is_null($result->getFkPrefService())) {
                $service = $result->getFkPrefService();
                $services = array(
                    'serviceId' => $service->getServiceId(),
                    'serviceName' => $service->getServiceName(),
                    'serviceLibelle' => $service->getServiceLibelle(),
                    'serviceDescription' => $service->getServiceDescription(),
                    'serviceLastUpdate' => $service->getServiceLastUpdate()
                );
            }
            
            /* @var $status EntStatus */
            $status = null;
            if (!is_null($result->getFkPrefStatus())) {
                $status = array(
                    'statusId' => $result->getFkPrefStatus()->getStatusId(),
                    'statusName' => $result->getFkPrefStatus()->getStatusName(),
                    'statusLibelle' => $result->getFkPrefStatus()->getStatusLibelle(),
                    'statusDescription' => $result->getFkPrefStatus()->getStatusDescription(),
                    'statusLastUpdate' => $result->getFkPrefStatus()->getStatusLastUpdate()
                );
            }
            
            /* @var $profile EntProfile */
            $profiles = null;
            if (!is_null($result->getFkPrefProfile())) {
                $profile = $result->getFkPrefProfile();
                $profiles = array(
                    'profileId' => $profile->getProfileId(),
                    'profileLdap' => $profile->getProfileLdap(),
                    'profileName' => $profile->getProfileName(),
                    'profileLibelle' => $profile->getProfileLibelle(),
                    'profileDescription' => $profile->getProfileDescription(),
                    'profileLastUpdate' => $profile->getProfileLastUpdate()
                );
            }
            
            /* @var $result EntPreference */
            $data[] = array(
                'prefId' => $result->getPrefId(),
                'prefAttribute' => stream_get_contents($result->getPrefAttribute()),
                'prefLastUpdate' => $result->getPrefLastUpdate(),
                'fkPrefUser' => $users,
                'fkPrefService' => $services,
                'fkPrefStatus' => $status,
                'fkPrefProfile' => $profiles
            );
        }

        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function get($id) {
        $result = $this->preferenceService->getById($id);

        $data = array();

        if ($result) {
            /* @var $user EntUser */
            $users = null;
            if (!is_null($result->getFkPrefUser())) {
                $user = $result->getFkPrefUser();
                $users = array(
                    'userId' => $user->getUserId(),
                    'userLogin' => $user->getUserLogin(),
                    'userLastConnection' => $user->getUserLastConnection(),
                    'userLastUpdate' => $user->getUserLastUpdate(),
                    'userStatus' => $user->getUserStatus()
                );
            }
            
            /* @var $service EntService */
            $services = null;
            if (!is_null($result->getFkPrefService())) {
                $service = $result->getFkPrefService();
                $services = array(
                    'serviceId' => $service->getServiceId(),
                    'serviceName' => $service->getServiceName(),
                    'serviceLibelle' => $service->getServiceLibelle(),
                    'serviceDescription' => $service->getServiceDescription(),
                    'serviceLastUpdate' => $service->getServiceLastUpdate()
                );
            }
            
            /* @var $status EntStatus */
            $status = null;
            if (!is_null($result->getFkPrefStatus())) {
                $status = array(
                    'statusId' => $result->getFkPrefStatus()->getStatusId(),
                    'statusName' => $result->getFkPrefStatus()->getStatusName(),
                    'statusLibelle' => $result->getFkPrefStatus()->getStatusLibelle(),
                    'statusDescription' => $result->getFkPrefStatus()->getStatusDescription(),
                    'statusLastUpdate' => $result->getFkPrefStatus()->getStatusLastUpdate()
                );
            }
            
            /* @var $profile EntProfile */
            $profiles = null;
            if (!is_null($result->getFkPrefProfile())) {
                $profile = $result->getFkPrefProfile();
                $profiles = array(
                    'profileId' => $profile->getProfileId(),
                    'profileLdap' => $profile->getProfileLdap(),
                    'profileName' => $profile->getProfileName(),
                    'profileLibelle' => $profile->getProfileLibelle(),
                    'profileDescription' => $profile->getProfileDescription(),
                    'profileLastUpdate' => $profile->getProfileLastUpdate()
                );
            }
            
            /* @var $result EntPreference */
            $data = array(
                'prefId' => $result->getPrefId(),
                'prefAttribute' => stream_get_contents($result->getPrefAttribute()),
                'prefLastUpdate' => $result->getPrefLastUpdate(),
                'fkPrefUser' => $users,
                'fkPrefService' => $services,
                'fkPrefStatus' => $status,
                'fkPrefProfile' => $profiles
            );
        }

        return new JsonModel(
            $data
        );
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
