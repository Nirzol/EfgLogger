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
    protected $identityProvider;

    /**
     * @var \Zend\Authentication\AuthenticationService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $authenticationService;
    protected $traceError = true;

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');

        $this->authenticationService = $this->getMock('Zend\Authentication\AuthenticationService');
        $this->identityProvider = new \ZfcRbac\Identity\AuthenticationIdentityProvider($this->authenticationService);



//        $authorizationService = $this->getMock('ZfcRbac\Service\AuthorizationServiceInterface');
//        $authorizationService->expects($this->any())
//                             ->method('isGranted')
//                             ->with('list_action')
//                             ->will($this->returnValue(true));
    }

    protected function mockLogin()
    {
        $userSessionModel = new \Ent\Entity\EntUser();
        $userSessionModel->setUserId(16);
        $userSessionModel->setUserLogin('egrondin');

//        $userSessionModel = true;

        $authService = $this->getMock('Zend\Authentication\AuthenticationService');
        $authService->expects($this->any())
                ->method('getIdentity')
                ->will($this->returnValue($userSessionModel));

        $authService->expects($this->any())
                ->method('hasIdentity')
                ->will($this->returnValue(true));

        $authorizationService = $this->getMock('ZfcRbac\Service\AuthorizationServiceInterface');
        $authorizationService->expects($this->any())
                ->method('isGranted')
                ->with('list_action')
                ->will($this->returnValue(true));

        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService('Zend\Authentication\AuthenticationService', $authService);
        $this->getApplicationServiceLocator()->setService('ZfcRbac\Service\AuthorizationServiceInterface', $authorizationService);

//        $roleService = $this->getApplicationServiceLocator()->get('ZfcRbac\Service\RoleService');
//        new \ZfcRbac\Service\RoleService();
    }

    public function testListActionIsAccessible()
    {
        $this->mockLogin();

        $this->dispatch('/api/action');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\action');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('action');
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

    public function testUpdateIsAccessible()
    {

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
    }

//    public function testDeleteIsAccessible() {
//        $this->dispatch('/action-rest/3', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\actionrest');
//        $this->assertActionName('delete');
//    }
}
