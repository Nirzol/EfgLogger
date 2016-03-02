<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ActionControllerTest
 *
 * @author mdjimbi
 */
class ActionControllerTest extends AbstractControllerTestCase
{

    /**
     * @var \ZfcRbac\Identity\AuthenticationIdentityProvider
     */
//    protected $identityProvider;

    /**
     * @var \Zend\Authentication\AuthenticationService|\PHPUnit_Framework_MockObject_MockObject
     */
//    protected $authenticationService;
    
    protected $traceError = true;
    
    protected $serviceManager;

    protected function setUp()
    {
//        $this->setApplicationConfig(
//            include '/Users/egrondin/workspace/EntPersonnels/config/application.config.php'
//        );
//
//        parent::setUp();
        
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
        
        $actionService = $this->getMockBuilder(\Ent\Service\ActionDoctrineService::class)->disableOriginalConstructor()->getMock();
        $actionService->expects($this->any())
                ->method('getAll')
                ->will($this->returnValue(array()));
        $this->serviceManager->setService(\Ent\Service\ActionDoctrineService::class, $actionService);

        $this->dispatch('/api/action');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\action');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/action');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/action-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\actionrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('action-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/api/action-rest/3', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\actionrest');
        $this->assertActionName('get');
    }

//    public function testUpdateIsAccessible()
//    {
//        $this->dispatch('/api/action-rest/3', 'PUT', array(
//            'actionName' => 'action name test update',
//            'actionLibelle' => 'action libelle test update',
//            'actionDescription' => 'action description test update'
//        ));
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\actionrest');
//        $this->assertActionName('update');
//        $this->assertContains('true', $this->getResponse()->getContent());
//    }
//    public function testDeleteIsAccessible() {
//        $this->dispatch('/action-rest/3', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\actionrest');
//        $this->assertActionName('delete');
//    }
}
