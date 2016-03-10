<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of StatusControllerTest
 *
 * @author mdjimbi
 */
class StatusControllerTest extends AbstractControllerTestCase
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

        $this->dispatch('/api/status');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\status');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/status');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/status-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\statusrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('status-rest');
    }

    public function testUpdateIsAccessible()
    {

        $this->dispatch(
            '/api/status-rest/1',
            'PUT',
            array(
                'statusName' => 'testStatusRestUpdate',
                'statusLibelle' => 'libelle update',
                'statusDescription' => 'description update'
            )
        );

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\statusrest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }

//    public function testDeleteIsAccessible() {
//        $this->dispatch('/status-rest/1', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\statusrest');
//        $this->assertActionName('delete');
//    }
}
