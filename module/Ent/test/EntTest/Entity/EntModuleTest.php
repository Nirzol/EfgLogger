<?php

namespace EntTest\Entity;

use Ent\Entity\EntModule;
use PHPUnit_Framework_TestCase;

class EntModuleTest extends PHPUnit_Framework_TestCase
{

    protected $module;

    protected function setUp()
    {
        $this->module = new EntModule();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntModule.php';
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
        $this->assertNull($this->module->getModuleId());
        $this->assertNull($this->module->getModuleName());
        $this->assertNull($this->module->getModuleLibelle());
        $this->assertNull($this->module->getModuleDescription());
        $this->assertNull($this->module->getModuleLastUpdate());
    }
}
