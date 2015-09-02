<?php

namespace EntTest\Controller;

/**
 * Description of ContactControllerTest
 *
 * @author fandria
 */
class ContactControllerTest extends AbstractControllerTestCase{
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible() {
        $this->dispatch('/contact');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contact');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('contact');
    }
    
    public function testGetListIsAccessible()
    {
        $this->dispatch('/contact-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contactrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('contact-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/contact-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\contactrest');
        $this->assertActionName('get');
    }
}
