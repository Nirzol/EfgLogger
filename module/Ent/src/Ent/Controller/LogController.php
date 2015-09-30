<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Service\GenericEntityServiceInterface;
use Ent\Entity\EntLog;
use Ent\Service\LogDoctrineService;
use Ent\Entity\EntUser;
use Ent\Service\UserDoctrineService;


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
    
    public function addAction() {
        
        try {
            
            /**
              * @var EntUser
              */
            $eoUser = $this->getUser();

            $anEntLog = new EntLog();
            $anEntLog->setFkLogUser($eoUser)
                    ->setLogDatetime(new \DateTime())
                    ->setLogOnline(new \DateTime())
                    ->setLogIp($this->getUserIp())
                    ->setLogLogin($eoUser->getUserLogin())
                    ->setLogSession($this->getSession())
                    ->setLogUseragent($this->getHttpUserAgent());

            $this->service->insertEnterpriseObject($anEntLog);


        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
        }
        
        return $this->redirect()->toRoute('log');
    }
    
    public function testAddEo()
    {
        /**
          * @var EntUser
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
     *  Return current user
     * @return type EntUser
     */
    public function getUser()
    {
        /**
         * @var EntUser
         */
        $eoUser = NULL;
        
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $userLogin = $authService->getIdentity()->getUserLogin();
            
            /**
             * @var UserDoctrineService
             */
            $userService = $this->getServiceLocator()->get('Ent\Service\UserDoctrineORM');
            $eoUser = $userService->findBy(array('userLogin' => $userLogin));
            if ( $eoUser && is_array($eoUser)) {
                $eoUser = $eoUser[0];
            } else {
                $eoUser = NULL;
            }
        }
        
        return $eoUser;
    }
    
    public function getSession() {
        
        $idSession = session_id();
        if( !(isset($idSession) && ($idSession != '')) ) {
            session_start();
            $idSession = session_id();
        }
        
       return $idSession;
    }
    
    public function getHttpUserAgent() {
        return $_SERVER["HTTP_USER_AGENT"];
    }
    
    public function getUserIp() {
        return $_SERVER["REMOTE_ADDR"];
    }
}

