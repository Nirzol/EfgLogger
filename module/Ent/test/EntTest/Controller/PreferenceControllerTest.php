<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of PreferenceControllerTest
 *
 * @author mdjimbi
 */
class PreferenceControllerTest extends AbstractControllerTestCase {

    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/preference');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preference');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('preference');
    }

    public function testGetListIsAccessible() {
        $this->dispatch('/preference-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preferencerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('preference-rest');
    }

    public function testGetIsAccessible() {
        $this->dispatch('/preference-rest/23', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\preferencerest');
        $this->assertActionName('get');
    }

    public function testUpdateIsAccessible() {

        $this->dispatch('/preference-rest/22', 'PUT', array('prefAttribute' => 'test preferenceattribute update'));

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
