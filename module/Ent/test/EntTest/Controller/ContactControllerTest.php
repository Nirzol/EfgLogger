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
}
