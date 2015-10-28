<?php

namespace Ent\Controller;

use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntPreference;
use Ent\Entity\EntService;
use Ent\Form\ProfileForm;
use Ent\Service\AttributeDoctrineService;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ProfileDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as Serializer2;
use Zend\Form\Element\MultiCheckbox;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Serializer\Serializer;
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
     * @var \Ent\Form\PreferenceForm
     */
    protected $preferenceForm = null;

    /**
     * @var Serializer
     */
    protected $serializer;
    protected $config = null;

    public function __construct(ProfileDoctrineService $profileService, ProfileForm $profileForm, \Ent\Form\PreferenceForm $preferenceForm, AttributeDoctrineService $attributeService, ServiceDoctrineService $serviceService, PreferenceDoctrineService $preferenceService, Serializer2 $serializer, $config)
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
        $preference = $this->preferenceService->findOneBy(array('fkPrefUser' => null, 'fkPrefProfile' => null));

        $form = $this->profileForm;
        /* @var $serviceMultiCheckbox MultiCheckbox */
        $serviceMultiCheckbox = $form->get('services');
        $result = array();
//        var_dump($serviceMultiCheckbox->get);
        foreach ($serviceMultiCheckbox->getValueOptions() as $value) {
            $value['attributes'] = array('data-toggle' => 'buttons-checkbox', 'data-target' => '#serviceIdModal' . $value['value']);
            $result[] = $value;
        }
//        $serviceMultiCheckbox->setValueOptions($result);

        if ($this->request->isPost()) {
            $serviceGetPost = $this->request->getPost();
//            $serviceGetPost['services'];
//            var_dump($serviceGetPost['services']);
            // Filtre du array Attribute pour enlever les valeurs vides/null
//            $attributeFilterPost = array_filter($serviceGetPost['serviceAttributes']);
            /* @var $entPlugin EntPlugin */
            $entPlugin = $this->EntPlugin();
//            $attributeFilterPost = $entPlugin->array_filter_recursive($serviceGetPost['serviceAttributes']);
//            $attributeFilterPost = array_intersect_key($attributeFilterPost, array_flip($serviceGetPost['services']));
//
//            if (isset($attributeFilterPost) && !empty($attributeFilterPost)) {
//                foreach ($attributeFilterPost as $key => $value) {
//                    /* @var $service EntService */
//                    $service = $this->serviceService->getById($key);
//
//                    $prefAttribute[$service->getServiceName()]['serviceData'] = Json::decode($this->serializer->serialize($service, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_ARRAY);
//
//                    // Récupère les key qui sont en fait les attributeId
//                    $attributeKeyFilterPost = array_keys($value);
//
//                    // Prepare les attribute pour les insérer dans EntPreferences
//                    /* @var $entPlugin EntPlugin */
//                    $prefAttribute[$service->getServiceName()]['serviceAttributeData'] = $entPlugin->preparePrefAttribute($value, $attributeKeyFilterPost, $this->attributeService, $this->serializer);
//                }
//            }
//            var_dump($prefAttribute);
            $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $serviceGetPost['services'], $this->serviceService, $this->attributeService, $this->serializer);
//var_dump($prefAttribute);
            $profile = $this->profileService->insert($form, $this->request->getPost());
            if ($profile) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {
                    $formPreference = $this->preferenceForm;
                    //Update la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefProfile' => $profile->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                    $this->preferenceService->save($formPreference, $dataPreference, $preference);
                }
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');

                return $this->redirect()->toRoute('profile');
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'services' => $services,
            'preferenceAttribute' => Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT),
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $profile = $this->profileService->getById($id);

        if (!$profile) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'profile' => $profile
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->profileForm;
        $profile = $this->profileService->getById($id, $form);

        if ($this->request->isPost()) {
            $profile = $this->profileService->save($form, $this->request->getPost(), $profile);

            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');

                return $this->redirect()->toRoute('profile');
            }
        }

        return new ViewModel(array(
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
