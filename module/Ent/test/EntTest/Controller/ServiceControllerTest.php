<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ServiceControllerTest
 *
 * @author fandria
 */
class ServiceControllerTest extends AbstractControllerTestCase
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
        
        $this->dispatch('/api/service');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\service');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/service');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/service-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\servicerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('service-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/service-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\servicerest');
        $this->assertActionName('get');
    }

}
