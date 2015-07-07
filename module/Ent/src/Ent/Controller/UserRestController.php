<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserRestController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

