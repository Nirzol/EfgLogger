<?php

namespace EfgCasAuth\Controller;

use phpCAS;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{

    /**
     * @var AuthenticationServiceInterface
     */
    protected $authService = null;
    protected $configCas = null;
    protected $cas_inited = null;

    public function __construct(AuthenticationServiceInterface $authService, $configCas)
    {
        $this->authService = $authService;
        $this->configCas = $configCas;
        $this->cas_inited = false;
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
        if ($configCas['cas_debug']) {
            phpCAS::setDebug($configCas['cas_debug_file']);
        }

        // Initialize phpCAS
        //        if ($configCas['cas_proxy']) {
        //            // Manage the session only the first time
        //            phpCAS::proxy($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], false);
        //            // set URL for PGT callback
        ////            phpCAS::setFixedCallbackURL($this->generate_url(array('action' => 'pgtcallback')));
        ////
        ////            // set PGT storage
        ////            phpCAS::setPGTStorageFile($cfg['cas_pgt_dir']);
        //        }
        //        else {
        // Manage the session only the first time
        phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], false);
        //        }
        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        //        var_dump($configCas['cas_server_ca_cert_path']);
        phpCAS::setCasServerCACert($configCas['cas_server_ca_cert_path']);
        // 
        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        //\phpCAS::setFixedServiceURL(trim("http://" . 'servauth.univ-paris5.fr', "/"));
        //\phpCAS::setCacheTimesForAuthRecheck(1);
        //        phpCAS::setNoCasServerValidation();
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
                //                $identity = $authResult->getIdentity();
                $this->authService->getStorage()->write($authResult->getIdentity());
            } else {
                $container = new Container('noAuth');
                $container->login = $authResult->getIdentity();
                $container->loginMessage = $authResult->getMessages();
                return $this->redirect()->toRoute($configCas['no_account_route']);
            }
            // Retour vers l'index
            return $this->redirect()->toRoute($configCas['cas_redirect_route_after_login']);
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
        phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], false);
        phpCAS::setCasServerCACert($configCas['cas_server_ca_cert_path']);
        //        phpCAS::setNoCasServerValidation();

        $url = $this->url()->fromRoute('home', array(), array('force_canonical' => true));

        phpCAS::logout(array('url' => $url, 'service' => $url));

        return $this->redirect()->toRoute('home');
    }

    public function getPublicTicket()
    {
        // initialize CAS client
        $this->cas_init();

        // Look for _url GET variable and update FixedServiceURL if present to enable deep linking.
        //        $query = array();
        //        if ($url = get_input_value('_url', RCUBE_INPUT_GET)) {
        //            phpCAS::setFixedServiceURL($this->generate_url(array('action' => 'caslogin', '_url' => $url)));
        //            parse_str($url, $query);
        //        }
        $configCas = $this->configCas;
        var_dump($configCas);
        // Force the user to log in to CAS, using a redirect if necessary.
        phpCAS::forceAuthentication();

        // If control reaches this point, user is authenticated to CAS.
        $user = phpCAS::getUser();
        $pass = '';
        // retrieve credentials, either a Proxy Ticket or 'masteruser' password
        $configCas = $this->configCas;
        if ($configCas['cas_proxy']) {
            var_dump(phpCAS::retrievePT($configCas['cas_imap_name'], $err_code, $output));
            $_SESSION['cas_pt'][php_uname('n')] = phpCAS::retrievePT($configCas['cas_imap_name'], $err_code, $output);
            $pass = $_SESSION['cas_pt'][php_uname('n')];
        } else {
            $pass = $configCas['cas_imap_password'];
        }

        //        // Do Roundcube login actions
        //        $RCMAIL = rcmail::get_instance();
        //        $RCMAIL->login($user, $pass, $RCMAIL->autoselect_host());
        //        $RCMAIL->session->remove('temp');
        //        // We don't change the session id which is the CAS login ST.
        //        $RCMAIL->session->set_auth_cookie();
        //
        //        // log successful login
        //        rcmail_log_login();
        // allow plugins to control the redirect url after login success
        //        $redir = $RCMAIL->plugins->exec_hook('login_after', $query + array('_task' => 'mail'));
        //        unset($redir['abort'], $redir['_err']);
        // send redirect, otherwise control will reach the mail display and fail because the 
        // IMAP session was already started by $RCMAIL->login()
        //        global $OUTPUT;
        //        $OUTPUT->redirect($redir);
    }

    /**
     * Initialize CAS client
     */
    private function cas_init()
    {
        if (!$this->cas_inited) {
            $old_session = $_SESSION;

            if (!isset($_SESSION['session_inited'])) {
                // If the session isn't 'inited' by CAS 
                // We destroy the session to the CAS client be able to init it
                session_destroy();
            }
            $configCas = $this->configCas;

            // Uncomment the following line for phpCAS call tracing, helpful for debugging.
            if ($configCas['cas_debug']) {
                phpCAS::setDebug($configCas['cas_debug_file']);
            }
            // initialize CAS client
            if ($configCas['cas_proxy']) {
                // Manage the session only the first time
                phpCAS::proxy($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], !isset($_SESSION['session_inited']));
                // set URL for PGT callback
                //                $url = $this->url()->fromRoute('pgtcallback', array(), array('force_canonical' => true), true);
                $urlPgtCallback = 'https://ent-dev.univ-paris5.fr/api/pgtcallback';
                phpCAS::setFixedCallbackURL($urlPgtCallback);
                // set PGT storage
                phpCAS::setPGTStorageFile($configCas['cas_pgt_dir']);
            } else {
                // Manage the session only the first time
                phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], !isset($_SESSION['session_inited']));
            }
            // SLO callback
            phpCAS::setPostAuthenticateCallback("handleCasLogin", $old_session);
            //	    phpCAS::setSingleSignoutCallback(array($this, "handleSingleLogout"));
            // set service URL for authorization with CAS server
            $urlServiceUrl = 'https://ent-dev.univ-paris5.fr/api/proxylogin';
            phpCAS::setFixedServiceURL($urlServiceUrl);
            // set SSL validation for the CAS server
            if ($configCas['cas_validation'] == 'ca') {
                phpCAS::setCasServerCACert($configCas['cas_server_ca_cert_path']);
            } else {
                phpCAS::setNoCasServerValidation();
            }
            // set login and logout URLs of the CAS server
            phpCAS::setServerLoginURL($configCas['cas_login_url']);
            phpCAS::setServerLogoutURL($configCas['cas_logout_url']);
            if (!isset($_SESSION['session_inited'])) {
                // If the session isn't 'inited' by CAS
                // we keep the last session 
                $_SESSION = array_merge($_SESSION, $old_session);
                $_SESSION['session_inited'] = true;
            }
            $this->cas_inited = true;
        }
    }

    public function pgtcallbackAction()
    {
        // initialize CAS client
        $this->cas_init();
        // Handle SignleLogout
        phpCAS::handleLogoutRequests(false);

        // retrieve and store PGT if present
        phpCAS::forceAuthentication();

        // end script - once the PGT is stored we don't need to do anything else.
        exit;

        return new ViewModel();
    }

    public function proxyloginAction()
    {
        $this->getPublicTicket();
//        exit;
//        return new ViewModel();
    }

}
