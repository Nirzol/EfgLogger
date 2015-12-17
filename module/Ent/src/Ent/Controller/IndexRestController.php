<?php

namespace Ent\Controller;

use Ent\Controller\Plugin\EntPlugin;
use Ent\Entity\EntAction;
use Ent\Entity\EntUser;
use Ent\Form\LogForm;
use Ent\Service\ActionDoctrineService;
use Ent\Service\LogDoctrineService;
use Ent\Service\UserDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;

/**
 * Description of indexRestController
 *
 * @author fandria
 */
class IndexRestController extends AbstractRestfulController
{

    /**
     *
     * @var LogDoctrineService
     */
    protected $logService;

    /**
     *
     * @var LogForm
     */
    protected $logForm;

    /**
     *
     * @var UserDoctrineService
     */
    protected $userService;

    /**
     *
     * @var ActionDoctrineService
     */
    protected $actionService;

    public function __construct(LogDoctrineService $logService, LogForm $logForm, UserDoctrineService $userService, ActionDoctrineService $actionService)
    {
        $this->logService = $logService;
        $this->logForm = $logForm;
        $this->userService = $userService;
        $this->actionService = $actionService;
    }

    public function getList()
    {
        $is_logged = false;

        $data = null;
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $is_logged = true;
            $data['isLogged'] = true;

            // si l'utilisateur n'a pas ete logge, le logger dans la base
            $container = new Container('entLogger');

            if (!isset($container->is_logged) || !$container->is_logged) {
                $container->is_logged = true;

                $userLogin = $authService->getIdentity()->getUserLogin();

                /* @var $entPlugin EntPlugin */
                $entPlugin = $this->EntPlugin();
//                $entPlugin->doSomething();

                /* @var $user EntUser */
                $user = $this->userService->findOneBy(array('userLogin' => $userLogin));
                /* @var $action EntAction */
                $action = $this->actionService->findOneBy(array('actionName' => 'connection'));

//            $moduleID = $this->moduleService->findOneBy(array('moduleName' => $module));

                $dataAssoc = $entPlugin->prepareLogData($user, true, $action->getActionId());

                $this->logService->insert($this->logForm, $dataAssoc);
            }
            $data['passPhrase'] = 'ngent';
        } else {
            $is_logged = false;
            $data['isLogged'] = false;
        }
        
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));

//        return new JsonModel(array(
//            'is_logged' => $is_logged
//        ));
    }

//    /**
//     *  Ajoute une entree login (logOnline, logDatetime) dans la table Log
//     * @param type String $userLogin
//     */
//    public function logInUser($userLogin)
//    {
//
//        try {
//            /**
//             * @var EntUser
//             */
//            $eoUser = $this->getUser($userLogin);
//
//            /**
//             * @var EntLog
//             */
//            $anEntLog = new EntLog();
//            $anEntLog->setFkLogUser($eoUser)
//                    ->setLogOnline(new \DateTime())
//                    ->setLogDatetime(new \DateTime())
//                    ->setLogLogin($eoUser->getUserLogin())
//                    ->setLogIp($this->getUserIp())
//                    ->setLogSession($this->getSessionId())
//                    ->setLogUseragent($this->getHttpUserAgent());
//
//            /**
//             * @var LogDoctrineService
//             */
//            $serviceEo = $this->getServiceLocator()->get('Ent\Service\Log');
//            $serviceEo->insertEnterpriseObject($anEntLog);
//        } catch (Exception $exc) {
////                echo $exc->getTraceAsString();
//        }
//    }
//    /**
//     *  Ajoute une entree LOGOUT (logOffline, logDatetime) dans la table Log
//     * @param type String $userLogin
//     */
//    public function logOutUser($userLogin)
//    {
//
//        try {
//            /**
//             * @var EntUser
//             */
//            $eoUser = $this->getUser($userLogin);
//
//            /**
//             * @var EntLog
//             */
//            $anEntLog = new EntLog();
//            $anEntLog->setFkLogUser($eoUser)
//                    ->setLogOffline(new \DateTime())
//                    ->setLogDatetime(new \DateTime())
//                    ->setLogLogin($eoUser->getUserLogin())
//                    ->setLogIp($this->getUserIp())
//                    ->setLogSession($this->getSessionId())
//                    ->setLogUseragent($this->getHttpUserAgent());
//
//            /**
//             * @var LogDoctrineService
//             */
//            $serviceEo = $this->getServiceLocator()->get('Ent\Service\Log');
//            $serviceEo->insertEnterpriseObject($anEntLog);
//        } catch (Exception $exc) {
////                echo $exc->getTraceAsString();
//        }
//    }
//    /**
//     * Verifie si l'utilisateur a deja ete logge ($_SESSION["is_logged"] existe)
//     * 
//     * @param type $param
//     * @return type
//     */
//    public function isUserLoggedIn()
//    {
//
//        $idSession = $this->getSessionId();
//        return ( (isset($idSession) && ($idSession != '') && isset($_SESSION["is_logged"]) && ($_SESSION["is_logged"] === true)));
//    }
//    /**
//     *  Return current user
//     * @return type EntUser
//     */
//    public function getUser($userLogin)
//    {
//        /**
//         * @var EntUser
//         */
//        $eoUser = NULL;
//
//        /**
//         * @var UserDoctrineService
//         */
//        $userService = $this->getServiceLocator()->get('Ent\Service\UserDoctrineORM');
//        $eoUser = $userService->findBy(array('userLogin' => $userLogin));
//        if ($eoUser && is_array($eoUser)) {
//            $eoUser = $eoUser[0];
//        } else {
//            $eoUser = NULL;
//        }
//
//        return $eoUser;
//    }
//    public function getSessionId()
//    {
//
//        $idSession = session_id();
//        if (!(isset($idSession) && ($idSession != ''))) {
//            session_start();
//            $idSession = session_id();
//        }
//
//        return $idSession;
//    }
//
//    public function getHttpUserAgent()
//    {
//        return $_SERVER["HTTP_USER_AGENT"];
//    }
//
//    public function getUserIp()
//    {
//        return $_SERVER["REMOTE_ADDR"];
//    }
}
