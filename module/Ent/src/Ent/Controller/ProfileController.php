<?php

namespace Ent\Controller;

use Doctrine\Common\Collections\Criteria;
use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntPreference;
use Ent\Entity\EntProfile;
use Ent\Entity\EntUser;
use Ent\Form\PreferenceForm;
use Ent\Form\ProfileForm;
use Ent\Service\AttributeDoctrineService;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ProfileDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\Serializer;
use Zend\Form\Element\MultiCheckbox;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;

class ProfileController extends AbstractActionController
{

    /**
     * @var ProfileDoctrineService
     */
    protected $profileService = null;

    /**
     * @var ProfileDoctrineService
     */
    protected $serviceService = null;

    /**
     * @var ProfileDoctrineService
     */
    protected $attributeService = null;

    /**
     * @var PreferenceDoctrineService
     */
    protected $preferenceService = null;

    /**
     * @var \Ent\Service\UserDoctrineService
     */
    protected $userService = null;

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @var ProfileForm
     */
    protected $profileForm = null;

    /**
     * @var \Ent\Form\UserForm
     */
    protected $userForm = null;

    /**
     * @var PreferenceForm
     */
    protected $preferenceForm = null;

    /**
     * @var Serializer
     */
    protected $serializer = null;
    protected $config = null;

