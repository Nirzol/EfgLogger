<?php

namespace EfgCasAuth\Controller;

use phpCAS;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class AuthController extends AbstractActionController
{

    /**
     *
     * @var AuthenticationServiceInterface
     */
    protected $authService;
    protected $configCas;

    public function __construct(AuthenticationServiceInterface $authService, $configCas)
    {
        $this->authService = $authService;
        $this->configCas = $configCas;
    }

    public function loginAction()
    {
        //if already login, redirect to index page 
        if ($this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        return $this->authenticate();
    }

    private function authenticate()
    {
        if ($this->authService->hasIdentity()) {
            // if already login, redirect to index page 
            return $this->redirect()->toRoute('home');
        }

        $configCas = $this->configCas;
        // Enable debugging      
        phpCAS::setDebug();

        // Initialize phpCAS
        phpCAS::client($configCas['cas_version'], $configCas['server_hostname'], $configCas['server_port'], $configCas['server_path'], false);


        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);
        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        //\phpCAS::setFixedServiceURL(trim("http://" . 'servauth.univ-paris5.fr', "/"));
        //\phpCAS::setCacheTimesForAuthRecheck(1);
        phpCAS::setNoCasServerValidation();

        // set the language to french
//        phpCAS::setLang(PHPCAS_LANG_FRENCH);
        //  \phpCAS::setNoClearTicketsFromUrl();
        //  \phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,3); 
        // \phpCAS::setExtraCurlOption(CURLOPT_VERBOSE, TRUE);

        if (phpCAS::isAuthenticated()) {
            $adapter = $this->authService->getAdapter();

            // setCredential doit recevoir le MDP 
            // mais vu qu'on utilise CAS le mdp est VIDE !!!!
            $adapter->setIdentityValue(phpCAS::getUser());
            $adapter->setCredentialValue('');

            //test si la personne est bien dans la BD
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
                $container = new Container('noAuth');
                $container->login = $authResult->getIdentity();
                $container->loginMessage = $authResult->getMessages();
                return $this->redirect()->toRoute($configCas['no_account_route']);
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
        // if not login, redirect to home page 
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $this->authService->clearIdentity();

        $configCas = $this->configCas;

        // Enable debugging       
        phpCAS::setDebug();

        // Initialize phpCAS
        phpCAS::client($configCas['cas_version'], $configCas['server_hostname'], $configCas['server_port'], $configCas['server_path'], false);
        phpCAS::setNoCasServerValidation();

        $url = $this->url()->fromRoute('home', array(), array('force_canonical' => true));

        phpCAS::logout(array('url' => $url, 'service' => $url));

        return $this->redirect()->toRoute('home');
    }

}
