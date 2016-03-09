<?php

namespace EfgLogger\Controller;

use Zend\Mvc\Controller\AbstractActionController;

//use Zend\View\Model\ViewModel;

class EfgLoggerController extends AbstractActionController
{

    /**
     *
     * @var \EfgLogger\Service\Logger
     */
    protected $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function indexAction()
    {
//        $this->logger->addExtra(['ipaddress' => '11.22.33.44']);
//        $this->logger->debug("test");
//        var_dump($this->logger);
//        $this->logger->log(\Zend\Log\Logger::INFO, 'HELLOOO');
//        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
//        if ($authService->hasIdentity()) {
//            $userLogin = $authService->getIdentity()->getUserLogin();
        $this->logger->addExtra(array(
            'log_login' => 'egrondin',
//                    'log_session' => 'log_session',
//                    'log_url' => 'log_url',
//                    'log_ip' => 'log_ip',
//                    'log_useragent' => 'log_useragent',
            'log_action' => 1,
            'log_action_name' => 'log_action_name'));
        $this->logger->Info('Log this please!');
//        }

        return new \Zend\View\Model\ViewModel();
    }
}
