<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class VersionControllerTest extends AbstractControllerTestCase {

    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    /**************************************
     * 
     * Test du controlleur VersionController
     * 
     */
    
    public function testIndexActionIsAccessible() {
        $this->dispatch('/api/version');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\version');
        $this->assertActionName('index');
        $this->assertMatchedRouteName('version');
    }
    
    /********************************************
     * 
     * Test du controlleur VersionRestController
     * 
     */
    
    public function testGetListIsAccessible() {
        $this->dispatch('/api/version-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\versionrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('version-rest');
    }
    
    public function testGetIsAccessible() {
        $this->dispatch('/api/version-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\versionrest');
        $this->assertActionName('get');
    }

/*    
    public function testUpdateIsAccessible() {

        // Be sur version id = 4 exists in data base
        $this->dispatch('/api/version-rest/update/4', 'PUT', array('version' => '3.3.3-test', 'versionCommentaire' => 'Test Commentaire'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\versionrest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }
*/
//    public function testDeleteIsAccessible() {
//        $this->dispatch('/profile-rest/2', 'DELETE');
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\profilerest');
//        $this->assertActionName('delete');
//    }

}
