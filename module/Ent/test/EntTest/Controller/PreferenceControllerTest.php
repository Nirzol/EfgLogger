<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of PreferenceControllerTest
 *
 * @author mdjimbi
 */
class PreferenceControllerTest extends AbstractControllerTestCase
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

        $this->dispatch('/api/preference');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preference');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/preference');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/preference-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preferencerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('preference-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/preference-rest/23', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preferencerest');
        $this->assertActionName('get');
    }

    public function testUpdateIsAccessible()
    {

        $this->dispatch('/api/preference-rest/22', 'PUT', array('prefAttribute' => 'test preferenceattribute update'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preferencerest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }

//    public function testDeleteIsAccessible() {
//        $this->dispatch('/preference-rest/23', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\preferencerest');
//        $this->assertActionName('delete');
//    }
}
