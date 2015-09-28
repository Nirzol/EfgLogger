<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class LogControllerTest extends AbstractControllerTestCase 
{
    
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/api/log');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\log');
        $this->assertActionName('index');
        $this->assertMatchedRouteName('log');
    }

    /**
     * Test LogRestController 
     */
    
    public function testUpdateIsAccessible() {
        
        $data = array('logLogin' => 'sebbar','logSession' => 'sesion_114578000987',
                    'logIp' => '172.88.99.37','logUseragent' => 'Agent Firefox','fkLogModule' => 3,'fkLogUser' => 2,'fkLogAction' => 1);
        
        $data['logOnline'] = new \DateTime;
        $data['logOffline'] = new \DateTime;
        $data['logDatetime'] = new \DateTime;
        
        $this->dispatch('/api/log-rest/9', 'PUT', $data);
        
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\logrest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }
    
//    public function testDeleteIsAccessible() {
//        $this->dispatch('/api/log-rest/2', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\logrest');
//        $this->assertActionName('delete');
//    }
}
