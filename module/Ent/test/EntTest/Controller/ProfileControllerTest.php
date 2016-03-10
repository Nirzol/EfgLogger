<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ProfileControllerTest
 *
 * @author mdjimbi
 */
class ProfileControllerTest extends AbstractControllerTestCase
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

        $this->dispatch('/api/profile');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profile');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/profile');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/profile-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profilerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('profile-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/profile-rest/2', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profilerest');
        $this->assertActionName('get');
    }

    public function testUpdateIsAccessible()
    {

        $this->dispatch('/api/profile-rest/2', 'PUT', array('profileLdap' => 'testProfileRestUpdate2', 'profileName' => 'profilename update', 'profileLibelle' => 'profilelibelle update', 'profileDescription' => 'module description update'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profilerest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }

//    public function testDeleteIsAccessible() {
//        $this->dispatch('/profile-rest/2', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\profilerest');
//        $this->assertActionName('delete');
//    }
}
