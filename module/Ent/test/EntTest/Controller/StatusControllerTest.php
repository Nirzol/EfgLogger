<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of StatusControllerTest
 *
 * @author mdjimbi
 */
class StatusControllerTest extends AbstractControllerTestCase
{
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/status');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\status');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('status');
    }
    
    public function testGetListIsAccessible() {
        $this->dispatch('/status-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\statusrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('status-rest');
    }
}
