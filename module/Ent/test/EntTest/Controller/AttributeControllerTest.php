<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of AttributeControllerTest
 *
 * @author mdjimbi
 */
class AttributeControllerTest extends AbstractControllerTestCase
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
        
        $this->dispatch('/api/attribute');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\attribute');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/attribute');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/attribute-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\attributerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('attribute-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/attribute-rest/2', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\attributerest');
        $this->assertActionName('get');
    }

//    public function testUpdateIsAccessible() {
//        $this->dispatch('/attribute-rest/20', 'PUT', array(
//            'attributeName' => 'test test'
//        ));
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\attributerest');
//        $this->assertActionName('update');
//    }
//    public function testDeleteIsAccessible() {
//        $this->dispatch('/attribute-rest/20', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\attributerest');
//        $this->assertActionName('delete');
//    }
}
