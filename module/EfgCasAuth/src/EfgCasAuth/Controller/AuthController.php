<?php

namespace EfgCasAuth\Controller;

use phpCAS;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class AuthController extends AbstractActionController
{

    /**
     * 
     * @var Request
     */
    protected $request = null;

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
        $configCas = $this->configCas;

//        $redirectUrl = $this->redirect()->toUrl($this->getCurrentUrl());
        // Enable debugging      
        if ($configCas['cas_debug']) {
            phpCAS::setDebug($configCas['cas_debug_file']);
        }

        // Initialize phpCAS
        phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], true);

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // set SSL validation for the CAS server
        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        if ($configCas['cas_validation'] == 'ca') {
            phpCAS::setCasServerCACert($configCas['cas_server_ca_cert_path']);
        } else {
            phpCAS::setNoCasServerValidation();
        }

        //\phpCAS::setFixedServiceURL(trim("http://" . 'servauth.univ-paris5.fr', "/"));
        //\phpCAS::setCacheTimesForAuthRecheck(1);
        // set the language to french
        //        phpCAS::setLang(PHPCAS_LANG_FRENCH);
        //  \phpCAS::setNoClearTicketsFromUrl();
        //  \phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,3); 
        // \phpCAS::setExtraCurlOption(CURLOPT_VERBOSE, TRUE);
        // Handle SignleLogout SLO
        phpCAS::handleLogoutRequests(false);

        // Check for logout request
        if (isset($_REQUEST['logout'])) {

            $this->authService->clearIdentity();

            $url = $this->url()->fromRoute('home', array(), array('force_canonical' => true));

            phpCAS::logout(array('url' => $url, 'service' => $url));
        }

        if (phpCAS::isAuthenticated()) {
            $adapter = $this->authService->getAdapter();

            // setCredential doit recevoir le MDP 
            // mais vu qu'on utilise CAS le mdp est VIDE !!!!
            $adapter->setIdentityValue(phpCAS::getUser());
            $adapter->setCredentialValue('');

            // Test si la personne est bien dans la BD
            $authResult = $this->authService->authenticate();

            if ($authResult->isValid()) {
                $this->authService->getStorage()->write($authResult->getIdentity());
                // Retour vers l'index
                
                $redirectTo = $this->redirect()->toRoute('home');
                if($this->request->getQuery('redirectTo') !== null){
                    $redirectTo = $this->redirect()->toUrl($this->request->getQuery('redirectTo'));
                }
                if ($configCas['cas_redirect_route_after_login'] && !empty($configCas['cas_redirect_route_after_login'])) {
                    $redirectTo = $this->redirect()->toRoute($configCas['cas_redirect_route_after_login']);
                }
            } else {
                $container = new Container('noAuth');
                $container->login = $authResult->getIdentity();
                $container->loginMessage = $authResult->getMessages();
                $redirectTo = $this->redirect()->toRoute($configCas['no_account_route']);
            }
        } else {
            // hey, authenticate
            phpCAS::forceAuthentication();
            die();
        }

        return $redirectTo;
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
        if ($configCas['cas_debug']) {
            phpCAS::setDebug($configCas['cas_debug_file']);
        }

        // Initialize phpCAS
        phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], true);
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

        //         Look for _url GET variable and update FixedServiceURL if present to enable deep linking.
        //                $query = array();
        //                if ($url = get_input_value('_url', RCUBE_INPUT_GET)) {
        //                    phpCAS::setFixedServiceURL($this->generate_url(array('action' => 'caslogin', '_url' => $url)));
        //                    parse_str($url, $query);
        //                }
        //                $query = array();  
        //                phpCAS::setFixedServiceURL('https://onepiece.dsi.univ-paris5.fr/api/');
        //                parse_str('https://onepiece.dsi.univ-paris5.fr/api/', $query);
        // Force the user to log in to CAS, using a redirect if necessary.
        phpCAS::forceAuthentication();

        // If control reaches this point, user is authenticated to CAS.
        $user = phpCAS::getUser();
        $pass = '';

        // retrieve credentials, either a Proxy Ticket or 'masteruser' password
        $configCas = $this->configCas;
        if ($configCas['cas_proxy']) {
            $urlPgtCallback = 'https://onepiece.dsi.univ-paris5.fr/api/pgtcallback';
            phpCAS::setFixedCallbackURL($urlPgtCallback);
            $urlServiceUrl = 'https://onepiece.dsi.univ-paris5.fr/api/';
            phpCAS::setFixedServiceURL($urlServiceUrl);
            $_SESSION['cas_pt'][php_uname('n')] = phpCAS::retrievePT($configCas['cas_imap_name'], $err_code, $output);
            $pass = $_SESSION['cas_pt'][php_uname('n')];
        } else {
            $pass = $configCas['cas_imap_password'];
        }

        //phpCAS::checkAuthentication();


        /**         * **** */
        //        $aaa = new \CAS_ProxiedService_Imap($user);
        //        $aaa->setServiceUrl('https://onepiece.dsi.univ-paris5.fr/api/');
        //        phpCAS::initializeProxiedService($aaa);
        /**         * **** */
        //        $myProxyImapService = phpCAS::getProxiedService(PHPCAS_PROXIED_SERVICE_IMAP);
        ////        var_dump($myProxyImapService);
        //        $myProxyImapService->setProxyTicket($pass);
        //       $myProxyImapService->setServiceUrl('https://onepiece.dsi.univ-paris5.fr/api/');
        //        var_dump($myProxyImapService);
        //        \CAS_ProxiedService_Imap::
        //        var_dump($myProxyImapService->getServiceUrl());
        //        CAS_ProxiedService_Imap
        //        phpCAS::initializeProxiedService($aaa);
        //        var_dump(phpCAS::retrievePT($configCas['cas_imap_name'], $err_code, $output));
