<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of StructureControllerTest
 *
 * @author fandria
 */
class StructureControllerTest extends AbstractControllerTestCase
{

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/structure-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\structurerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('structure-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/structure-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\structurerest');
        $this->assertActionName('get');
    }

}
