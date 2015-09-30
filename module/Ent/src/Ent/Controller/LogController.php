<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Service\GenericEntityServiceInterface;
use Ent\Entity\EntLog;
use Ent\Service\LogDoctrineService;

class LogController extends AbstractActionController
{

    /**
     *
     * @var LogDoctrineService
     */
    protected $service = null;

    public function __construct(GenericEntityServiceInterface $iservice)
    {
        $this->service = $iservice;
    }

    
    public function indexAction()
    {
        $result = $this->service->getAll();

        return new ViewModel(array(
            'logs' => $result
        ));
    }
    
    public function testAddAction()
    {
        /**
          * @var LogDoctrineService
          */
        $eoUser = $this->getUser();
        
        // Ent\Service\Module => $eoModule
        $serviceEo = $this->getServiceLocator()->get('Ent\Service\Module');
        $eoModule = $serviceEo->getById(2);
        
        // Ent\Service\Action => $eoAction
        $serviceEo = $this->getServiceLocator()->get('Ent\Service\Action');
        $eoAction = $serviceEo->getById(1);

        $anEntLog = new EntLog();
        $anEntLog->setFkLogAction($eoAction)
                ->setFkLogModule($eoModule)
                ->setFkLogUser($eoUser)
                ->setLogDatetime(new \DateTime())
                ->setLogOnline(new \DateTime())
                ->setLogIp("192.88.99.00")
                ->setLogLogin("sebbar")
                ->setLogSession("sesion_4578000987")
                ->setLogUseragent("Agent Firefox");
        
        $this->service->insertEnterpriseObject($anEntLog);
        
        return $this->redirect()->toRoute('log');
    }      
    
    /**
     * 
     * @return type EntUser
     */
    public function getUser()
    {
               
        $eoUser = NULL;
        
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $userLogin = $authService->getIdentity()->getUserLogin();
            
            /**
             * @var LogDoctrineService
             */
//            $serviceEo = $this->getServiceLocator()->get('Ent\Service\UserDoctrineORM');
//            $eoUser = $serviceEo->getByLogin($userLogin);

            $eoUser = $this->service->getUserByLogin($userLogin);
        }
        
        return $eoUser;
    }
}