//        var_dump(phpCAS::serviceMail('{imap-i.infr.univ-paris5.fr}INBOX', 'https://onepiece.dsi.univ-paris5.fr/api/', 0, $err_code, $err_msg, $pt));
        //        exit();
        //            $service = phpCAS::getProxiedService(PHPCAS_PROXIED_SERVICE_IMAP);
        //            $service->setServiceUrl('https://onepiece.dsi.univ-paris5.fr/api/');
        //            $service->setMailbox('{imap-i.infr.univ-paris5.fr}INBOX');
        //            $service->setOptions(0);     
        //        $service->open();
        //        var_dump(fgets($tt, 1024));
        //        $sss = "https://castest.univ-paris5.fr/cas/proxyValidate?service=http://onepiece.dsi.univ-paris5.fr/api/&ticket=" . $pass;
        //        phpCAS::setServerProxyValidateURL($sss);
        //        https://castest.univ-paris5.fr/cas/proxyValidate?service=http://onepiece.dsi.univ-paris5.fr/api/&ticket=ST-181-4UbHB9FtJ4wCIo5GSTdi-castest.univ-paris5.fr
        //        phpCAS::forceAuthentication();
        //        var_dump($user);
        var_dump($pass);

        return $pass;
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
                phpCAS::proxy($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], true); //!isset($_SESSION['session_inited'])
                // set URL for PGT callback
                //                $url = $this->url()->fromRoute('pgtcallback', array(), array('force_canonical' => true), true);
                //                $urlPgtCallback = 'https://ent-dev.univ-paris5.fr/api/pgtcallback';
                $urlPgtCallback = 'https://onepiece.dsi.univ-paris5.fr/api/pgtcallback';
                phpCAS::setFixedCallbackURL($urlPgtCallback);
                //
                //                // set PGT storage
                phpCAS::setPGTStorageFile($configCas['cas_pgt_dir']);

                //$pgtBase = '^https:\/\/app[0-9]';
                //                phpCAS::allowProxyChain(
                //                    new \CAS_ProxyChain(
                //                        array('/^https://onepiece.dsi.univ-paris5.fr/api/$/',
                //                            '/^imap://imap.parisdescartes.fr$/'
                //                        )
                //                    )
                //                );
                //                phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,3); 
            } else {
                // Manage the session only the first time
                phpCAS::client($configCas['cas_version'], $configCas['cas_hostname'], $configCas['cas_port'], $configCas['cas_path'], !isset($_SESSION['session_inited']));
            }

            // SLO callback
            //             phpCAS::setPostAuthenticateCallback("handleCasLogin", $old_session);
            //            phpCAS::setSingleSignoutCallback(array($this, "handleSingleLogout"));
            //            // set service URL for authorization with CAS server
            //            $urlServiceUrl = 'https://ent-dev.univ-paris5.fr/api/proxylogin';
            //            $urlServiceUrl = 'https://onepiece.dsi.univ-paris5.fr/api/proxylogin';
            $urlServiceUrl = 'https://onepiece.dsi.univ-paris5.fr/api/';
            phpCAS::setFixedServiceURL($urlServiceUrl);

            //        phpCAS::setServerProxyValidateURL('castest.univ-paris5.fr/cas/proxyValidate');     
            // set SSL validation for the CAS server
            //            if ($configCas['cas_validation'] == 'ca') {
            //                phpCAS::setCasServerCACert($configCas['cas_server_ca_cert_path']);
            //            } else {
            phpCAS::setNoCasServerValidation();
            //            }
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

        //        return new ViewModel();
    }

    public function proxyloginAction()
    {
        $this->getPublicTicket();
        //        exit;
        //        return new ViewModel();
    }

    public function authenticate2()
    {
        $configCas = $this->configCas;

        if ($configCas['cas_debug']) {
            phpCAS::setDebug($configCas['cas_debug_file']);
        }

        phpCAS::proxy($configCas['cas_version'], 'castest.univ-paris5.fr', $configCas['cas_port'], $configCas['cas_path'], true);
        phpCAS::setPGTStorageFile($configCas['cas_pgt_dir']);
        phpCAS::setNoCasServerValidation();

        //        $urlServiceUrl = 'https://onepiece.dsi.univ-paris5.fr/api/';
        //            phpCAS::setFixedServiceURL($urlServiceUrl);

        $auth = phpCAS::isAuthenticated();
        if (!$auth) {
            phpCAS::forceAuthentication();
        }

        $_SESSION['PT'] = phpCAS::retrievePT($configCas['cas_imap_name'], $err_code, $output);
        $pass = $_SESSION['PT'];
        // procedure pour obtenir ou reobtenir un PT
        // force l'authentification si pas authentifié

        var_dump($pass);

        // CONNEXION IMAP avec PT
        if (!empty($_GET['ok'])) {
            //            phpCAS::proxy($configCas['cas_version'], 'castest.univ-paris5.fr', $configCas['cas_port'], $configCas['cas_path'], true);
            //            phpCAS::setPGTStorageFile($configCas['cas_pgt_dir']);
            //            phpCAS::setNoCasServerValidation();
            $auth = phpCAS::isAuthenticated();
            if ($auth) {
                $USER = phpCAS::getUser();
                $CREDENTIAL = $_SESSION['PT'];
                var_dump($USER, $CREDENTIAL);
            } else {
                var_dump("Erreur vous devez deja avoir une session CAS (PT)");
            }
        }

        // SI ON A UN USER ET MDP ON TENTE UNE CONNEXION IMAP
        if (!empty($USER) && !empty($CREDENTIAL)) {
            echo "EXE !!!";
            $messa = "";
            $mbox = @imap_open("{imap-i.infr.univ-paris5.fr}INBOX", $USER, $CREDENTIAL)
                    or
                    die(var_dump(imap_errors()));

            //            $this->inbox = imap_open("{server:993/imap/ssl/novalidate-cert}$inbox", 
            //                           $username, $password, NULL, 1, 
            //                           array('DISABLE_AUTHENTICATOR' => 'PLAIN')) or 
            //                   die(var_dump(imap_errors()));

            $messa = " - PT : $CREDENTIAL";

            if (!$mbox) {
                $err = "Erreur d'ouverture de connexion IMAP.<BR>AVEC :<BR> - USER : $USER$messa<BR>";
            } else {
                $msg = "Ouverture de connexion IMAP OK.<BR>AVEC :<BR> - USER : $USER$messa<BR>";
            }

            var_dump($err, $messa);
        }
    }

    private function getCurrentUrl()
    {
        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost() . $uri->getPath());

        return $base;
    }

}
