<?php

namespace SearchLdapTest\Controller;

use SearchLdapTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use SearchLdap\Controller\SearchLdapController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class SearchLdapControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new SearchLdapController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'getList'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }
    
    public function testGetListCanBeAccessed() {
        $result = $this->controller->dispatch($this->request);
       
        /* @var $response Response */
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetCanBeAccessed() {
        $this->routeMatch->setParam('slug', 'mdjimbi');
        
        $result = $this->controller->dispatch($this->request);
        /* @var $response Response */
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    
}
