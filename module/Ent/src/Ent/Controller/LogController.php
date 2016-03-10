<?php

namespace Ent\Controller;

use Ent\Form\LogForm;
use Ent\Service\LogDoctrineService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LogController extends AbstractActionController
{

    /**
     *
     * @var LogDoctrineService
     */
    protected $logService = null;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var LogForm
     */
    protected $logForm;

    public function __construct(LogDoctrineService $logService, LogForm $logForm)
    {
        $this->logService = $logService;
        $this->logForm = $logForm;
    }

    public function listAction()
    {
        if (!$this->isGranted('list_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $listLogs = $this->logService->getAll();

        return new ViewModel(array(
            'listLogs' => $listLogs,
        ));
    }

    public function addAction()
    {
        if (!$this->isGranted('add_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $form = $this->logForm;

        if ($this->request->isPost()) {
            $log = $this->logService->insert($form, $this->request->getPost());

            if ($log) {
                $this->flashMessenger()->addSuccessMessage('Le log a bien été ajouté.');

                return $this->redirect()->toRoute('zfcadmin/log');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function showAction()
    {
        if (!$this->isGranted('show_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $log = $this->logService->getById($id);

        if (!$log) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'log' => $log,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->logForm;
        $log = $this->logService->getById($id, $form);

        if ($this->request->isPost()) {
            $log = $this->logService->save($form, $this->request->getPost(), $log);

            if ($log) {
                $this->flashMessenger()->addSuccessMessage('Le log a bien été modifié.');

                return $this->redirect()->toRoute('zfcadmin/log');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_log')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $this->logService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le log a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/log');
    }

//    public function add2Action() {
//        
//        try {
//            
//            /**
//              * @var EntUser
//              */
//            $eoUser = $this->getUser();
//
//            $anEntLog = new EntLog();
//            $anEntLog->setFkLogUser($eoUser)
//                    ->setLogDatetime(new \DateTime())
//                    ->setLogOnline(new \DateTime())
//                    ->setLogIp($this->getUserIp())
//                    ->setLogLogin($eoUser->getUserLogin())
//                    ->setLogSession($this->getSession())
//                    ->setLogUseragent($this->getHttpUserAgent());
//
//            $this->service->insertEnterpriseObject($anEntLog);
//
//
//        } catch (Exception $exc) {
////            echo $exc->getTraceAsString();
//        }
//        
//        return $this->redirect()->toRoute('log');
//    }
//    public function testAddEo()
//    {
//        /**
//          * @var EntUser
//          */
//        $eoUser = $this->getUser();
//        
//        // Ent\Service\Module => $eoModule
//        $serviceEo = $this->getServiceLocator()->get('Ent\Service\Module');
//        $eoModule = $serviceEo->getById(2);
//        
//        // Ent\Service\Action => $eoAction
//        $serviceEo = $this->getServiceLocator()->get('Ent\Service\Action');
//        $eoAction = $serviceEo->getById(1);
//
//        $anEntLog = new EntLog();
//        $anEntLog->setFkLogAction($eoAction)
//                ->setFkLogModule($eoModule)
//                ->setFkLogUser($eoUser)
//                ->setLogDatetime(new \DateTime())
//                ->setLogOnline(new \DateTime())
//                ->setLogIp("192.88.99.00")
//                ->setLogLogin("sebbar")
//                ->setLogSession("sesion_4578000987")
//                ->setLogUseragent("Agent Firefox");
//        
//        $this->service->insertEnterpriseObject($anEntLog);
//        
//        return $this->redirect()->toRoute('log');
//    }      
//    /**
//     *  Return current user
//     * @return type EntUser
//     */
//    public function getUser()
//    {
//        /**
//         * @var EntUser
//         */
//        $eoUser = NULL;
//        
//        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
//        if ($authService->hasIdentity()) {
//            $userLogin = $authService->getIdentity()->getUserLogin();
//            
//            /**
//             * @var UserDoctrineService
//             */
//            $userService = $this->getServiceLocator()->get('Ent\Service\UserDoctrineORM');
//            $eoUser = $userService->findBy(array('userLogin' => $userLogin));
//            if ( $eoUser && is_array($eoUser)) {
//                $eoUser = $eoUser[0];
//            } else {
//                $eoUser = NULL;
//            }
//        }
//        
//        return $eoUser;
//    }
//    public function getSession() {
//        
//        $idSession = session_id();
//        if( !(isset($idSession) && ($idSession != '')) ) {
//            session_start();
//            $idSession = session_id();
//        }
//        
//       return $idSession;
//    }
//    
//    public function getHttpUserAgent() {
//        return $_SERVER["HTTP_USER_AGENT"];
//    }
//    
//    public function getUserIp() {
//        return $_SERVER["REMOTE_ADDR"];
//    }
}
