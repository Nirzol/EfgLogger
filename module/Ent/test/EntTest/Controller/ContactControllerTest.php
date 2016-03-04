<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ContactControllerTest
 *
 * @author fandria
 */
class ContactControllerTest extends AbstractControllerTestCase
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

        $this->dispatch('/api/contact');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contact');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/contact');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/contact-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contactrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('contact-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/contact-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contactrest');
        $this->assertActionName('get');
    }
}
