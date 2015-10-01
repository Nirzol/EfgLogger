<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Ent\Entity\EntUser;
use Ent\Entity\EntLog;
use Ent\Service\LogDoctrineService;

/**
 * Description of indexRestController
 *
 * @author fandria
 */

class IndexRestController extends AbstractRestfulController {
       
    public function getList()
    {
        $is_logged = false;
        
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            $is_logged = true;
            
            // si l'utilisateur n'a pas ete logge, le logger dans la base
            if ( !$this->isUserLoggedIn()) {
                $userLogin = $authService->getIdentity()->getUserLogin();            
                $this->logInUser($userLogin);
            }
            
        } else {
            $is_logged = false;
        }
        
        return new JsonModel(array(
            'is_logged' => $is_logged
        ));
    }
    
    /**
     *  Ajoute une entree login (logOnline, logDatetime) dans la table Log
     * @param type String $userLogin
     */
    public function logInUser($userLogin) {
            
            try {
                /**
                 * @var EntUser
                 */
                $eoUser = $this->getUser($userLogin);

                /**
                 * @var EntLog
                 */
                $anEntLog = new EntLog();
                $anEntLog->setFkLogUser($eoUser)
                        ->setLogOnline(new \DateTime())
                        ->setLogDatetime(new \DateTime())
                        ->setLogLogin($eoUser->getUserLogin())
                        ->setLogIp($this->getUserIp())
                        ->setLogSession($this->getSessionId())
                        ->setLogUseragent($this->getHttpUserAgent());

                /**
                 * @var LogDoctrineService
                 */
                $serviceEo = $this->getServiceLocator()->get('Ent\Service\Log');
                $serviceEo->insertEnterpriseObject($anEntLog);
                
                $_SESSION["is_logged"] = true;

            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        
    }
    
    /**
     *  Ajoute une entree LOGOUT (logOffline, logDatetime) dans la table Log
     * @param type String $userLogin
     */
    public function logOutUser($userLogin) {
            
            try {
                /**
                 * @var EntUser
                 */
                $eoUser = $this->getUser($userLogin);

                /**
                 * @var EntLog
                 */
                $anEntLog = new EntLog();
                $anEntLog->setFkLogUser($eoUser)
                        ->setLogOffline(new \DateTime())
                        ->setLogDatetime(new \DateTime())
                        ->setLogLogin($eoUser->getUserLogin())
                        ->setLogIp($this->getUserIp())
                        ->setLogSession($this->getSessionId())
                        ->setLogUseragent($this->getHttpUserAgent());

                /**
                 * @var LogDoctrineService
                 */
                $serviceEo = $this->getServiceLocator()->get('Ent\Service\Log');
                $serviceEo->insertEnterpriseObject($anEntLog);
                
                $_SESSION["is_logged"] = true;

            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        
    }
    
    /**
     * Verifie si l'utilisateur a deja ete logge ($_SESSION["is_logged"] existe)
     * 
     * @param type $param
     * @return type
     */
    public function isUserLoggedIn() {
        
        $idSession = $this->getSessionId();
        return ( (isset($idSession) && ($idSession != '') && isset($_SESSION["is_logged"]) && ($_SESSION["is_logged"] === true)));
    }
    /**
     *  Return current user
     * @return type EntUser
     */
    public function getUser($userLogin)
    {
        /**
         * @var EntUser
         */
        $eoUser = NULL;
        
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
        
        return $eoUser;
    }
    
    public function getSessionId() {
        
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
