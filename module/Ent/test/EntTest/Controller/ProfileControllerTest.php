<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ProfileControllerTest
 *
 * @author mdjimbi
 */
class ProfileControllerTest extends AbstractControllerTestCase {

    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/profile');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profile');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('profile');
    }

    public function testGetListIsAccessible() {
        $this->dispatch('/profile-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profilerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('profile-rest');
    }

    public function testGetIsAccessible() {
        $this->dispatch('/profile-rest/2', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\profilerest');
        $this->assertActionName('get');
    }

    public function testUpdateIsAccessible() {

        $this->dispatch('/profile-rest/2', 'PUT', array('profileLdap' => 'testProfileRestUpdate', 'profileName' => 'profilename update', 'profileLibelle' => 'profilelibelle update', 'profileDescription' => 'module description update'));

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
