<?php

namespace Ent\Controller;

use Doctrine\Common\Collections\Criteria;
use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntPreference;
use Ent\Entity\EntService;
use Ent\Form\PreferenceForm;
use Ent\Form\ServiceForm;
use Ent\Service\AttributeDoctrineService;
use Ent\Service\PreferenceDoctrineService;
use Ent\Service\ServiceDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;

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
    protected $serializer = null;
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
        if (!$this->isGranted('list_service')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $services = $this->serviceService->getAll();

        return new ViewModel(array(
            'services' => $services,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_service')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $attributes = $this->attributeService->getAll();

        $form = $this->serviceForm;

        if ($this->request->isPost()) {
            $serviceGetPost = $this->request->getPost();

            /* @var $entPlugin EntPlugin */
            $entPlugin = $this->EntPlugin();

            $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], null, $this->serviceService, $this->attributeService, $this->serializer);

            // Insert le service
            /* @var $service EntService */
            $service = $this->serviceService->insert($form, $serviceGetPost);

            if ($service) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {

                    $prefAttribute[0]['serviceData'] = Json::decode($this->serializer->serialize($service, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_ARRAY);

                    $prefAttribute[$service->getServiceName()] = $prefAttribute[0];
                    unset($prefAttribute[0]);

                    $formPreference = $this->preferenceForm;
                    //Insert la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefService' => $service->getServiceId(), 'fkPrefStatus' => $this->config['default_status']);
                    $prefService = $this->preferenceService->insert($formPreference, $dataPreference);
                }
                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');

                return $this->redirect()->toRoute('zfcadmin/service');
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_service')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $service = $this->serviceService->getById($id);

        /* @var $preference EntPreference */
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => $id, 'fkPrefUser' => null, 'fkPrefProfile' => null));

        if (!$service) {
            return $this->notFoundAction();
        }

        $preferenceAttribute = '';
        if ($preference) {
            $preferenceAttribute = Json::decode($preference->getPrefAttribute(), Json::TYPE_OBJECT);
            //            var_dump($preferenceAttribute);
        }
        return new ViewModel(array(
            'service' => $service,
            'preferenceAttribute' => $preferenceAttribute,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_service')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->serviceForm;
        $service = $this->serviceService->getById($id, $form);
        $attributes = $this->attributeService->getAll();
        $preference = $this->preferenceService->findOneBy(array('fkPrefService' => $id, 'fkPrefUser' => null, 'fkPrefProfile' => null));

        if ($this->request->isPost()) {

            $serviceGetPost = $this->request->getPost();
            
            // Update le service
            /* @var $service EntService */
            $service = $this->serviceService->save($form, $serviceGetPost, $service);

            /* @var $entPlugin EntPlugin */
            $entPlugin = $this->EntPlugin();

            $prefAttribute = $entPlugin->preparePrefAttributePerService($serviceGetPost['serviceAttributes'], $service, $this->serviceService, $this->attributeService, $this->serializer);
            //            var_dump($prefAttribute);
            //            // Filtre du array Attribute pour enlever les valeurs vides/null
            //            $attributeFilterPost = array_filter($serviceGetPost['serviceAttributes']);
            //            if (isset($attributeFilterPost) && !empty($attributeFilterPost)) {
            //                // Récupère les key qui sont en fait les attributeId
            //                $attributeKeyFilterPost = array_keys($attributeFilterPost);
            //
        //                // Assigne fkSaAttribute pour pouvoir insérer le service et les attributs qui lui sont liés
            //                $serviceGetPost['fkSaAttribute'] = $attributeKeyFilterPost;
            //
        //                // Prepare les attribute pour les updater dans EntPreferences
            //                /* @var $entPlugin EntPlugin */
            //                $entPlugin = $this->EntPlugin();
            //                $prefAttribute = $entPlugin->preparePrefAttribute($attributeFilterPost, $attributeKeyFilterPost, $this->attributeService, $this->serializer);
            //            }
            if ($service) {
                if (isset($prefAttribute) && !empty($prefAttribute)) {
                    $formPreference = $this->preferenceForm;
                    //Update la prefrence du service
                    $dataPreference = array('prefAttribute' => Json::encode($prefAttribute), 'fkPrefService' => $service->getServiceId(), 'fkPrefStatus' => $this->config['default_status']);
                    $this->preferenceService->save($formPreference, $dataPreference, $preference);
                }
                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.');

                return $this->redirect()->toRoute('zfcadmin/service');
            }
        }

        return new ViewModel(array(
            'attributes' => $attributes,
            'service' => $service,
            'preference' => $preference,
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_service')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        
        $this->deleteIntoProfile($id);

        $this->serviceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/service');
    }

    public function updateProfileAction()
    {
        if (!$this->isGranted('update_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        // Get Service attribute from Preference
        /* @var $prefService EntPreference */
        $prefService = $this->preferenceService->findOneBy(array('fkPrefService' => $id));
        $prefServiceAttribute = Json::decode($prefService->getPrefAttribute(), Json::TYPE_ARRAY);

        // Update one attribute. Filter on $prefServiceAttribute
        if ($this->params('ida')) {
            $ida = $this->params('ida');
            foreach ($prefServiceAttribute as $keyServiceAttribute => $serviceAttribute) {
                foreach ($serviceAttribute['serviceAttributeData'] as $keyAttributeData => $attributeData) {
                    if ((int) $ida !== (int) $attributeData['attributeId']) {
                        unset($prefServiceAttribute[$keyServiceAttribute]['serviceAttributeData'][$keyAttributeData]);
                    }
                }
            }
        }

        // Get All Profile Preference
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->neq('fkPrefProfile', NULL));
        $criteria->andWhere($criteria->expr()->isNull('fkPrefUser'));
        $criteria->andWhere($criteria->expr()->isNull('fkPrefService'));
        $prefProfiles = $this->preferenceService->matching($criteria);

        // Merge ProfilAttribute and ServiceAttribute with priority for ServiceAttribute 
        /* @var $prefProfile EntPreference */
        foreach ($prefProfiles as $prefProfile) {
            $prefProfileAttribute = Json::decode($prefProfile->getPrefAttribute(), Json::TYPE_ARRAY);
            $tmp = array_replace_recursive($prefProfileAttribute, $prefServiceAttribute);
            if ($tmp != $prefProfileAttribute) {
                $dataPreference = array('prefAttribute' => Json::encode($tmp), 'fkPrefProfile' => $prefProfile->getFkPrefProfile()->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
                $this->preferenceService->save($this->preferenceForm, $dataPreference, $prefProfile);
            }
        }

        $this->flashMessenger()->addSuccessMessage('Le profil a bien été mis à jour.');

        return $this->redirect()->toRoute('zfcadmin/service');

        //        return new ViewModel(array(
        //        ));
    }

    public function deleteProfileAction()
    {
        if (!$this->isGranted('delete_profile')) {
            throw new UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        
        $this->deleteIntoProfile($id);

//        // Get Service        
//        /* @var $service EntService */
//        $service = $this->serviceService->getById($id);
//
//        // Get All Profile Preference
//        $criteria = new Criteria();
//        $criteria->where($criteria->expr()->neq('fkPrefProfile', NULL));
//        $criteria->andWhere($criteria->expr()->isNull('fkPrefUser'));
//        $criteria->andWhere($criteria->expr()->isNull('fkPrefService'));
//        $prefProfiles = $this->preferenceService->matching($criteria);
//
//        // Delete service into profileAttribute 
//        /* @var $prefProfile EntPreference */
//        foreach ($prefProfiles as $prefProfile) {
//            $prefProfileAttribute = Json::decode($prefProfile->getPrefAttribute(), Json::TYPE_ARRAY);
//            unset($prefProfileAttribute[$service->getServiceName()]);
//            $dataPreference = array('prefAttribute' => Json::encode($prefProfileAttribute), 'fkPrefProfile' => $prefProfile->getFkPrefProfile()->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
//            $this->preferenceService->save($this->preferenceForm, $dataPreference, $prefProfile);
//        }

        $this->flashMessenger()->addSuccessMessage('Le profil a bien été mis à jour.');

        return $this->redirect()->toRoute('zfcadmin/service');
//                return new ViewModel(array(
//                ));
    }
    
    private function deleteIntoProfile($idService){
        // Get Service        
        /* @var $service EntService */
        $service = $this->serviceService->getById($idService);

        // Get All Profile Preference
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->neq('fkPrefProfile', NULL));
        $criteria->andWhere($criteria->expr()->isNull('fkPrefUser'));
        $criteria->andWhere($criteria->expr()->isNull('fkPrefService'));
        $prefProfiles = $this->preferenceService->matching($criteria);

        // Delete service into profileAttribute 
        /* @var $prefProfile EntPreference */
        foreach ($prefProfiles as $prefProfile) {
            $prefProfileAttribute = Json::decode($prefProfile->getPrefAttribute(), Json::TYPE_ARRAY);
            unset($prefProfileAttribute[$service->getServiceName()]);
            $dataPreference = array('prefAttribute' => Json::encode($prefProfileAttribute), 'fkPrefProfile' => $prefProfile->getFkPrefProfile()->getProfileId(), 'fkPrefStatus' => $this->config['default_status']);
            $this->preferenceService->save($this->preferenceForm, $dataPreference, $prefProfile);
        }
    }

}
