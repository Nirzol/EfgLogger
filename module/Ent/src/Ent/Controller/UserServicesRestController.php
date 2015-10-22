<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAttribute;
use Ent\Entity\EntPreference;
use Ent\Entity\EntProfile;
use Ent\Entity\EntUser;
use Ent\Form\UserForm;
use Ent\Service\UserDoctrineService;
use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserServicesRestController extends AbstractRestfulController
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
    
    /**
     * @var SearchLdapController
     */
    protected $searchLdapController = null;

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

    public function __construct(UserDoctrineService $userService, UserForm $userForm, DoctrineObject $hydrator, SearchLdapController $searchLdapController)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
        $this->hydrator = $hydrator;
        $this->searchLdapController = $searchLdapController;
    }

    /* get the authenticated user (waiting for an other controller ?) */
    public function getList()
    {
        $login = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $login = $authService->getIdentity()->getUserLogin();
        }
        $results = null;
        if (!is_null($login)) {
            $results = $this->userService->findBy(array('userLogin' => $login));
    //        $results = $this->userService->getAll();
        }
        $data = array();
        $successMessage = '';
        $errorMessage = '';
        if (!is_null($results)) {
            foreach ($results as $result) {

                $data = $this->extractDataService($result, $login);
//                $data[] = $result->toArray($this->hydrator);
                $success = true;
                $successMessage = 'L\'user a bien été trouvé.';
//                $successMessage = 'Les users ont bien été trouvé.';
            }
        } else {
            $success = false;
            $errorMessage = 'L\'user n\'existe pas dans la base.';
//            $errorMessage = 'Aucun user existe dans la base.';
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

        $data = array();
        $successMessage = '';
        $errorMessage = '';
        if ($result) {
            $data = $this->extractDataService($result, null);
//            $data[] = $result->toArray($this->hydrator);
            $success = true;
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
        $form = $this->userForm;

        if ($data) {

//            object(Zend\Stdlib\Parameters)[140]
//  private 'storage' (ArrayObject) => 
//    array (size=3)
//      'userLogin' => string 'ffff' (length=4)
//      'userStatus' => string '1' (length=1)
//      'fkUrRole' => string '1' (length=1)

            /* @var $user EntUser */
            $user = $this->userService->insert($form, $data);

            if ($user) {
//                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');

                return new JsonModel(array(
                    'data' => $user->getUserId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'user a bien été insérer.',
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
//                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updater.');

                return new JsonModel(array(
                    'data' => $user->getUserId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'L\'user ' . $id . ' a bien été updater.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $user,
            'success' => false,
            'flashMessages' => array(
                'error' => 'L\'user ' . $id . ' n\'a pas été updater.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->userService->delete($id);

//        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'L\'user a bien été supprimé.',
            ),
        ));
    }

    private function extractDataService($result, $login) {

        $profiles = null;
        foreach ($result->getFkUpProfile() as $profile) {
            
            $prefsProfile = null;
            foreach ($profile->getFkPref() as $pref) {                
                $service = null;
                if ($pref->getFkPrefService()) {
                    $data = $pref->getFkPrefService();
                    $attributes = $this->extractAttributes($data, $login);
                 
                    $service = array(
                        'serviceName' => $pref->getFkPrefService()->getServiceName(),
                        'serviceLibelle' => $pref->getFkPrefService()->getServiceLibelle(),
                        'serviceDescription' => $pref->getFkPrefService()->getServiceDescription(),
                        'serviceAttributes' => $attributes
                    );
                }
                                
                /* @var $pref EntPreference */
                $prefsProfile[] = array(
//                    'prefId' => $pref->getPrefId(),
//                    'prefAttribute' => $pref->getPrefAttribute(),
                    'prefService' => $service
                );
            }
            
            /* @var $profile EntProfile */
            $profiles[] = array(
                'profilePref' => $prefsProfile
            );
        }
        
        return $profiles;
    }
    
    private function extractAttributes($data, $login = null) {
        $attributes = null;
        $mailHost = '';
        
         if (!is_null($login)) {
            $mailHost = $this->searchLdapController->getMailHostByUid($login);
         }
        foreach ($data->getAttributes() as $attribute) {
            /* @var $attribute EntAttribute */
            /* match mailhost of mail service with mailhost of user */
            switch ($attribute['attribute']->getAttributeName()) {
                case 'o365.parisdescartes.fr':
                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
                        $attributes[] = array(
                            'url' => $attribute['value']
//                            'attributeName' => 'url',
////                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'value' => $attribute['value']
                        );
                    }
                    break;
                case 'mataram.parisdescartes.fr':
                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
                        $attributes[] = array(
                            'url' => $attribute['value']
//                            'attributeName' => 'url',
////                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'value' => $attribute['value']
                        );
                    }
                    break;
                case 'owa.parisdescartes.fr':
                    if (strcmp($attribute['attribute']->getAttributeName(), $mailHost) === 0) {
                        $attributes[] = array(
                            'url' => $attribute['value']
//                            'attributeName' => 'url',
////                            'attributeName' => $attribute['attribute']->getAttributeName(),
//                            'value' => $attribute['value']
                        );
                    }
                    break;
                default:
                    $attributes[] = array(
                        $attribute['attribute']->getAttributeName() => $attribute['value']
//                        'attributeName' => $attribute['attribute']->getAttributeName(),
//                        'value' => $attribute['value']
                    );
                    break;
            }            
        }                    
        return $attributes;
    }
}
