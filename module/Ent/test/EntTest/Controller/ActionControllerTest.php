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
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/action');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\action');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('action');
    }

    public function testGetListIsAccessible() {
        $this->dispatch('/action-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\actionrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('action-rest');
    }

    public function testGetIsAccessible() {
        $this->dispatch('/action-rest/3', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\actionrest');
        $this->assertActionName('get');
    }

    public function testUpdateIsAccessible() {

        $this->dispatch('/action-rest/3', 'PUT', array(
            'actionName' => 'action name test update', 
            'actionLibelle' => 'action libelle test update',
            'actionDescription' => 'action description test update'
            ));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\actionrest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
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
