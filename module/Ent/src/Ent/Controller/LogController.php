<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ent\Service\GenericEntityServiceInterface;
use Ent\Entity\EntLog;

class LogController extends AbstractActionController
{

    protected $service = null;

    public function __construct(GenericEntityServiceInterface $iservice)
    {
        $this->service = $iservice;
    }

    public function testAction()
    {
        
        // UserDoctrineService => $eoUser
        $serviceEo = $this->getServiceLocator()->get('Ent\Service\UserDoctrineORM');
        $eoUser = $serviceEo->getById(1);
        
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
        
        return new ViewModel(array(
            'log' => $anEntLog
        ));
    }

}

