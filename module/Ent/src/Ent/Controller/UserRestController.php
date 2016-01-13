<?php

namespace Ent\Controller;

use Ent\Entity\EntPreference;
use Ent\Entity\EntProfile;
use Ent\Form\UserForm;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\UserDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
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
     * @var PreferenceDoctrineService
     */
    protected $preferenceService;
    

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

    public function __construct(UserDoctrineService $userService, UserForm $userForm, PreferenceDoctrineService $preferenceService, Serializer $serializer)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
        $this->serializer = $serializer;
        $this->preferenceService = $preferenceService;
    }

    public function getList()
    {
        $results = $this->userService->getAll();

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($results) {
            $data = Json::decode($this->serializer->serialize($results, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'Les users ont bien été trouvés.';
        } else {
            $success = false;
            $errorMessage = 'Aucun user dans la base de données.';
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
        $result = $this->userService->getById($id);

        $data = '';
        $successMessage = '';
        $errorMessage = '';

        if ($result) {
            $data = Json::decode($this->serializer->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_OBJECT);
            $success = true;
            $successMessage = 'L\'user a bien été trouvé.';
        } else {
            $success = false;
            $errorMessage = 'Aucun user dans la base de données.';
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
//        $login = null;
//        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
//        if ($authService->hasIdentity()) {
//            $login = $authService->getIdentity()->getUserLogin();
//        }
//        $results = null;
//        if (!is_null($login)) {
//            $results = $this->userService->findBy(array('userLogin' => $login));
//            //        $results = $this->userService->getAll();
//        }
//        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//        if (!is_null($results)) {
//            foreach ($results as $result) {
//
//                $data[] = $this->extractDataService($result, $login);
////                $data[] = $result->toArray($this->hydrator);
//                $success = true;
//                $successMessage = 'L\'user a bien été trouvé.';
////                $successMessage = 'Les users ont bien été trouvé.';
//            }
//        } else {
//            $success = false;
//            $errorMessage = 'L\'user n\'existe pas dans la base.';
////            $errorMessage = 'Aucun user existe dans la base.';
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
//    public function get($id)
//    {
//        $result = $this->userService->getById($id);
//
//        $data = array();
//        $successMessage = '';
//        $errorMessage = '';
//        if ($result) {
//            $data[] = $this->extractDataService($result, null);
////            $data[] = $result->toArray($this->hydrator);
//            $success = true;
//            $successMessage = 'L\'user a bien été trouver.';
//        } else {
//            $success = false;
//            $errorMessage = 'L\'user n\'existe pas dans la base.';
//        }
////        return new JsonModel(
////            $data
////        );
//        return new JsonModel(array(
//            'data' => $data,
//            'success' => $success,
//            'flashMessages' => array(
//                'success' => $successMessage,
//                'error' => $errorMessage,
//            ),
//        ));
//    }
    //EN SOMMEIL
    public function create($data)
    {
//        $form = $this->userForm;
//
//        if ($data) {
//            /* @var $user EntUser */
//            $user = $this->userService->insert($form, $data);
//
//            if ($user) {
////                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');
//
//                return new JsonModel(array(
//                    'data' => $user->getUserId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\'user a bien été insérer.',
//                    ),
//                ));
//            }
//        }
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\'user n\'a pas été insérer.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function update($id, $data)
    {
//        $user = $this->userService->getById($id, $this->userForm);
//
//        if ($data) {
//            $user = $this->userService->save($this->userForm, $data, $user);
//
//            if ($user) {
////                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updater.');
//
//                return new JsonModel(array(
//                    'data' => $user->getUserId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'L\'user ' . $id . ' a bien été updater.',
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'data' => $user,
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'L\'user ' . $id . ' n\'a pas été updater.',
//            ),
//        ));
    }

    //EN SOMMEIL
    public function delete($id)
    {
//        $this->userService->delete($id);
//
////        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'error' => 'L\'user a bien été supprimé.',
//            ),
//        ));
    }

//    private function extractDataService($result, $login)
//    {
//        $contacts = null;
//        foreach ($result->getFkUcContact() as $contact) {
//            /* @var $contact EntContact */
//            $contacts[] = array(
//                'contactId' => $contact->getContactId(),
//                'contactName' => $contact->getContactName(),
//                'contactLibelle' => $contact->getContactLibelle(),
//                'contactDescription' => $contact->getContactDescription(),
//                'contactService' => $contact->getContactService(),
//                'contactMailto' => $contact->getContactMailto()
//            );
//        }
//
//        $profiles = null;
//        foreach ($result->getFkUpProfile() as $profile) {
//
//            $prefsProfile = null;
//            foreach ($profile->getFkPref() as $pref) {
//                $service = null;
//                if ($pref->getFkPrefService()) {
//                    $data = $pref->getFkPrefService();
//                    $attributes = $this->extractAttributes($data, $login);
//
//                    $service = array(
//                        'serviceId' => $pref->getFkPrefService()->getServiceId(),
//                        'serviceName' => $pref->getFkPrefService()->getServiceName(),
//                        'serviceLibelle' => $pref->getFkPrefService()->getServiceLibelle(),
//                        'serviceDescription' => $pref->getFkPrefService()->getServiceDescription(),
//                        'serviceAttributes' => $attributes
//                    );
//                }
//
//                /* @var $pref EntPreference */
//                $prefsProfile[] = array(
//                    'prefId' => $pref->getPrefId(),
//                    'prefAttribute' => $pref->getPrefAttribute(),
//                    'fkPrefService' => $service
//                );
//            }
//
//            /* @var $profile EntProfile */
//            $profiles[] = array(
//                'profileId' => $profile->getProfileId(),
//                'profileLdap' => $profile->getProfileId(),
//                'profileName' => $profile->getProfileName(),
//                'profileLibelle' => $profile->getProfileLibelle(),
//                'profileDescription' => $profile->getProfileDescription(),
//                'profilePref' => $prefsProfile
//            );
//        }
//
//        $roles = null;
//        foreach ($result->getFkUrRole() as $role) {
//            /* @var $role EntHierarchicalRole */
//            $roles[] = array(
//                'roleId' => $role->getId(),
//                'roleName' => $role->getName(),
//                'roleChildren' => $role->getChildren(),
//                'rolePermissions' => $role->getPermissions()
//            );
//        }
//
//        /* @var $result EntUser */
//        $data = array(
//            'userId' => $result->getUserId(),
//            'userLogin' => $result->getUserLogin(),
//            'userLastConnection' => $result->getUserLastConnection(),
//            'userStatus' => $result->getUserStatus(),
//            'fkUcContact' => $contacts,
//            'fkUpProfile' => $profiles,
//            'fkUrRole' => $roles
//        );
//
//        return $data;
//    }
//    private function extractAttributes($data, $login = null)
//    {
//        $attributes = null;
//        $mailHost = null;
//
//        if (!is_null($login)) {
//            $mailHost = $this->searchLdapController->getMailHostByUid($login);
//        }
//        foreach ($data->getAttributes() as $attribute) {
//            /* @var $attribute EntAttribute */
//            /* match mailhost of mail service with mailhost of user */
//            switch ($attribute['attribute']->getAttributeName()) {
//                case 'o365.parisdescartes.fr':
//                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
//                        $attributes[] = array(
//                            'attributeId' => $attribute['attribute']->getAttributeId(),
//                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                            'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                            'value' => $attribute['value']
//                        );
//                    }
//                    break;
//                case 'mataram.parisdescartes.fr':
//                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
//                        $attributes[] = array(
//                            'attributeId' => $attribute['attribute']->getAttributeId(),
//                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                            'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                            'value' => $attribute['value']
//                        );
//                    }
//                    break;
//                case 'owa.parisdescartes.fr':
//                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
//                        $attributes[] = array(
//                            'attributeId' => $attribute['attribute']->getAttributeId(),
//                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                            'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                            'value' => $attribute['value']
//                        );
//                    }
//                    break;
//                default:
//                    $attributes[] = array(
//                        'attributeId' => $attribute['attribute']->getAttributeId(),
//                        'attributeName' => $attribute['attribute']->getAttributeName(),
//                        'attributeLibelle' => $attribute['attribute']->getAttributeLibelle(),
//                        'attributeDescription' => $attribute['attribute']->getAttributeDescription(),
//                        'value' => $attribute['value']
//                    );
//                    break;
//            }
//        }
//        return $attributes;
//    }
    
    public function getServicesAction() {
        $login = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $login = $authService->getIdentity()->getUserLogin();
        }
        
        $success = false;
        $successMessage = '';
        $errorMessage = '';
        $data = null;
        $user = null;
        $profiles = null;
        if (!is_null($login)) {
            $user = $this->userService->findOneBy(array('userLogin' => $login));
            
            /* we get the profile of the user at this time*/
            if ($user) {
                $success = true;
                $successMessage = 'L\'user a bien été trouvé.';
                $FkUpProfile = $user->getFkUpProfile();
                $profiles = $FkUpProfile->toArray();
                
                //sort by priority value
                usort($profiles, function($a, $b) {
                    return $a->getProfilePriority() > $b->getProfilePriority();
                });
                                
                $preferences = null;
                foreach ($profiles as $profile) {
                    /* @var $profile EntProfile */
                    $preference = $this->preferenceService->findOneBy(array('fkPrefProfile' => $profile->getProfileId()));
                    /* @var $preference EntPreference */
//                    $preferences[] = Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT);
                    $preferences[] = json_decode(json_encode(Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT)), true);
                }
//                $preferences[0] = $this->array_merge_recursive_simple($preferences[0], $preferences[1]);
//                $preferences[0] = $this->array_merge_recursive_distinct($preferences[0], $preferences[1]);
//                $preferences[0] = array_merge_recursive($preferences[0], $preferences[1]);
//                echo count($preferences);
                    for ($i = 1 ; $i < count($preferences) ; $i++) {
                    $preferences[0] = $this->array_merge_recursive_simple($preferences[0], $preferences[$i]);
                    $preferences[0] = $this->array_merge_recursive_simple($preferences[0], $preferences[$i]);
                }
                $data = $preferences;                
            } else {
                $success = false;
                $errorMessage = 'L\'user n\'existe pas dans la base.';
            }
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
    
    function array_merge_recursive_simple() {

        if (func_num_args() < 2) {
            trigger_error(__FUNCTION__ .' needs two or more array arguments', E_USER_WARNING);
            return;
        }
        $arrays = func_get_args();
        $merged = array();
        while ($arrays) {
            $array = array_shift($arrays);
            if (!is_array($array)) {
                trigger_error(__FUNCTION__ .' encountered a non array argument', E_USER_WARNING);
                return;
            }
            if (!$array)
                continue;
            foreach ($array as $key => $value)
                if (is_string($key))
                    if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key]))
                        $merged[$key] = call_user_func(__FUNCTION__, $merged[$key], $value);
                    else
                        $merged[$key] = $value;
                else
                    $merged[] = $value;
        }
        return $merged;
    }


    function array_merge_recursive_distinct ( array &$array1, array &$array2 )
    {
      $merged = $array1;

      foreach ( $array2 as $key => &$value )
      {
        if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
        {
          $merged [$key] = array_merge_recursive_distinct ( $merged [$key], $value );
        }
        else
        {
          $merged [$key] = $value;
        }
      }

      return $merged;
    }
}
