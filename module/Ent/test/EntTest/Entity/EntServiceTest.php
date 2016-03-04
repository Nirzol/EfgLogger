<?php

namespace EntTest\Entity;

use Ent\Entity\EntService;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntServiceTest
 *
 * @author fandria
 */
class EntServiceTest extends PHPUnit_Framework_TestCase
{

    protected $service;

    protected function setUp()
    {
        $this->service = new EntService();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntService.php';
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function testInitValuesAreNull()
    {
        $this->assertNull($this->service->getServiceId());
        $this->assertNull($this->service->getServiceName());
        $this->assertNull($this->service->getServiceLibelle());
        $this->assertNull($this->service->getServiceDescription());
        $this->assertNull($this->service->getServiceLastUpdate());
    }
}
