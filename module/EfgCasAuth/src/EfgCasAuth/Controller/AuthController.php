<?php

namespace EfgCasAuth\Controller;

use phpCAS;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

class AuthController extends AbstractActionController
{
    /**
     *
     * @var AuthenticationServiceInterface
     */
    protected $authService;
    
    protected $config;
   
    public function __construct(AuthenticationServiceInterface $authService, $config)
    {
        $this->authService = $authService;
        $this->config = $config;
    }

    public function loginAction()
    {
        //if already login, redirect to index page 
        if ($this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        return $this->authenticate();
    }

    public function authenticate()
    {
        if ($this->authService->hasIdentity()) {
            // if already login, redirect to index page 
            return $this->redirect()->toRoute('home');
        }

        $config = $this->config;
        // Enable debugging      
        phpCAS::setDebug();

        // Initialize phpCAS
        phpCAS::client($config['cas']['cas_version'], $config['cas']['server_hostname'], $config['cas']['server_port'], $config['cas']['server_path'], false);


        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);
        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        //\phpCAS::setFixedServiceURL(trim("http://" . 'servauth.univ-paris5.fr', "/"));
        //\phpCAS::setCacheTimesForAuthRecheck(1);
        phpCAS::setNoCasServerValidation();

        //  \phpCAS::setNoClearTicketsFromUrl();
        //  \phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,3); 
        // \phpCAS::setExtraCurlOption(CURLOPT_VERBOSE, TRUE);

        if (phpCAS::isAuthenticated()) {
//            $dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
//
//            $authAdapter = new DbTable($dbAdapter, 'user', 'username', 'password');
//            
//            $authAdapter = $this->authService->getAdapter();
//            
//            //setCredential doit recevoir le MDP 
//            //mais vu qu'on utilise CAS le mdp est VIDE !!!!
//            $authAdapter->setIdentity(\phpCAS::getUser())
//                    ->setCredential('');
//            
//            $authService = $this->serviceLocator->get('auth_service');
//            $authService->setAdapter($authAdapter);
//            //test si la personne est bien dans la BD
//            $result = $authService->authenticate();
            
            
//            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
//            $authService = $this->authService;
            $adapter = $this->authService->getAdapter();
            $adapter->setIdentityValue(phpCAS::getUser());
            $adapter->setCredentialValue('');
            $authResult = $this->authService->authenticate();

            if ($authResult->isValid()) {
//                // set id comme identifiant de session
//                $user_id = $authAdapter->getResultRowObject('user_id')->user_id;
//                $username = $authAdapter->getResultRowObject('username')->username;
//                //$authService->getStorage()->write($user_id);  
//                $roleUser = $this->serviceLocator->get('Application\Provider\Identity\casZendDb');
//                $authService->getStorage()->write(array(
//                    'user_id' => $user_id,
//                    'username' => $username,
//                ));
//                $roleUser = $roleUser->getIdentityRoles();
//                $authService->getStorage()->write(array(
//                    'user_id' => $user_id,
//                    'username' => $username,
//                    'role' => $roleUser[0],
//                ));
                $identity = $authResult->getIdentity();
                $this->authService->getStorage()->write($identity);
            } else {
                $loginMsg = $authResult->getMessages();
            }
            // Retour vers l'index
            return $this->redirect()->toRoute('home');
        } else {
            // hey, authenticate
            phpCAS::forceAuthentication();
            die();
        }
        return $this->redirect()->toRoute('home');
    }

    public function logoutAction()
    {
//        $authService = $this->serviceLocator->get('auth_service');
        // if not login, redirect to index page 
//        if (!$authService->hasIdentity()) {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $this->authService->clearIdentity();

        $config = $this->getServiceLocator()->get('Config');

        // Enable debugging       
        phpCAS::setDebug();

        // Initialize phpCAS
        phpCAS::client($config['cas']['cas_version'], $config['cas']['server_hostname'], $config['cas']['server_port'], $config['cas']['server_path'], false);
        phpCAS::setNoCasServerValidation();

        //$service = $this->url()->fromRoute('application',array(),array('force_canonical' => true));
        $url = $this->url()->fromRoute('home', array(), array('force_canonical' => true));

        //\phpCAS::logoutWithRedirectService($service);
        phpCAS::logoutWithUrl($url);
        //\phpCAS::logoutWithRedirectServiceAndUrl($service, $url);
        //\phpCAS::logout();

        return $this->redirect()->toRoute('home');
    }

}
