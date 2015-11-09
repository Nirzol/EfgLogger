<?php

namespace Owa\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of OwaRestController
 *
 * @author fandria
 */
class OwaRestController extends AbstractRestfulController {
    public function __construct()
    {
        
    }

    public function getList()
    {
        $data = 'owa controller';
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'data' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
    
    public function getMailNotifAction() {
        $data = 200;
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'number' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
    
    public function getCalendarNotifAction() {
        $data = 10;
        $success = true;
        $successMessage = 'ok';
        $errorMessage = '';
        
        return new JsonModel(array(
            'number' => $data,
            'success' => $success,
            'flashMessages' => array(
                'success' => $successMessage,
                'error' => $errorMessage,
            ),
        ));
    }
}
