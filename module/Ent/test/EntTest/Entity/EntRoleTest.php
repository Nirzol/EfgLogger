<?php

namespace EntTest\Entity;

use Ent\Entity\EntHierarchicalRole;
use PHPUnit_Framework_TestCase;

class EntRoleTest extends PHPUnit_Framework_TestCase
{

    protected $role;

    protected function setUp()
    {
        $this->role = new EntHierarchicalRole();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntHierarchicalRole.php';
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
        $this->assertNull($this->role->getId());
        $this->assertNull($this->role->getName());
        $this->assertNull($this->role->getlastUpdate());
    }
}
