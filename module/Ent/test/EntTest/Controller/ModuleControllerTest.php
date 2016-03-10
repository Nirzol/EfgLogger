<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ModuleControllerTest extends AbstractControllerTestCase
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

        $this->dispatch('/api/module');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\module');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/module');
    }

    public function testShowActionContainsWithMock()
    {
        $mockService = $this->getMockBuilder(\Ent\Service\ModuleDoctrineService::class)
            ->disableOriginalConstructor()
            ->getMock();

        //$mockService->expects($this->once())
        $mockService->expects($this->any())
            ->method('getById')
            ->willReturn((new \Ent\Entity\EntModule)
                ->setModuleId('2')
                ->setModuleName('permissionController')
                ->setModuleLibelle('Permission Controller')
                ->setModuleDescription('Permission Controller'));

        $this->getApplicationServiceLocator()
            ->setAllowOverride(true)
            ->setService('Ent\Service\ModuleDoctrineService', $mockService);

        $this->dispatch('/api/module/2');

        $this->assertContains('testModule', $this->getResponse()->getContent());
        $this->assertContains('testModuleLibelle', $this->getResponse()->getContent());
        $this->assertContains('testModuleDescription', $this->getResponse()->getContent());
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/module-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\modulerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('module-rest');
    }

    public function testUpdateIsAccessible()
    {

        $this->dispatch('/api/module-rest/6', 'PUT', array('moduleName' => 'testModuleRestUpdate', 'moduleLibelle' => 'module libelle update', 'moduleDescription' => 'module description update'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\modulerest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }

//    public function testDeleteIsAccessible() {
//        $this->dispatch('/api/module-rest/2', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\modulerest');
//        $this->assertActionName('delete');
//    }
}
