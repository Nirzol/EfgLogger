<?php

namespace Ent\Controller;

use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntPreference;
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

class ProfileController extends AbstractActionController
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

    public function listAction()
    {
        $listProfiles = $this->profileService->getAll();

        return new ViewModel(array(
            'listProfiles' => $listProfiles,
        ));
    }

    public function addAction()
    {
        $attributes = $this->attributeService->getAll();
        $services = $this->serviceService->getAll();

        /* @var $preference EntPreference */
//        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => 'notnull', 'fkPrefUser' => null, 'fkPrefProfile' => null));
        $preferences = $this->preferenceService->findBy(array('fkPrefUser' => null, 'fkPrefProfile' => null));

        $form = $this->profileForm;

        /* @var $serviceMultiCheckbox MultiCheckbox */
        $serviceMultiCheckbox = $form->get('services');
        $result = array();
        // Ajout de l'attribut pour faire foncitonner le modal
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

            $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $serviceGetPost['services'], $this->serviceService, $this->attributeService, $this->serializer);

            $profile = $this->profileService->insert($form, $this->request->getPost());
            if ($profile) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {
                    $formPreference = $this->preferenceForm;
                    //Update la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefProfile' => $profile->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                    $this->preferenceService->insert($formPreference, $dataPreference);
                }
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');

                return $this->redirect()->toRoute('profile');
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'services' => $services,
            'preferences' => $preferences,
//            'preferenceAttribute' => Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT),
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
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
        $id = $this->params('id');
        $form = $this->profileForm;
        $profile = $this->profileService->getById($id, $form);
        $services = $this->serviceService->getAll();
        $attributes = $this->attributeService->getAll();
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => null, 'fkPrefUser' => null, 'fkPrefProfile' => $id));
        $allPreference = $this->preferenceService->findBy(array('fkPrefUser' => null, 'fkPrefProfile' => null));

        $preferences = (object) array_merge_recursive((array) $allPreference, (array) $preference);

        $profileServiceId = array();
        $preferenceArray = Json::decode($preference->getPrefAttribute(), Json::TYPE_ARRAY);
        foreach ($preferenceArray as $preferenceArrayService) {
            $profileServiceId[] = $preferenceArrayService['serviceData']['serviceId'];
            foreach ($allPreference as $allPreferenceValue) {
                if ($preferenceArrayService['serviceData']['serviceId'] === $allPreferenceValue->getFkPrefService()->getServiceId()) {
                    var_dump($allPreferenceValue->getPrefAttribute());
                    var_dump($preference->getPrefAttribute());
                    var_dump($preferenceArrayService['serviceData']['serviceId']);
                    var_dump($preferenceArrayService);
                    break;
                }
            }
        }
        var_dump($profileServiceId);

//        var_dump('$preference');
//
//        var_dump('$preferences');
//        var_dump($preferences);
//        var_dump('$allPreference');
//        var_dump($allPreference);

        /* @var $serviceMultiCheckbox MultiCheckbox */
        $serviceMultiCheckbox = $form->get('services');
        $result = array();
        // Ajout de l'attribut pour faire foncitonner le modal
//        var_dump($serviceMultiCheckbox->getValueOptions());
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

            $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $serviceGetPost['services'], $this->serviceService, $this->attributeService, $this->serializer);

            $profile = $this->profileService->save($form, $this->request->getPost(), $profile);

            if ($profile) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {
                    $formPreference = $this->preferenceForm;
                    //Update la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefProfile' => $profile->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                    $this->preferenceService->save($formPreference, $dataPreference, $preference);
                }

                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');

                return $this->redirect()->toRoute('profile');
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
        $id = $this->params('id');

        $this->profileService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');

        return $this->redirect()->toRoute('profile');
    }

}
