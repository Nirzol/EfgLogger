<?php

namespace EfgLogger\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


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
        $this->logger->addExtra(array(
            'log_login' => 'mylogin',
            'log_action' => 1,
            'log_action_name' => 'log_action_name'));
        $this->logger->Info('Log this please!');

        return new ViewModel();
    }
}
