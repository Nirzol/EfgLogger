<?php

namespace Ent\Controller;

use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntPreference;
use Ent\Entity\EntService;
use Ent\Form\PreferenceForm;
use Ent\Form\ServiceForm;
use Ent\Service\AttributeDoctrineService;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\Serializer;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ServiceController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return ServiceDoctrineService
     */
    protected $serviceService = null;

    /**
     * @return PreferenceDoctrineService
     */
    protected $preferenceService = null;

    /**
     * @var ServiceForm
     */
    protected $serviceForm = null;

    /**
     * @var PreferenceForm
     */
    protected $preferenceForm = null;

    /**
     * @return AttributeDoctrineService
     */
    protected $attributeService = null;

    /**
     * @var Serializer
     */
    protected $serializer;
    protected $config = null;

    public function __construct(ServiceDoctrineService $serviceService, PreferenceDoctrineService $preferenceService, ServiceForm $serviceForm, PreferenceForm $preferenceForm, AttributeDoctrineService $attributeService, Serializer $serializer, $config)
    {
        $this->serviceService = $serviceService;
        $this->preferenceService = $preferenceService;
        $this->serviceForm = $serviceForm;
        $this->preferenceForm = $preferenceForm;
        $this->attributeService = $attributeService;
        $this->config = $config;
        $this->serializer = $serializer;
    }

    public function listAction()
    {
        $services = $this->serviceService->getAll();

        return new ViewModel(array(
            'services' => $services,
        ));
    }

    public function addAction()
    {

        $attributes = $this->attributeService->getAll();

        $form = $this->serviceForm;

        if ($this->request->isPost()) {
            $serviceGetPost = $this->request->getPost();

            // Filtre du array Attribute pour enlever les valeurs vides/null
            $attributeFilterPost = array_filter($serviceGetPost['serviceAttributes']);
            if (isset($attributeFilterPost) && !empty($attributeFilterPost)) {
                // Récupère les key qui sont en fait les attributeId
                $attributeKeyFilterPost = array_keys($attributeFilterPost);

                // Assigne fkSaAttribute pour pouvoir insérer le service et les attributs qui lui sont liés
                $serviceGetPost['fkSaAttribute'] = $attributeKeyFilterPost;

                // Prepare les attribute pour les insérer dans EntPreferences
                /* @var $entPlugin EntPlugin */
                $entPlugin = $this->EntPlugin();
                $prefAttribute = $entPlugin->preparePrefAttribute($attributeFilterPost, $attributeKeyFilterPost, $this->attributeService, $this->serializer);
            }
            // Insert le service
            /* @var $service EntService */
            $service = $this->serviceService->insert($form, $serviceGetPost);

            if ($service) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {
                    $formPreference = $this->preferenceForm;
                    //Insert la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefService' => $service->getServiceId(), 'fkPrefStatus' => $this->config['default_status']);
                    $prefService = $this->preferenceService->insert($formPreference, $dataPreference);
                }
                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');

                return $this->redirect()->toRoute('service');
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        $id = $this->params('id');

        $service = $this->serviceService->getById($id);

        /* @var $preference EntPreference */
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => $id, 'fkPrefUser' => null, 'fkPrefProfile' => null));

        if (!$service) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'service' => $service,
            'preferenceAttribute' => Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT),
        ));
    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = $this->serviceForm;
        $service = $this->serviceService->getById($id, $form);
        $attributes = $this->attributeService->getAll();
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => $id, 'fkPrefUser' => null, 'fkPrefProfile' => null));

        if ($this->request->isPost()) {

            $serviceGetPost = $this->request->getPost();

            // Filtre du array Attribute pour enlever les valeurs vides/null
            $attributeFilterPost = array_filter($serviceGetPost['serviceAttributes']);
            if (isset($attributeFilterPost) && !empty($attributeFilterPost)) {
                // Récupère les key qui sont en fait les attributeId
                $attributeKeyFilterPost = array_keys($attributeFilterPost);

                // Assigne fkSaAttribute pour pouvoir insérer le service et les attributs qui lui sont liés
                $serviceGetPost['fkSaAttribute'] = $attributeKeyFilterPost;

                // Prepare les attribute pour les updater dans EntPreferences
                /* @var $entPlugin EntPlugin */
                $entPlugin = $this->EntPlugin();
                $prefAttribute = $entPlugin->preparePrefAttribute($attributeFilterPost, $attributeKeyFilterPost, $this->attributeService, $this->serializer);
            }
            // Update le service
            /* @var $service EntService */
//            $service = $this->serviceService->save($form, $serviceGetPost, $service);
//            if ($service) {
//                if (isset($prefAttribute) && !empty($prefAttribute)) {
//                    $formPreference = $this->preferenceForm;
//                    //Update la prefrence du service
//                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefService' => $service->getServiceId(), 'fkPrefStatus' => $this->config['default_status']);
//                    $this->preferenceService->save($formPreference, $dataPreference, $preference);
//                }
//                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.');
//
//                return $this->redirect()->toRoute('service');
//            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'preferenceAttribute' => Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT),
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');

        $this->serviceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');

        return $this->redirect()->toRoute('service');
    }

}
