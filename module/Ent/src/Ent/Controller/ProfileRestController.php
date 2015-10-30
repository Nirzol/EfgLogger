<?php

namespace Ent\Controller;

use Ent\Entity\EntPreference;
use Ent\Form\PreferenceForm;
use Ent\Form\ProfileForm;
use Ent\Service\AttributeDoctrineService;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ProfileDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ProfileRestController extends AbstractRestfulController
{

    /**
     *
     * @var ProfileDoctrineService
     */
    protected $profileService;

    /**
     *
     * @var ProfileDoctrineService
     */
    protected $serviceService;

    /**
     *
     * @var ProfileDoctrineService
     */
    protected $attributeService;

    /**
     *
     * @var PreferenceDoctrineService
     */
    protected $preferenceService;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var ProfileForm
     */
    protected $profileForm;

    /**
     * @var PreferenceForm
     */
    protected $preferenceForm = null;

    /**
     * @var Serializer
     */
    protected $serializer;
    protected $config = null;

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

    public function __construct(ProfileDoctrineService $profileService, ProfileForm $profileForm, PreferenceForm $preferenceForm, AttributeDoctrineService $attributeService, ServiceDoctrineService $serviceService, PreferenceDoctrineService $preferenceService, Serializer $serializer, $config)
    {
        $this->profileService = $profileService;
        $this->attributeService = $attributeService;
        $this->serviceService = $serviceService;
        $this->preferenceService = $preferenceService;
        $this->profileForm = $profileForm;
        $this->preferenceForm = $preferenceForm;
        $this->config = $config;
        $this->serializer = $serializer;
    }

    public function getList()
    {
        $results = $this->profileService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
//            $data[] = $results->toArray($this->hydrator);
            $data = json_decode($this->serializer->serialize($results, 'json', SerializationContext::create()->enableMaxDepthChecks()));
            $success = true;
            $successMessage = 'Les profils ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun profil existe dans la base.';
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
        $result = $this->profileService->getById($id);
        
        /* @var $preference EntPreference */
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => null, 'fkPrefUser' => null, 'fkPrefProfile' => $id));

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            
            $preferenceAttribute = '';
            if ($preference) {
                $preferenceAttribute = Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT);
            }
            
            $data = $preferenceAttribute;
            $success = true;
            $successMessage = 'Le profil a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Le profil n\'existe pas dans la base.';
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
//        $form = $this->profileForm;
//
//        if ($data) {
//            $profile = $this->profileService->insert($form, $data);
//
//            if ($profile) {
////                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');
//
//                return new JsonModel(array(
//                    'data' => $profile->getProfileId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le profile a bien été ajouté.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le profile n\'a pas été ajouté.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $profile = $this->service->getById($id, $this->profileForm);
//
//        if ($data) {
//            $profile = $this->service->save($this->profileForm, $data, $profile);
//
//            if ($profile) {
//                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');
//
//                return new JsonModel(array(
//                    'data' => $profile->getProfileId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'Le profile a bien été modifié.'
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'Le profile n\'a pas été modifié.'
//            ),
//        ));
    }

    //EN SOMMEIL
    public function delete($id)
    {
//        $this->profileService->delete($id);
//
//        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'success' => 'Le profile a bien été supprimé.',
//            ),
//        ));
    }

//    private function extractDataService($result)
//    {
//
//        $prefsProfile = null;
//        foreach ($result->getFkPref() as $pref) {
//            $service = null;
//            if ($pref->getFkPrefService()) {
//                $attributes = null;
//                foreach ($pref->getFkPrefService()->getAttributes() as $attribute) {
//                    /* @var $attribute EntAttribute */
//                    $attributes[] = array(
//                        'attributeId' => $attribute['attribute']->getAttributeId(),
//                        'attributeName' => $attribute['attribute']->getAttributeName(),
//                        'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                        'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                        'attributeLastUpdate' => $attribute['attribute']->getAttributeLastUpdate(),
//                        'value' => $attribute['value']
//                    );
//                }
//                $service = array(
//                    'serviceId' => $pref->getFkPrefService()->getServiceId(),
//                    'serviceName' => $pref->getFkPrefService()->getServiceName(),
//                    'serviceLibelle' => $pref->getFkPrefService()->getServiceLibelle(),
//                    'serviceDescription' => $pref->getFkPrefService()->getServiceDescription(),
//                    'serviceAttributes' => $attributes
//                );
//            }
//
//            /* @var $pref EntPreference */
//            $prefsProfile[] = array(
//                'prefId' => $pref->getPrefId(),
//                'prefAttribute' => $pref->getPrefAttribute(),
//                'prefLastUpdate' => $pref->getPrefLastUpdate(),
//                'prefLastUpdate' => $pref->getPrefLastUpdate(),
//                'fkPrefService' => $service
//            );
//        }
//
//        /* @var $result EntProfile */
//        $data = array(
//            'profileId' => $result->getProfileId(),
//            'profileLdap' => $result->getProfileLdap(),
//            'profileName' => $result->getProfileName(),
//            'profileLibelle' => $result->getProfileLibelle(),
//            'profileDescription' => $result->getProfileDescription(),
//            'profileLastUpdate' => $result->getProfileLastUpdate(),
//            'fkPref' => $prefsProfile
//        );
//
//        return $data;
//    }
}