    public function __construct(ProfileDoctrineService $profileService, ProfileForm $profileForm, PreferenceForm $preferenceForm, AttributeDoctrineService $attributeService, ServiceDoctrineService $serviceService, PreferenceDoctrineService $preferenceService, \Ent\Service\UserDoctrineService $userService, \Ent\Form\UserForm $userForm, Serializer $serializer, $config)
    {
        $this->profileService = $profileService;
        $this->attributeService = $attributeService;
        $this->serviceService = $serviceService;
        $this->preferenceService = $preferenceService;
        $this->profileForm = $profileForm;
        $this->preferenceForm = $preferenceForm;
        $this->config = $config;
        $this->serializer = $serializer;
        $this->userService = $userService;
        $this->userForm = $userForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $listProfiles = $this->profileService->getAll();

        return new ViewModel(array(
            'listProfiles' => $listProfiles,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $attributes = $this->attributeService->getAll();
        //        $services = $this->serviceService->getAll();

        /* @var $preference EntPreference */
        //        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => 'notnull', 'fkPrefUser' => null, 'fkPrefProfile' => null));
        $preferenceServices = $this->preferenceService->findBy(array('fkPrefUser' => null, 'fkPrefProfile' => null));

        $form = $this->profileForm;

        /* @var $serviceMultiCheckbox MultiCheckbox */
        $serviceMultiCheckbox = $form->get('fkPsService');
        $result = array();
        // Ajout de l'attribut pour faire fonctionner le modal
        foreach ($serviceMultiCheckbox->getValueOptions() as $value) {
            //            $value['attributes'] = array('data-toggle' => 'modal', 'data-target' => '#serviceIdModal' . $value['value']);
            $test = "if(this.checked){ $('#serviceIdModal" . $value['value'] . "').modal(); }";
            $value['attributes'] = array('onChange' => $test);
            $result[] = $value;
        }
        $serviceMultiCheckbox->setValueOptions($result);

        if ($this->request->isPost()) {
            $serviceGetPost = $this->request->getPost();

            /* @var $entPlugin EntPlugin */
            $entPlugin = $this->EntPlugin();

            if ($entPlugin->checkMaxInputVars() || count($_POST, COUNT_RECURSIVE) >= ini_get("max_input_vars")) {
                error_log(date("Y-m-d H:i:s") . ' : POST has been truncated.');
                $this->flashMessenger()->addSuccessMessage('CANCEL : POST has been truncated. $_POST ' . count($_POST, COUNT_RECURSIVE) . ' > max_input_vars ' . ini_get("max_input_vars"));
                return $this->redirect()->toRoute('zfcadmin/profile');
            } else {

                $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $serviceGetPost['fkPsService'], $this->serviceService, $this->attributeService, $this->serializer);

                $profile = $this->profileService->insert($form, $this->request->getPost());
                if ($profile) {
                    if (isset($prefAttribute) && !empty($prefAttribute)) {
                        $formPreference = $this->preferenceForm;
                        //Update la prefrence du service
                        $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefProfile' => $profile->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                        $this->preferenceService->insert($formPreference, $dataPreference);
                    }
                    $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');

                    return $this->redirect()->toRoute('zfcadmin/profile');
                }
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'preferenceServices' => $preferenceServices,
            'form' => $form->prepare(),
                //            'services' => $services,
                //            'preferenceAttribute' => Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $profile = $this->profileService->getById($id);

        /* @var $preference EntPreference */
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => null, 'fkPrefUser' => null, 'fkPrefProfile' => $id));

        if (!$profile) {
            return $this->notFoundAction();
        }

        $preferenceAttribute = '';
        if ($preference) {
            $preferenceAttribute = Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT);
        }

        return new ViewModel(array(
            'profile' => $profile,
            'preferenceAttribute' => $preferenceAttribute,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->profileForm;
        /* @var $profile EntProfile */
        $profile = $this->profileService->getById($id, $form);
        $services = $this->serviceService->getAll();
        $attributes = $this->attributeService->getAll();
        $preferenceProfile = $this->preferenceService->findOneBy(array('fkPrefService' => null, 'fkPrefUser' => null, 'fkPrefProfile' => $id));

        /* DEBUT gestion du merge des preference : ceux des services + celui du Profil */
        $preferences = '';
        //Récupèration de la preference du profil
        if ($preferenceProfile) {
            $preferences = Json::decode($preferenceProfile->getPrefAttribute(), Json::TYPE_ARRAY);
        }

        // Récuperation les preferences des services en enlevant ceux du profil
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->notIn('fkPrefService', $profile->getFkPsService()->toArray()));
        $preferenceServices = $this->preferenceService->matching($criteria);

        // merge des attributs
        foreach ($preferenceServices as $preferenceService) {
            $preferences = array_merge_recursive(Json::decode($preferenceService->getPrefAttribute(), Json::TYPE_ARRAY), $preferences);
        }
        /* FIN gestion du merge des preference : ceux des services + celui du Profil */

        /* DEBUT gestion des multicheckbox pour le Modal Boostrap */
        /* @var $serviceMultiCheckbox MultiCheckbox */
        $serviceMultiCheckbox = $form->get('fkPsService');
        $result = array();
        // Ajout de l'attribut pour faire fonctionner le modal
        foreach ($serviceMultiCheckbox->getValueOptions() as $value) {
            // Construction de l'attribut pour le modal
            $test = "if(this.checked){ $('#serviceIdModal" . $value['value'] . "').modal(); }";
            $value['attributes'] = array('onChange' => $test);
            $result[] = $value;
        }
        //Reasigne les values avec le nouveau attribut
        $serviceMultiCheckbox->setValueOptions($result);
        /* FIN gestion des multicheckbox pour le Modal Boostrap + gestion checked */

        if ($this->request->isPost()) {
            $serviceGetPost = $this->request->getPost();

            //var_dump($serviceGetPost);
            //            var_dump(count($_POST, COUNT_RECURSIVE));
            //var_dump(ini_get('max_input_vars'));
            /* @var $entPlugin EntPlugin */
            $entPlugin = $this->EntPlugin();

            if ($entPlugin->checkMaxInputVars() || count($_POST, COUNT_RECURSIVE) >= ini_get("max_input_vars")) {
                error_log(date("Y-m-d H:i:s") . ' : POST has been truncated.');
                $this->flashMessenger()->addSuccessMessage('CANCEL : POST has been truncated. $_POST ' . count($_POST, COUNT_RECURSIVE) . ' > max_input_vars ' . ini_get("max_input_vars"));
                return $this->redirect()->toRoute('zfcadmin/profile');
            } else {

                $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $serviceGetPost['fkPsService'], $this->serviceService, $this->attributeService, $this->serializer);

                $profile = $this->profileService->save($form, $this->request->getPost(), $profile);

                if ($profile) {
                    if (isset($prefAttribute) && !empty($prefAttribute)) {
                        $formPreference = $this->preferenceForm;
                        //Update la prefrence du service
                        $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefProfile' => $profile->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                        $this->preferenceService->save($formPreference, $dataPreference, $preferenceProfile);
                    }

                    $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');

                    return $this->redirect()->toRoute('zfcadmin/profile');
                }
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'services' => $services,
            'preferences' => $preferences,
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $this->profileService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/profile');
    }

    public function profilingAction()
    {
        if (!$this->isGranted('profiling_profile')) {
            throw new UnauthorizedException('You are not allowed profiling_profile !');
        }

        $profiles = $this->profileService->getAll();
        if (!$profiles) {
            $this->flashMessenger()->addSuccessMessage('Aucun profil existant');
            return $this->redirect()->toRoute('zfcadmin/profile');
        }

        $users = $this->userService->getAll();

        $config = $this->config;

        /* @var $user EntUser */
        foreach ($users as $user) {$form = null;
            $idProfile = $this->entPlugin()->getProfilIdMatchingUserLdap($user->getUserLogin(), $profiles);
            // if false = student --- if null = pas d'access
            if ($idProfile !== null && $idProfile) {
                $data = array('fkUpProfile' => $idProfile);

                $form = $this->userForm;
                $this->userService->save($form, $data, $user);
            }
        }

        return $this->redirect()->toRoute('zfcadmin/profile');
    }

}
