<?php

namespace EntTest\Controller;

//use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ActionControllerTest
 *
 * @author mdjimbi
 */
class ActionControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Controller $controller
     */
    protected $controller;
    protected $pluginManager;
    public $pluginManagerPlugins = array();
    protected $zfcRbacAuthorizationService;
//    protected $options;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Ent\Service\ActionDoctrineService
     */
    protected $actionDoctrineService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Ent\Form\ActionForm
     */
    protected $actionForm;

    /**
     * @var Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceManager;

    protected function setUp()
    {
        $this->actionDoctrineService = $this->prophesize(\Ent\Service\ActionDoctrineService::class);

        $this->actionForm = $this->prophesize(\Ent\Form\ActionForm::class);

        $controller = new \Ent\Controller\ActionController($this->actionDoctrineService->reveal(), $this->actionForm->reveal());
        $this->controller = $controller;

        $this->zfcRbacAuthorizationService = $this->prophesize(\ZfcRbac\Service\AuthorizationService::class);

        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManager->expects($this->any())
                ->method('get')
                ->will($this->returnCallback(array($this, 'helperMockCallbackPluginManagerGet')));
        
//        $pluginManager = $this->prophesize(\Zend\Mvc\Controller\PluginManager::class)->addMethodProphecy(array('get'));
//        $pluginManager->get()->willReturn(array($this, 'helperMockCallbackPluginManagerGet'))->shouldBeCalled();

        $this->pluginManager = $pluginManager;

        $controller->setPluginManager($pluginManager);
    }

    public function setUpZfcUserAuthenticationPlugin($option)
    {
        if (array_key_exists('isGranted', $option)) {
            $return = (is_callable($option['isGranted'])) ? $this->returnCallback($option['isGranted']) : $this->returnValue($option['isGranted']);
            $this->zfcRbacAuthorizationService->isGranted()->willReturn(true)->shouldBeCalledTimes(0);
        }
//        if (array_key_exists('getAuthAdapter', $option)) {
//            $return = (is_callable($option['getAuthAdapter'])) ? $this->returnCallback($option['getAuthAdapter']) : $this->returnValue($option['getAuthAdapter']);
//            $this->zfcUserAuthenticationPlugin->expects($this->any())
//                    ->method('getAuthAdapter')
//                    ->will($return);
//        }
//        if (array_key_exists('getAuthService', $option)) {
//            $return = (is_callable($option['getAuthService'])) ? $this->returnCallback($option['getAuthService']) : $this->returnValue($option['getAuthService']);
//            $this->zfcUserAuthenticationPlugin->expects($this->any())
//                    ->method('getAuthService')
//                    ->will($return);
//        }
        $this->pluginManagerPlugins['isGranted'] = $this->zfcRbacAuthorizationService;
        return $this->zfcRbacAuthorizationService;
    }

    public function testListActionIsAccessible()
    {
        /* @var $controller \Ent\Controller\ActionController */
        $controller = $this->controller;

        $this->setUpZfcUserAuthenticationPlugin(array(
            'isGranted' => true
        ));

        $result = $controller->listAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function helperMockCallbackPluginManagerGet($key)
    {
        if ($key == "flashMessenger" && !array_key_exists($key, $this->pluginManagerPlugins)) {
//             echo "\n\n";
//             echo '$key: ' . $key . "\n";
//             var_dump(array_key_exists($key, $this->pluginManagerPlugins), array_keys($this->pluginManagerPlugins));
//             exit;
        }
        return (array_key_exists($key, $this->pluginManagerPlugins)) ? $this->pluginManagerPlugins[$key] : null;
    }


//    public function testListActionIsAccessible()
//    {
//
//        $this->mockAuthorizationService();
//        
//        $actionService = $this->getMockBuilder(\Ent\Service\ActionDoctrineService::class)->disableOriginalConstructor()->getMock();
//        $actionService->expects($this->any())
//                ->method('getAll')
//                ->will($this->returnValue(array()));
//        $this->serviceManager->setService(\Ent\Service\ActionDoctrineService::class, $actionService);
//
//        $this->dispatch('/api/action');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\action');
//        $this->assertActionName('list');
//        $this->assertMatchedRouteName('zfcadmin/action');
//    }
//    public function testGetListIsAccessible()
//    {
//        $this->dispatch('/api/action-rest');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\actionrest');
//        $this->assertActionName('getList');
//        $this->assertMatchedRouteName('action-rest');
//    }
//    public function testGetIsAccessible()
//    {
//        $this->dispatch('/api/action-rest/3', 'GET');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\actionrest');
//        $this->assertActionName('get');
//    }
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
