<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ModuleControllerTest extends AbstractControllerTestCase 
{
    
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/module');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\module');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('module');
    }
    
    public function testShowActionContainsWithMock() {
        $mockService = $this->getMockBuilder(\Ent\Service\ModuleDoctrineService::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        //$mockService->expects($this->once())
        $mockService->expects($this->any())
                ->method('getById')
                ->willReturn((new \Ent\Entity\EntModule)
                        ->setModuleId('2')
                        ->setModuleName('testModule')
                        ->setModuleLibelle('testModuleLibelle')
                        ->setModuleDescription('testModuleDescription'));
        
        $this->getApplicationServiceLocator()
                ->setAllowOverride(true)
                ->setService('Ent\Service\ModuleDoctrineService', $mockService);
        
        $this->dispatch('/module/show/2');
        
        $this->assertContains('testModule', $this->getResponse()->getContent());
        $this->assertContains('testModuleLibelle', $this->getResponse()->getContent());
        $this->assertContains('testModuleDescription', $this->getResponse()->getContent());
    }
}
