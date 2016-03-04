<?php

namespace EntTest\Entity;

class EntUserTest extends \PHPUnit_Framework_TestCase
{

    protected $user;

    // Appelée avant chaque test cette classe
    protected function setUp()
    {
        $this->user = new \Ent\Entity\EntUser();
    }

    // Va être appelée une fois avant l'exécution des tests
    // de cette classe
    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntUser.php';
    }

    // après chaque test de cette classe
    protected function tearDown()
    {
        parent::tearDown();
    }

    // à la fin de tous les tests de cette classe
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function testInitValuesAreNull()
    {
        $this->assertNull($this->user->getUserId());
        $this->assertNull($this->user->getUserLastConnection());
        $this->assertNull($this->user->getUserLogin());
        $this->assertEquals('1', $this->user->getUserStatus());
        $this->assertEmpty($this->user->getFkUcContact());
        $this->assertEmpty($this->user->getFkUpProfile());
        $this->assertEmpty($this->user->getFkUrRole());
    }
}
