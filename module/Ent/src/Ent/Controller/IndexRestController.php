<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

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
        } else {
            $is_logged = false;
        }
        
        return new JsonModel(array(
            'is_logged' => $is_logged
        ));
    }
}
