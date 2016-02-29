<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * Description of ServiceControllerTest
 *
 * @author fandria
 */
class ServiceControllerTest extends AbstractControllerTestCase
{

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    public function testListActionIsAccessible()
    {
        $this->dispatch('/service');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\service');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('service');
    }

    public function testGetListIsAccessible()
    {
        $this->dispatch('/service-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\servicerest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('service-rest');
    }

    public function testGetIsAccessible()
    {
        $this->dispatch('/service-rest/1', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\servicerest');
        $this->assertActionName('get');
    }

}
