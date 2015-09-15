<?php

namespace Ent\Controller;

use Ent\Service\GenericEntityServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VersionController extends AbstractActionController
{

    protected $service = null;

    public function __construct(GenericEntityServiceInterface $iservice)
    {
        $this->service = $iservice;
    }

    public function indexAction()
    {
        $versions = $this->service->getAll();

        return new ViewModel(array(
            'listVersions' => $versions
        ));
    }

}

