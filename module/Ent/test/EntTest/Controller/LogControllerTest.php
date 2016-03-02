<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class LogControllerTest extends AbstractControllerTestCase
{

    protected $traceError = true;
    protected $serviceManager;

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    protected function mockAuthorizationService()
    {
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);

        $authService = $this->getMockBuilder(\ZfcRbac\Service\AuthorizationService::class)->disableOriginalConstructor()->getMock();
        $authService->expects($this->any())
                ->method('isGranted')
                ->will($this->returnValue(true));

        $this->serviceManager->setService(\ZfcRbac\Service\AuthorizationService::class, $authService);
    }

    public function testListActionIsAccessible()
    {
        $this->mockAuthorizationService();
        
        $this->dispatch('/api/log');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\log');
        $this->assertActionName('index');
        $this->assertMatchedRouteName('zfcadmin/log');
    }

    /**
     * Test LogRestController
     */
    public function testUpdateIsAccessible()
    {

        $data = array('logLogin' => 'sebbar', 'logSession' => 'sesion_114578000987',
            'logIp' => '172.88.99.37', 'logUseragent' => 'Agent Firefox', 'fkLogModule' => 3, 'fkLogUser' => 2, 'fkLogAction' => 1);

        $data['logOnline'] = new \DateTime;
        $data['logOffline'] = new \DateTime;
        $data['logDatetime'] = new \DateTime;

        $this->dispatch('/api/log-rest/72', 'PUT', $data);

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
