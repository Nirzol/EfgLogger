<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    /**
     * @var RoleForm
     */
    protected $roleForm = null;
    
    public function __construct(\Ent\Service\RoleDoctrineService $roleService, \Ent\Form\RoleForm $roleForm)
    {
        $this->roleService = $roleService;
        $this->roleForm = $roleForm;
    }
    
    public function listAction()
    {
        $roles = $this->roleService->getAll();

        return new ViewModel(array(
            'roles' => $roles,
        ));
    }


}

