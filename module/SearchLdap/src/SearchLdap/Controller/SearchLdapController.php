<?php

namespace SearchLdap\Controller;

use SearchLdap\Model\SearchLdap;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class SearchLdapController extends AbstractRestfulController {
    
    // methode liste, ex : "/search"
    protected $collectionMethod = array('GET');
    
    // methode unitaire, ex : "/search/mdjimbi"
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');
    
    /* @var $searchLdapModel SearchLdap */
    protected $searchLdapModel;

    public function __construct(SearchLdap $searchLdapModel) {
        $this->searchLdapModel = $searchLdapModel;
    }

    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkMethod'), 10);
    }

    protected function _getMethod() {
        if ($this->params()->fromRoute('slug', false)) {
            return $this->ressourceMethod;
        }
        return $this->collectionMethod;
    }

    public function checkMethod($e) {
        $this->setIdentifierName('slug');
        if (in_array($e->getRequest()->getMethod(), $this->_getMethod())) {            
            return;
        }
        
        $response = $this->getResponse();
        $response->setStatusCode(405);
        return $response;
    }

    public function options() {
        $response = $this->getResponse();
        $response->getHeaders()
                ->addHeaderLine('Allow', implode(',', $this->_getMethod()));
        return $response;
    }

    public function getList() {
        $data = 0;

        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function get($slug) {
        $ldap = $this->searchLdapModel;
        
        $search = $ldap->searchUser($slug);
        
        return new JsonModel(array(
            'data' => $search
        ));
    }
    
    public function getUser($slug) {
        $ldap = $this->searchLdapModel;
        
        $search = $ldap->searchUser($slug);
        
        return $search;
    }
}
